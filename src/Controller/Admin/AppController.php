<?php

namespace App\Controller\Admin;

use App\Model\Table\TicketsTable;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Class AppController
 * @package App\Controller\Admin
 *
 * @property TicketsTable $Tickets
 */
class AppController extends \App\Controller\AppController  {
    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->layout('admin');

        $this->Tickets = TableRegistry::get('Tickets');
        $counters = [
            'Tickets' => [
                'all' => $this->Tickets->find('all')->count(),
                'to_print' => $this->Tickets->find('all')->where(['paid' => 1, 'state' => 'TO_PRINT'])->count(),
                'packaged' => $this->Tickets->find('all')->where(['paid' => 1, 'state' => 'PACKAGED'])->count(),
            ]
        ];

        $this->set(compact('counters'));

        return parent::beforeFilter($event);
    }

}