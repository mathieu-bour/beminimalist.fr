<?php
namespace App\Controller\Admin;

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

    public function add()
    {
        $earlyCode = $this->EarlyCodes->newEntity();
        if ($this->request->is('post')) {
            $earlyCode = $this->EarlyCodes->patchEntity($earlyCode, $this->request->data);
            if ($this->EarlyCodes->save($earlyCode)) {
            $this->Flash->success('Le code d\'accès a bien été sauvegardé');

                return $this->redirect(['action' => 'index']);
            } else {
            $this->Flash->error('Erreur lors de la saubegarde du code d\'accès');
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
            $this->Flash->success('Le code d\'accès a bien été suppprimé');
        } else {
            $this->Flash->error('Erreur lors de la suppression du code d\'accès');
        }

        $this->redirect(['action' => 'index']);
    }
}
