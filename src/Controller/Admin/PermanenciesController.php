<?php
namespace App\Controller\Admin;

class PermanenciesController extends AppController  {
    public function index() {
        $permanencies = $this->Permanencies->find('all')->toArray();

        $this->set(compact('permanencies'));
        $this->render('index');
    }

    public function add() {
        $permanency = $this->Permanencies->newEntity();
        if ($this->request->is('post')) {
            $permanency = $this->Permanencies->patchEntity($permanency, $this->request->data);
            if ($this->Permanencies->save($permanency)) {
            $this->Flash->success('La permanence a bien été sauvegardé');
                return $this->redirect(['action' => 'index']);
            } else {
            $this->Flash->error('Erreur lors de la sauvegarde de la permanence');
            }
        }
        $this->set(compact('permanency'));
        $this->set('_serialize', ['permanency']);
    }
}