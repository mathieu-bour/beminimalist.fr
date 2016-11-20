<?php
namespace App\Controller\Admin;

class PermanenciesController extends AppController  {
    public function index() {
        $permanencies = $this->Permanencies->find('all')->toArray();

        $this->set(compact('permanencies'));
        $this->render('index');
    }

    public function add() {

    }
}