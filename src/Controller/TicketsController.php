<?php
namespace App\Controller;

use App\Model\Entity\Ticket;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\Mailer\Email;
use Cake\ORM\TableRegistry;
use mikehaertl\wkhtmlto\Pdf;

/**
 * Tickets Controller
 *
 * @author Mathieu Bour <mathieu.tin.bour@gmail.com>
 *
 * @property \App\Model\Table\TicketsTable $Tickets
 * @property \App\Controller\Component\PayPalComponent $PayPal
 */
class TicketsController extends AppController
{
    /**
     * Engage a PayPal payment
     * @param int $ticketId the ticket id
     * @return void
     */
    protected function _engagePayPalProcess(int $ticketId): void
    {
        $this->loadComponent('PayPal'); // Load PayPal

        // PayPal process
        if ($this->PayPal->SetExpressCheckout()) {
            $this->request->session()->write('ticket.id', $ticketId);
            $this->redirect($this->request->session()->read('SetExpressCheckoutResult.REDIRECTURL'));
        } else {
            $this->Flash->error('Problème lors de la génération du lien PayPal');
        }
    }

    /**
     * Determine if the user is allowed to book a ticket
     * @return bool
     */
    protected function _canBook(): bool {
        $now = new Time();
        $prebookDate = new Time($this->Settings->read('prebook_opening_date'));
        $bookDate = new Time($this->Settings->read('book_opening_date'));

        // Before prebook opening date: no access
        if($now < $prebookDate) {
            $this->Flash->error('La billeterie n\'est pas encore ouverte !');
            return false;
        }

        // If all tickets are already booked
        if ((int)$this->Settings->read('tickets_left') <= 0) {
            $this->Flash->error('Tous les tickets ont été vendus !');
            return false;
        }

        // After prebook opening date but before public opening date: access with code only
        if ($now > $prebookDate && $now < $bookDate) {
            $this->set(['preBooking', true]);
        }

        return true;
    }

    /**
     * Book method
     */
    public function book()
    {
        $now = new Time();
        $early = new Time($this->Settings->read('opening_early'));
        $global = new Time($this->Settings->read('opening_global'));

        // Prevent user to access to the ticketing
        if ($this->Settings->read('ticketing') != '1') {
            $this->Flash->error('La billeterie est fermée !');
            return $this->redirect('/');
        } else if ($now < $early) {
            $this->Flash->error('La billeterie n\'est pas encore ouverte !');
            return $this->redirect('/');
        } else if ((int)$this->Settings->read('tickets_left') <= 0) {
            $this->Flash->error('Tous les tickets ont été vendus !');
            return $this->redirect('/');
        }

        // Ticket has valid informations
        if ($this->request->is('post')) {
            /**
             * @var Ticket $ticket
             */
            $ticket = $this->Tickets->newEntity($this->request->data);

            if (empty($ticket->errors())) {

                // Generate random barcode
                $ticket->barcode = rand(100000000, 999999999);

                // Get address coords
                $prepAddr = str_replace(' ', '+', $ticket->address . ' ' . $ticket->zip_code . ' ' . $ticket->city);
                $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false&key=AIzaSyDDsLpHUkMF5buf-9tGWOTk1qdzmQblZaY');
                $output = json_decode($geocode);

                if (!empty($output->results)) {
                    $ticket->latitude = $output->results[0]->geometry->location->lat;
                    $ticket->longitude = $output->results[0]->geometry->location->lng;
                } else {
                    $ticket->latitude = $ticket->longitude = null;
                }

                if ($this->Tickets->save($ticket)) {
                    // If an early case has been used
                    /*if (!empty($earlyCode)) {
                        $earlyCode->remaining_uses--;
                        $this->EarlyCodes->save($earlyCode);
                    }*/

                    // Send confirmation e-mail
                    Email::configTransport('beminimalist', [
                        'host' => 'web01.point-blank.fr',
                        'port' => 25,
                        'username' => 'contact@beminimalist.fr',
                        'password' => '14021997',
                        'className' => 'Smtp'
                    ]);

                    $email = new Email();
                    $email->transport('beminimalist');
                    $email
                        ->viewVars(compact('ticket'))
                        ->template('book')
                        ->emailFormat('text')
                        ->from(['contact@beminimalist.fr' => 'Minimalist'])
                        ->to($ticket->email)
                        ->subject('Gala d\'hiver 2016')
                        ->send();

                    // Update tickets_left setting
                    $this->Settings->write('tickets_left', (int)$this->Settings->read('tickets_left') - 1);

                    if ($ticket->type == 'paypal') {
                        $this->loadComponent('PayPal');
                        // PayPal process
                        if ($this->PayPal->SetExpressCheckout()) {
                            $this->request->session()->write('ticket.id', $ticket->id);
                            $this->redirect($this->request->session()->read('SetExpressCheckoutResult.REDIRECTURL'));
                        }
                    } else {
                        return $this->redirect(['controller' => 'tickets', 'action' => 'success']);
                    }
                }
            } else {
                $this->Flash->error('Veuillez vérifier les informations soumises ; tous les champs sont obligatoires, excepté le code vendeur !');
            }
        }
    }

    public function check()
    {
        if ($this->request->is('post')) {
            if (!empty($this->request->data['email'])) {
                $tickets = $this->Tickets->find('all')->where(['email' => $this->request->data['email']]);
                $this->set(compact('tickets'));
            } else if (!empty($this->request->data['id'])) {
                if($this->Tickets->exists(['id' => $this->request->data['id']])) {
                    $this->_engagePayPalProcess($this->request->data['id']);
                }
            }
        } else {
            $this->viewBuilder()->layout('admin_centred');
            $this->render('check_email');
        }
    }

    /**
     * Success method
     */
    public function success()
    {
        $ticketId = $this->request->session()->read('ticket.id');

        if (!empty($ticketId)) {
            $this->loadComponent('PayPal');

            if ($this->PayPal->DoExpressCheckoutPayment()) {
                $ticket = $this->Tickets->find('all')->where(['id' => $ticketId])->first();
                $ticket->paid = true;
                $this->Tickets->save($ticket);
                $this->request->session()->delete('ticket.id');
            } else {
                $this->request->session()->delete('ticket.id');
                $this->redirect('/');
            }

            $this->render('success-paypal');
        } else {
            $this->render('success-perm');
        }
    }
}
