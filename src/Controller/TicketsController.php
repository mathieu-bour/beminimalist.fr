<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\I18n\Time;

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
        // Prevent user to enter before opening date
        if(new Time() < Configure::read('opening')) {
            $this->redirect('/');
        }

        $ticket = $this->Tickets->newEntity();

        if ($this->request->is('post')) {
            $ticket = $this->Tickets->patchEntity($ticket, $this->request->data);

            if ($this->Tickets->save($ticket)) {
                if ($ticket->type == 'PAYPAL') {
                    $this->loadComponent('PayPal');
                    // PayPal process
                    if($this->PayPal->SetExpressCheckout()) {
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
    public function success() {
        $ticketId = $this->request->session()->read('ticket.id');

        if(!empty($ticketId)) {
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
