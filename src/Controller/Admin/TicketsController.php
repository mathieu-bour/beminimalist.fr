<?php
namespace App\Controller\Admin;

use Cake\I18n\Time;

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
                'id >' => 0
                // Bug
            ]
        ]);

        $this->setTitle('Tous les tickets');

        $this->set([
            'data' => $data,
            '_serialize' => array_merge($this->viewVars['_serialize'], ['data'])
        ]);
    }

    public function checkpoint()
    {
        // Implements Datables
        $data = $this->DataTables->find('Tickets', 'all', [
            'conditions' => [
                'id >' => 0,
                'paid' => 1,
                'type !=' => 'here'
                // Bug
            ]
        ]);

        $this->setTitle('Tous les tickets');

        $this->set([
            'data' => $data,
            '_serialize' => array_merge($this->viewVars['_serialize'], ['data'])
        ]);
    }

    /**
     * View method
     * @return \Cake\Network\Response|null
     */
    public function add()
    {
        // REST API handler
        if ($this->request->is('json')) {
            return $this->_add();
        }

        return null;
    }

    /**
     * View method
     * @param int $id
     * @return \Cake\Network\Response|null
     */
    public function view($id)
    {
        // REST API handler
        if ($this->request->is('json')) {
            return $this->_view($id);
        }

        return null;
    }

    /**
     * Edit method
     * @param int $id
     * @return \Cake\Network\Response|null
     */
    public function edit($id)
    {
        // REST API handler
        if ($this->request->is('json')) {
            return $this->_edit($id);
        }

        $ticket = $this->Tickets->get($id);

        if (!$this->request->is([
            'post',
            'put'
        ])
        ) {
            // GET request from admin panel
            $this->setTitle('Édition de ticket');
            $this->set('ticket', $ticket);

            return null;
        } else {
            // POST request
            $this->Tickets->patchEntity($ticket, $this->request->data);

            if ($this->Tickets->save($ticket)) {
                $this->Flash->success('Ticket mis à jour');
            } else {
                $this->Flash->error('Erreur lors de la mise à jour de l\'article');
            }

            return $this->redirect(['action' => 'index']);
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
        $this->request->allowMethod([
            'post',
            'delete'
        ]);
        $ticket = $this->Tickets->get($id);
        if ($this->Tickets->delete($ticket)) {
            if (!$this->request->is('json')) {
                $this->Flash->success('Le ticket a bien été suppprimé');
            }
        } else {
            $this->Flash->error('Erreur lors de la suppression du code d\'accès');
        }

        $this->redirect(['action' => 'index']);
    }


    /**
     * Validate a ticket
     * @param $id
     */
    public function validate($id)
    {
        $this->request->data['validated'] = Time::now();
        $this->edit($id);
    }

    /**
     * Unvalidate a ticket
     * @param $id
     */
    public function unvalidate($id)
    {
        $this->request->data['validated'] = null;
        $this->edit($id);
    }

    public function stats() {
        $this->json([
            'data' => [
                'validated' => $this->Tickets->find('all')->where(['paid' => 1, 'validated IS NOT' => null])->count(),
                'paypal' => $this->Tickets->find('all')->where(['paid' => 1, 'validated IS NOT' => null, 'type' => 'paypal'])->count(),
                'perm' => $this->Tickets->find('all')->where(['paid' => 1, 'validated IS NOT' => null, 'type' => 'perm'])->count(),
                'here' => $this->Tickets->find('all')->where(['paid' => 1, 'validated IS NOT' => null, 'type' => 'here'])->count(),
            ]
        ]);
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
                                    'pending' => $this->Tickets->find('all')->where([
                                        'paid' => true,
                                        'state' => 'pending'
                                    ])->count()
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

    /* = REST API
     * =========================================================== */
    private function _add()
    {
        $this->request->allowMethod(['post', 'put']);
        $ticket = $this->Tickets->newEntity($this->request->data);

        if ($this->Tickets->save($ticket)) {
            $this->json([
                'data' => [$ticket]
            ]);
        }
    }

    private function _view($id)
    {
        $this->request->allowMethod(['get']);

        $ticket = $this->Tickets->get($id);

        return $this->json([
            'data' => [$ticket]
        ]);
    }

    private function _edit($id)
    {
        $this->request->allowMethod([
            'post',
            'put'
        ]);

        $ticket = $this->Tickets->get($id);
        $this->Tickets->patchEntity($ticket, $this->request->data);

        if ($this->Tickets->save($ticket)) {
            return $this->json([
                'message' => 'Ticket mis à jour',
                'data' => $ticket
            ]);
        } else {
            return $this->json([
                'message' => 'Erreur lors de la mise à jour du ticket',
                'data' => $ticket,
                'code' => 500
            ]);
        }
    }

    private function _delete()
    {

    }
}