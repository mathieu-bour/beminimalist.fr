<?php
namespace App\Controller\Admin;

class TicketsController extends AppController  {
    public function index() {
        $tickets = $this->Tickets->find('all')->toArray();

        $this->set(compact('tickets'));
        $this->render('index');
    }

    public function toSend() {
        $tickets = $this->Tickets->find('all')->where(['paid' => 1, 'sent' => 0])->toArray();

        $this->set(compact('tickets'));
        $this->render('index');
    }
}