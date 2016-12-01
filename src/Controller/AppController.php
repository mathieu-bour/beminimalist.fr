<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Controller\Component\SettingsComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use DataTables\Controller\Component\DataTablesComponent;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @property SettingsComponent $Settings
 * @property DataTablesComponent $DataTables
 */
class AppController extends Controller
{
    public $helpers = [
        'Html' => [
            'className' => 'Bootstrap.BootstrapHtml'
        ],
        'Form' => [
            'className' => 'Bootstrap.BootstrapForm'
        ],
        'Paginator' => [
            'className' => 'Bootstrap.BootstrapPaginator'
        ],
        'Modal' => [
            'className' => 'Bootstrap.BootstrapModal'
        ],
        'Barcodes',
        'DataTables' => [
            'className' => 'DataTables.DataTables'
        ]
    ];

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Settings');
        $this->loadComponent('DataTables.DataTables');

        $this->set('settings', $this->Settings);
    }

    public function beforeFilter(Event $event)
    {

        $this->Perms = TableRegistry::get('Perms');
        $perms = $this->paginate($this->Perms);

        $this->set(compact('perms'));
        $this->set('_serialize', ['perms']);
        $this->set([
            'session' => $this->request->session()
        ]);

        return parent::beforeFilter($event); // TODO: Change the autogenerated stub
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /**
     * Get a view var
     * @param $key
     * @return null
     */
    public function get($key)
    {
        if (!empty($this->viewVars[$key])) {
            return $this->viewVars[$key];
        } else {
            return null;
        }
    }
}
