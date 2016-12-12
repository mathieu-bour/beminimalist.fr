<?php
namespace App\Controller;

use App\Controller\Component\SettingsComponent;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use DataTables\Controller\Component\DataTablesComponent;

/**
 * @author Mathieu Bour <mathieu.tin.bour@gmail.com>
 * @package App\Controller
 *
 * @property SettingsComponent $Settings
 * @property DataTablesComponent $DataTables
 */
class AppController extends Controller
{
    /**
     * @var array the page helpers; all loaded by default
     */
    public $helpers = [
        'Html'       => [
            'className' => 'Bootstrap.BootstrapHtml'
        ],
        'Form'       => [
            'className' => 'Bootstrap.BootstrapForm'
        ],
        'Paginator'  => [
            'className' => 'Bootstrap.BootstrapPaginator'
        ],
        'Modal'      => [
            'className' => 'Bootstrap.BootstrapModal'
        ]
    ];

    /* = Hooks
     * =========================================================== */
    /**
     * Initialization
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
        $this->setTitle('No title set');
    }

    /**
     * Before filter hook
     *
     * @param Event $event
     * @return \Cake\Network\Response|null
     */
    public function beforeFilter(Event $event)
    {
        $this->Perms = TableRegistry::get('Perms');
        $perms = $this->paginate($this->Perms);

        $this->set(compact('perms'));
        $this->set('_serialize', ['perms']);
        $this->set([
            'session' => $this->request->session()
        ]);

        return parent::beforeFilter($event);
    }

    /**
     * Before render hook.
     *
     * @param \Cake\Event\Event $event
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) && in_array($this->response->type(), [
                'application/json',
                'application/xml'
            ])
        ) {
            $this->set('_serialize', true);
        }
    }

    /* = Utils
     * =========================================================== */
    /**
     * Get a view var (return null if the viewVar does not exist)
     * @param string $key the viewVar key
     * @return mixed
     */
    public function get(string $key)
    {
        if (!empty($this->viewVars[$key])) {
            return $this->viewVars[$key];
        } else {
            return null;
        }
    }

    /**
     * Load a helper
     * @param string|array $helper
     * @return void
     */
    public function loadHelper($helper) {
        if(is_string($helper)) {
            $helper = [$helper];
        }

        $this->viewBuilder()->helpers([$helper]);
    }

    /* = View methods
     * =========================================================== */
    /**
     * Set the page title (accessible in viewVars)
     * @param string $title the page title
     * @return void
     */
    public function setTitle(string $title)
    {
        $this->set(compact('title'));
    }

    /* = REST API
     * =========================================================== */
    /**
     * Build JSON response for REST API
     * @param array $response
     */
    public function json(array $response, $deep = false) {
        $merge = $deep ? 'array_merge_deep': 'array_merge';

        $response = $merge([
            'message' => null,
            'url' => $this->request->here(),
            'code' => 200,
            'data' => null,
            '_serialize' => ['message', 'url', 'code', 'data']
        ], $response);

        $this->set($response);
    }
}
