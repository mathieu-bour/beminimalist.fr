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
        if($this->request->is('json')) {
            return $this->_login();
        }

        $this->viewBuilder()->layout('default_centred');

        if ($this->Auth->user()) {
            $this->Flash->error('Vous êtes déjà connecté');
            $this->redirect([
                'controller' => 'pages',
                'action'     => 'dashboard'
            ]);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();

            if ($user) {
                $this->Auth->setUser($user);

                $this->redirect([
                    'controller' => 'pages',
                    'action'     => 'dashboard'
                ]);
            } else {
                $this->Flash->error('Identifiants incorrects');
            }
        }
    }

    public function logout()
    {
        $this->Flash->success('Vous êtes maintenant déconnecté.');
        $this->get('session')->clear();

        return $this->redirect([
            'controller' => 'Users',
            'action'     => 'login'
        ]);
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

            $this->redirect([
                'controller' => 'Users',
                'action'     => 'index'
            ]);
        }
    }

    public function delete($id)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);
        $earlyCode = $this->Users->get($id);
        if ($this->Users->delete($earlyCode)) {
            $this->Flash->success('L\'utilisateur a bien été supprimé');
        } else {
            $this->Flash->error('Il y a eu un problème lors de la suppression de l\'utilisateur');
        }

        $this->redirect([
            'controller' => 'Users',
            'action'     => 'index'
        ]);
    }

    /* = REST API
     * =========================================================== */
    private function _login()
    {
        $this->request->allowMethod('post');

        $user = $this->Auth->user() ? $this->Auth->user() : $this->Auth->identify();

        if(!$user) {
            return $this->json([
               'message' => 'Identifiants incorrects',
               'code' => 403
            ]);
        } else {
            $this->Auth->setUser($user);
            return $this->json([
                'message' => 'Connexion établie'
            ]);
        }
    }
}
