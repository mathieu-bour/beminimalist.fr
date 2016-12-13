<?php
namespace App\Controller\Admin;

use App\Model\Entity\Ticket;
use App\Model\Table\UsersTable;
use Cake\I18n\Time;

/**
 *
 * @package App\Controller\Admin
 *
 * @property UsersTable $Users
 */
class PagesController extends AppController
{
    /**
     * Dashboard method
     */
    public function dashboard()
    {
        $this->setTitle('Tableau de bord');

        $this->set([
            'stats' => array_merge_recursive($this->viewVars['stats'], [
                'tickets' => [
                    'printed' => $this->Tickets->find('all')->where(['paid' => true, 'state' => 'printed'])->count(),
                    'paid_paypal' => $this->Tickets->find('all')->where(['paid' => true, 'type' => 'paypal'])->count(),
                    'paid_perm' => $this->Tickets->find('all')->where(['paid' => true, 'type' => 'perm'])->count()
                ]
            ]),
            'charts' => [
                'map' => $this->_getTicketsCoordinates(),
                'sales' => $this->_getTicketsSales(new Time($this->Settings->read('book_opening_date')), new Time()),
                'gender' => $this->_getTicketsGender(),
                'majority' => $this->_getTicketsMajority(),
                'referentSales' => $this->_getTicketsReferentSales(),
                'types' => $this->_getTicketTypes()
            ]
        ]);
    }

    /* = Charts
     * =========================================================== */
    private function _getTicketsCoordinates()
    {
        /** @var Ticket[] $tickets */
        $tickets = $this->Tickets->find('all')
            ->select(['latitude', 'longitude'])
            ->where([
                'latitude IS NOT' => null,
                'longitude IS NOT' => null
            ])
            ->toArray();

        $coordinates = [];

        /** @var Ticket $ticket */
        foreach ($tickets as $id => $ticket) {
            $coordinates[] = [
                'latitude' => $ticket->latitude,
                'longitude' => $ticket->longitude,
            ];
        }

        return $coordinates;
    }

    /**
     * Get well formatted data for Morris.js chart
     * @param Time $start
     * @param Time $end
     * @return array
     */
    private function _getTicketsSales(Time $start, Time $end): array
    {
        $startIterator = $start->copy();
        $endIterator = $start->copy();
        $endIterator->addDay();

        $data = [];

        while ($startIterator < $end) {
            $data[] = [
                'date' => $startIterator->format('Y-m-d'),
                'book' => $this->Tickets->find('all')
                    ->where([
                        'paid' => true,
                        'created >' => $start,
                        'created <' => $endIterator
                    ])->count(),
                'paypal' => $this->Tickets->find('all')
                    ->where([
                        'created >' => $start,
                        'created <' => $endIterator,
                        'paid' => true,
                        'type' => 'paypal'
                    ])->count(),
                'perm' => $this->Tickets->find('all')
                    ->where([
                        'created >' => $start,
                        'created <' => $endIterator,
                        'paid' => true,
                        'type' => 'perm'
                    ])->count()
            ];

            $startIterator->addDay();
            $endIterator->addDay();
        }

        return $data;
    }

    /**
     * Get well formatted data for Morris.js chart
     * @return array
     */
    private function _getTicketsGender()
    {
        return [
            [
                'label' => 'Hommes',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'gender' => 'M'
                    ])->count()
            ], [
                'label' => 'Femmes',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'gender' => 'F'
                    ])->count()
            ]
        ];
    }

    /**
     * Get well formatted data for Morris.js chart
     * @return array
     */
    private function _getTicketsMajority()
    {
        $majority = (new Time($this->Settings->read('event_date')))->addYears(-18);

        return [
            [
                'label' => 'Mineurs',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'birthdate >' => $majority
                    ])
                    ->count()
            ], [
                'label' => 'Majeurs',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'birthdate <' => $majority
                    ])
                    ->count()
            ]
        ];
    }

    /**
     * Get well formatted data for Morris.js chart
     * @return array
     */
    private function _getTicketsReferentSales()
    {
        $this->loadModel('Users');
        $users = $this->Users->find('all')->toArray();
        $data = [];

        foreach ($users as $user) {
            $count = $this->Tickets->find('all')->where(['paid' => 1, 'user_code' => $user->code])->count();

            if($count > 0) {
                $data[] = [
                    'label' => $user->firstname . ' ' . $user->lastname,
                    'value' => $this->Tickets->find('all')->where(['paid' => 1, 'user_code' => $user->code])->count()
                ];
            }
        }

        return $data;
    }

    /**
     * Get well formatted data for Morris.js chart
     * @return array
     */
    private function _getTicketTypes()
    {
        return [
            [
                'label' => 'PayPal',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'type' => 'paypal'
                    ])
                    ->count()
            ], [
                'label' => 'Permanence',
                'value' => $this->Tickets->find('all')
                    ->where([
                        'paid' => 1,
                        'type' => 'perm'
                    ])
                    ->count()
            ]
        ];
    }
}