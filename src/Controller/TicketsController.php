<?php
namespace App\Controller;

use App\Model\Entity\Ticket;
use Cake\I18n\Time;
use Cake\Mailer\Email;

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
     * Book method
     * Book a ticket
     */
    public function book()
    {
        // Protect pages against unauthorized requests
        if (!$this->_canBook()) {
            return $this->redirect('/');
        }

        // Ticket has valid informations
        if ($this->request->is('post')) {
            /** @var Ticket $ticket */
            $ticket = $this->Tickets->newEntity($this->request->data);

            if($ticket->type == 'perm') {
                $this->Flash->error('La réservatioon par permanence est indisponible');
                return null;
            }

            if (empty($ticket->errors())) {
                if ($this->Tickets->save($ticket)) {
                    // Send confirmation e-mail
                    $email = new Email();
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
                        $this->_engagePayPalProcess($ticket->id);
                    } else {
                        return $this->redirect(['controller' => 'tickets', 'action' => 'success']);
                    }
                }
            } else {
                $this->Flash->error('Veuillez vérifier les informations soumises ; tous les champs sont obligatoires, excepté le code vendeur !');
            }
        }

        return null;
    }

    /**
     * Check method
     * Allow user to continue the payment process
     */
    public function check()
    {
        if ($this->request->is('post')) {
            if (!empty($this->request->data['email'])) {
                $tickets = $this->Tickets->find('all')->where(['email' => $this->request->data['email']]);
                $this->set(compact('tickets'));
            } else if (!empty($this->request->data['id'])) {
                if ($this->Tickets->exists(['id' => $this->request->data['id']])) {
                    $this->_engagePayPalProcess($this->request->data['id']);
                }
            }
        } else {
            $this->viewBuilder()->layout('default_centred');
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

    /* = Utils
     * =========================================================== */

    /**
     * Engage a PayPal payment
     * @param int $ticketId the ticket id
     * @return void
     */
    protected function _engagePayPalProcess(int $ticketId)
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
    protected function _canBook(): bool
    {
        $now = new Time();
        $prebookDate = new Time($this->Settings->read('prebook_opening_date'));
        $bookDate = new Time($this->Settings->read('book_opening_date'));

        // Before prebook opening date: no access
        if ($now < $prebookDate) {
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
}
