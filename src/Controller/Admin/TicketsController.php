<?php
namespace App\Controller\Admin;

class TicketsController extends AppController
{
    public function index()
    {
        $tickets = $this->Tickets->find('all')->toArray();

        $this->set(compact('tickets'));
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