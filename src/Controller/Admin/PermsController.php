<?php
namespace App\Controller\Admin;


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

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $perm = $this->Perms->newEntity();
        if ($this->request->is('post')) {
            $perm = $this->Perms->patchEntity($perm, $this->request->data);
            if ($this->Perms->save($perm)) {
                $this->Flash->success(__('The perm has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The perm could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('perm'));
        $this->set('_serialize', ['perm']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Perm id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $perm = $this->Perms->get($id);
        if ($this->Perms->delete($perm)) {
            $this->Flash->success(__('The perm has been deleted.'));
        } else {
            $this->Flash->error(__('The perm could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
