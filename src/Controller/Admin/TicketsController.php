<?php
namespace App\Controller\Admin;

use Cake\Mailer\Email;


class TicketsController extends AppController
{
    /**
     * Index all tickets
     */
    public function index()
    {
        $data = $this->DataTables->find('Tickets', 'all', [
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
     * Index tickets to print
     */
    public function print()
    {
        if (
            (
                $this->request->is('json') ||
                $this->request->is('post')
            ) &&
            !empty($this->request->data['action'])
        ) {
            switch ($this->request->data['action']) {
                case 'validate':
                    // Step 1 - Validate: find the tickets barcodes
                    if (!empty($this->request->data['count'])) {
                        $barcodes = $this->Tickets->find('list', [
                            'keyField' => 'id',
                            'valueField' => 'barcode',
                            'conditions' => [
                                'paid' => true,
                                'state' => 'pending'
                            ],
                            'limit' => $this->request->data['count']
                        ])->toArray();

                        $barcodesStr = implode(',', array_values($barcodes));
                        $this->set([
                            'barcodesStr' => $barcodesStr,
                            '_serialize' => ['barcodesStr']
                        ]);
                    }
                    break;
                case 'finish':
                    // Step 3 - Finish:update tickets
                    if (!empty($this->request->data['barcodesStr'])) {
                        $barcodes = explode(',', $this->request->data['barcodesStr']);

                        $this->Tickets->updateAll(['state' => 'printed'], ['barcode IN' => $barcodes]);

                        $this->Flash->success('Vous avez validé la procédure d\'impression pour ' . count($barcodes) . ' tickets !');


                        $this->set(array_merge_recursive($this->viewVars['stats']), [
                            'stats' => [
                                'tickets' => [
                                    'pending' => $this->Tickets->find('all')->where(['paid' => true, 'state' => 'pending'])->count()
                                ]
                            ]
                        ]);
                    }
            }
        } // PDF generation
        else if ($this->request->params['_ext'] == 'pdf') {
            $codes = explode(',', $this->request->query['codes']);

            if (!empty($codes)) {
                $this->viewBuilder()->layout('tickets');

                $tickets = $this->Tickets->find('all', [
                    'conditions' => [
                        'barcode IN' => $codes
                    ]
                ])->toArray();

                $this->set(compact('tickets'));
            }
        }
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
}