<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EarlyCodes Controller
 *
 * @property \App\Model\Table\EarlyCodesTable $EarlyCodes
 */
class EarlyCodesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $earlyCodes = $this->paginate($this->EarlyCodes);

        $this->set(compact('earlyCodes'));
        $this->set('_serialize', ['earlyCodes']);
    }

    /**
     * View method
     *
     * @param string|null $id Early Code id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $earlyCode = $this->EarlyCodes->get($id, [
            'contain' => []
        ]);

        $this->set('earlyCode', $earlyCode);
        $this->set('_serialize', ['earlyCode']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $earlyCode = $this->EarlyCodes->newEntity();
        if ($this->request->is('post')) {
            $earlyCode = $this->EarlyCodes->patchEntity($earlyCode, $this->request->data);
            if ($this->EarlyCodes->save($earlyCode)) {
                $this->Flash->success(__('The early code has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The early code could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('earlyCode'));
        $this->set('_serialize', ['earlyCode']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Early Code id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $earlyCode = $this->EarlyCodes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $earlyCode = $this->EarlyCodes->patchEntity($earlyCode, $this->request->data);
            if ($this->EarlyCodes->save($earlyCode)) {
                $this->Flash->success(__('The early code has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The early code could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('earlyCode'));
        $this->set('_serialize', ['earlyCode']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Early Code id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $earlyCode = $this->EarlyCodes->get($id);
        if ($this->EarlyCodes->delete($earlyCode)) {
            $this->Flash->success(__('The early code has been deleted.'));
        } else {
            $this->Flash->error(__('The early code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
