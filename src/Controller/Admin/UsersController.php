<?php
namespace App\Controller\Admin;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    /* = Login
     * =========================================================== */
    public function login()
    {
        $this->viewBuilder()->layout('admin_centred');

        if ($this->Auth->user()) {
            $this->Flash->error('Vous êtes déjà connecté', [
                'key' => 'auth'
            ]);
            $this->redirect(['controller' => 'pages', 'action' => 'dashboard']);
        }

        if ($this->request->is('post')) {
            debug($this->request->data);
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                $this->redirect(['controller' => 'pages', 'action' => 'dashboard']);
            } else {
                $this->Flash->error('Identifiants incorrects', [
                    'key' => 'auth'
                ]);
            }
        }
    }


    /* = Base methods
     * =========================================================== */
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    public function add()
    {
        if ($this->request->is('post')) {
            $user = $this->Users->newEntity($this->request->data);

            if ($this->Users->save($user)) {
                $this->Flash->success('L\'utilistaeur a bien été enregistré');
            } else {
                $this->Flash->error('Erreur lors de l\'enregistrement de l\'utilistaeur');
            }

            $this->redirect(['controller' => 'Users', 'action' => 'index']);
        }
    }

    public function delete($id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $earlyCode = $this->Users->get($id);
        if ($this->Users->delete($earlyCode)) {
            $this->Flash->success('L\'utilisateur a bien été supprimé');
        } else {
            $this->Flash->error('Il y a eu un problème lors de la suppression de l\'utilisateur');
        }

        $this->redirect(['controller' => 'Users', 'action' => 'index']);
    }
}
