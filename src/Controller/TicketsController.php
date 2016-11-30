<?php
namespace App\Controller;

use App\Model\Entity\Ticket;
use Cake\Core\Configure;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use mikehaertl\wkhtmlto\Pdf;

/**
 * Tickets Controller
 *
 *
 * @property \App\Model\Table\TicketsTable $Tickets
 * @property \App\Controller\Component\PayPalComponent $PayPal
 */
class TicketsController extends AppController
{
    /**
     * Book method
     */
    public function book()
    {
        $now = new Time();

        // Prevent user to access to the ticketing
        if($this->Settings->read('ticketing') != '1') {
            $this->Flash->error('La billeterie est fermée !');
            return $this->redirect('/');
        } else if ($now < new Time($this->Settings->read('opening_early'))) {
            $this->Flash->error('La billeterie n\'est pas encore ouverte !');
            return $this->redirect('/');
        } else if((int)$this->Settings->read('tickets_left') <= 0) {
            $this->Flash->error('Tous les tickets ont été vendus !');
            return $this->redirect('/');
        }

        if ($this->request->is('post')) {
            /**
             * @var Ticket $ticket
             */
            $ticket = $this->Tickets->newEntity($this->request->data);

            if($ticket->errors()) {
                $this->Flash->error(implode('<br>', $ticket));
            }

            if ($now < new Time($this->Settings->read('opening_global'))) {
                if(empty($ticket->early_code)) {
                    $this->Flash->error('Un code d\'accès est nécessaire !');
                    $this->redirect(['action' => 'book']);
                } else {
                    $this->EarlyCodes = TableRegistry::get('EarlyCodes');
                    $earlyCode = $this->EarlyCodes->find('all')->where(['code' => $ticket->early_code])->first();

                    if (empty($earlyCode)) {
                        $this->Flash->error('Ce code n\'existe pas');
                        $this->redirect(['action' => 'book']);
                    } else if ($earlyCode->expire < $now) {
                        $this->Flash->error('Ce code a expiré');
                        $this->redirect(['action' => 'book']);
                    } else if ($earlyCode->remaining_uses == 0) {
                        $this->Flash->error('Ce code a attenit sa limite d\'utilisation');
                        $this->redirect(['action' => 'book']);
                    }
                }
            }

            // Generate random barcode
            $ticket->barcode = rand(100000000, 999999999);

            if ($this->Tickets->save($ticket)) {
                // If an early case has been used
                if (!empty($earlyCode)) {
                    $earlyCode->remaining_uses--;
                    $this->EarlyCodes->save($earlyCode);
                }

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
                    $this->redirect(['action' => 'success']);
                }
            }
        }

        $this->set(compact('ticket'));
        $this->set('_serialize', ['ticket']);
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
                $this->redirect('/');
            }

            $this->render('success-paypal');
        } else {
            $this->render('success-perm');
        }
    }
}
