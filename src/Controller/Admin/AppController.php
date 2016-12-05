<?php

namespace App\Controller\Admin;

use App\Model\Table\TicketsTable;
use Cake\Event\Event;

/**
 * Class AppController
 * @package App\Controller\Admin
 *
 * @property TicketsTable $Tickets
 */
class AppController extends \App\Controller\AppController
{
    /**
     * @var array  the page helpers; all loaded by default
     */
    public $helpers = [
        'DataTables' => [
            'className' => 'DataTables.DataTables'
        ]
    ];

    /* = Hooks
     * =========================================================== */
    public function beforeFilter(Event $event)
    {
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email'],
                    'passwordHasher' => [
                        'className' => 'Default'
                    ]
                ]
            ]
        ]);
        $this->loadModel('Tickets');

        $this->viewBuilder()->layout('admin');
        $this->set([
            'stats' => [
                'tickets' => [
                    'total' => $this->Tickets->find('all')->count(),
                    'paid' => $this->Tickets->find('all')->where(['paid' => true])->count(),
                    'pending' => $this->Tickets->find('all')->where(['paid' => true, 'state' => 'pending'])->count()
                ]
            ],
        ]);

        return parent::beforeFilter($event);
    }

}