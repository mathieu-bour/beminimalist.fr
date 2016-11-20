<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\I18n\Time;

/**
 * Tickets Controller
 *
 * @property \App\Model\Table\TicketsTable $Tickets
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


    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $tickets = $this->paginate($this->Tickets);

        $this->set(compact('tickets'));
        $this->set('_serialize', ['tickets']);
    }

    /**
     * View method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $ticket = $this->Tickets->get($id, [
            'contain' => []
        ]);

        $this->set('ticket', $ticket);
        $this->set('_serialize', ['ticket']);
    }


    /**
     * Edit method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $ticket = $this->Tickets->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $ticket = $this->Tickets->patchEntity($ticket, $this->request->data);
            if ($this->Tickets->save($ticket)) {
                $this->Flash->success(__('The ticket has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The ticket could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('ticket'));
        $this->set('_serialize', ['ticket']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Ticket id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $ticket = $this->Tickets->get($id);
        if ($this->Tickets->delete($ticket)) {
            $this->Flash->success(__('The ticket has been deleted.'));
        } else {
            $this->Flash->error(__('The ticket could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
