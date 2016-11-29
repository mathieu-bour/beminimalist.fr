<?php
namespace App\Controller\Admin;

class TicketsController extends AppController
{
    public function index()
    {
        $tickets = $this->Tickets->find('all')->toArray();

        $this->set(compact('tickets'));
        $this->render('index');
    }

    public function wizard($step)
    {
        $session = $this->request->session();

        switch ($step) {
            case 'destroy':
                $this->request->session()->delete('Wizard.Tickets'); // Delete tickets from session
                $this->redirect(['action' => 'wizard', 'init']); // Resend user to the beginning of the procedure
                break;
            case 'init': // Assign tickets
                if (!$session->check('Wizard.Tickets')) {
                    $tickets = $this->Tickets->find('list', [
                        'keyField' => 'id',
                        'valueField' => 'code',
                        'conditions' => [
                            'paid' => 1,
                            'state' => 'TO_PRINT'
                        ],
                        'limit' => 3
                    ])->toArray();

                    if (count($tickets) == 0) {
                        $this->Flash->success('Toutes les places ont été préparées !');
                        $this->redirect('/admin/');
                    } else {
                        $this->Tickets->updateAll([
                            'state' => 'ASSIGNED'
                        ], [
                            'state' => 'TO_PRINT',
                            'code IN' => array_values($tickets)
                        ]);
                        $session->write('Wizard.Tickets', $tickets);
                    }
                }


                $this->redirect(['action' => 'wizard', 'print']);
                break;
            case
            'print': // Print tickets
                if (!$session->check('Wizard.Tickets')) {
                    $this->redirect(['action' => 'wizard']);
                } else if (!$this->request->is('post') || empty($this->request->data['ok'])) {
                    $this->render('wizard_print');
                } else {
                    $this->Tickets->updateAll([
                        'state' => 'PRINTED'
                    ], [
                        'state' => 'ASSIGNED',
                        'code IN' => array_values($session->read('Wizard.Tickets'))
                    ]);

                    $this->redirect(['action' => 'wizard', 'fill']);
                }
                break;
            case 'fill': // Fill tickets
                if (!$session->check('Wizard.Tickets')) {
                    $this->redirect(['action' => 'wizard']);
                } else if (!$this->request->is('post') || empty($this->request->data['ok'])) {
                    $this->set('tickets', $this->Tickets->find('all', [
                        'fields' => ['id', 'code', 'firstname', 'lastname'],
                        'conditions' => [
                            'paid' => 1,
                            'state' => 'PRINTED',
                            'code IN' => array_values($session->read('Wizard.Tickets'))
                        ]
                    ]));

                    $this->render('wizard_fill');
                } else {
                    $this->Tickets->updateAll([
                        'state' => 'FILLED'
                    ], [
                        'state' => 'PRINTED',
                        'code IN' => array_values($session->read('Wizard.Tickets'))
                    ]);

                    $this->redirect(['action' => 'wizard', 'package']);
                }
                break;
            case 'package': // Package tickets
                if (!$session->check('Wizard.Tickets')) {
                    $this->redirect(['action' => 'wizard']);
                } else if (!$this->request->is('post') || empty($this->request->data['ok'])) {
                    $this->set('tickets', $this->Tickets->find('all', [
                        'fields' => ['id', 'code', 'firstname', 'lastname', 'address', 'zip_code', 'city'],
                        'conditions' => [
                            'paid' => 1,
                            'state' => 'FILLED',
                            'code IN' => array_values($session->read('Wizard.Tickets'))
                        ]
                    ]));

                    $this->render('wizard_package');
                } else {
                    $this->Tickets->updateAll([
                        'state' => 'PACKAGED'
                    ], [
                        'state' => 'FILLED',
                        'code IN' => array_values($session->read('Wizard.Tickets'))
                    ]);

                    $this->redirect(['action' => 'wizard', 'destroy']); // Resend user to the beginning of the procedure
                }
                break;
        }
    }


    public function fill()
    {
        $codes = explode(',', $this->request->query['codes']);

        if (empty($codes)) {
            $this->redirect(['action' => 'wizard']);
        } else {
            $tickets = $this->Tickets->find('all')
                ->select(['id', 'code', 'firstname', 'lastname', 'address', 'zip_code', 'city'])
                ->where(['paid' => 1, 'state' => 'TO_PRINT', 'code IN' => $codes])
                ->toArray();

            $this->set(compact('codes', 'tickets'));
        }
    }

    public function print()
    {
        $codes = explode(',', $this->request->query['codes']);

        if (!empty($codes)) {
            $this->viewBuilder()->layout('pdf_ticket');

            /*$tickets = $this->Tickets->find('all', [
                'fields' => ['id', 'barcode', 'firstname',' lastname', 'address', 'zip_code', 'city'],
                'conditions' => [
                    'paid' => 1,
                    'code IN' => $codes
                ]
            ])->toArray();*/

            $this->response->type('pdf');
            //$this->set(compact('tickets'));
        }
    }
}