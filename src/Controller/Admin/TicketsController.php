<?php
namespace App\Controller\Admin;

class TicketsController extends AppController
{
    public function index()
    {
        $data = $this->DataTables->find('tickets', 'all', [
            'contain' => [
                'Users'
            ],
            'conditions' => [
                'id >' => 0 // Bug
            ]
        ]);

        $this->set([
            'data' => $data,
            '_serialize' => array_merge($this->viewVars['_serialize'], ['data'])
        ]);
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
            $this->Flash->success('Le ticket a bien été suppprimé');
        } else {
            $this->Flash->error('Erreur lors de la suppression du code d\'accès');
        }

        $this->redirect(['action' => 'index']);
    }

    public function print()
    {
        $codes = explode(',', $this->request->query['codes']);

        if (!empty($codes)) {
            $this->viewBuilder()->layout('pdf_ticket');

            $tickets = $this->Tickets->find('all', [
                'conditions' => [
                    'barcode IN' => $codes
                ]
            ])->toArray();

            //$this->response->type('pdf');
            $this->set(compact('tickets'));
        }
    }
}