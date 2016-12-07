<?php
namespace App\Controller\Admin;

/**
 * Tickets Admin Controller
 *
 * @author Mathieu Bour <mathieu.tin.bour@gmail.com>
 *
 * @property \App\Model\Table\TicketsTable $Tickets
 */
class TicketsController extends AppController
{
    /**
     * Index all tickets
     */
    public function index()
    {
        // Implements Datables
        $data = $this->DataTables->find('Tickets', 'all', [
            'contain' => [
                'Users'
            ],
            'conditions' => [
                'id >' => 0 // Bug
            ]
        ]);

        $this->setTitle('Tous les tickets');

        $this->set([
            'data' => $data,
            '_serialize' => array_merge($this->viewVars['_serialize'], ['data'])
        ]);
    }

    /**
     * Edit method
     * @param null|int $id
     * @return \Cake\Network\Response|null
     */
    public function edit($id = null)
    {
        $ticket = $this->Tickets->get($id);

        if ($this->request->is(['post', 'put'])) {
            $this->Tickets->patchEntity($ticket, $this->request->data);
            if ($this->Tickets->save($ticket)) {
                $this->Flash->success('Ticket mis à jour');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Erreur lors de la mise à jour de l\'article');
        }

        $this->setTitle('Édition de ticket');

        $this->set('ticket', $ticket);
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
            if(!$this->request->is('json')) {
                $this->Flash->success('Le ticket a bien été suppprimé');
            }
        } else {
            $this->Flash->error('Erreur lors de la suppression du code d\'accès');
        }

        $this->redirect(['action' => 'index']);
    }

    /**
     * Index tickets to print
     */
    public function print()
    {
        if (($this->request->is('json') || $this->request->is('post')) && !empty($this->request->data['action'])) {
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
                    // Step 3 - Finish: update tickets
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
        } else if ($this->request->params['_ext'] == 'pdf') { // PDF generation
            $codes = explode(',', $this->request->query['codes']);

            if (!empty($codes)) {
                $tickets = $this->Tickets->find('all', [
                    'conditions' => [
                        'barcode IN' => $codes
                    ]
                ])->toArray();

                $this->viewBuilder()->layout('tickets');
                $this->set(compact('tickets'));
            }
        }

        $this->setTitle('Impression de tickets');
    }
}