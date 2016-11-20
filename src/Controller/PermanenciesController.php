<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Permanencies Controller
 *
 * @property \App\Model\Table\PermanenciesTable $Permanencies
 */
class PermanenciesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $permanencies = $this->paginate($this->Permanencies);

        $this->set(compact('permanencies'));
        $this->set('_serialize', ['permanencies']);
    }

    /**
     * View method
     *
     * @param string|null $id Permanency id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permanency = $this->Permanencies->get($id, [
            'contain' => []
        ]);

        $this->set('permanency', $permanency);
        $this->set('_serialize', ['permanency']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permanency = $this->Permanencies->newEntity();
        if ($this->request->is('post')) {
            $permanency = $this->Permanencies->patchEntity($permanency, $this->request->data);
            if ($this->Permanencies->save($permanency)) {
                $this->Flash->success(__('The permanency has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permanency could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('permanency'));
        $this->set('_serialize', ['permanency']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Permanency id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permanency = $this->Permanencies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permanency = $this->Permanencies->patchEntity($permanency, $this->request->data);
            if ($this->Permanencies->save($permanency)) {
                $this->Flash->success(__('The permanency has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The permanency could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('permanency'));
        $this->set('_serialize', ['permanency']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Permanency id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permanency = $this->Permanencies->get($id);
        if ($this->Permanencies->delete($permanency)) {
            $this->Flash->success(__('The permanency has been deleted.'));
        } else {
            $this->Flash->error(__('The permanency could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
