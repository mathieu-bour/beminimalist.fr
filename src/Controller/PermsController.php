<?php
namespace App\Controller;


/**
 * Perms Controller
 *
 * @property \App\Model\Table\PermsTable $Perms
 */
class PermsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $perms = $this->paginate($this->Perms);

        $this->set(compact('perms'));
        $this->set('_serialize', ['perms']);
    }
}
