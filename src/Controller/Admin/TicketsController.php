<?php
namespace App\Controller\Admin;

class TicketsController extends AppController
{
    public function index()
    {
        $tickets = $this->paginate($this->Tickets);
        $this->set(compact('tickets'));
        $this->set('_serialize', ['tickets']);
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