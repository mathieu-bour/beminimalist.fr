<?php
namespace App\Controller\Admin;

use App\Model\Entity\Ticket;

class PagesController extends AppController
{
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

    public function dashboard()
    {
        /*$i = 15;
        $range = 50;

        $this->loadModel('Tickets');
        $tickets = $this->Tickets->find('all')->where(['id >=' => $i * $range, 'id < ' => ($i + 1) * $range]);

        foreach ($tickets as $ticket) {
            $prepAddr = str_replace(' ', '+', $ticket->address . ' ' . $ticket->zip_code . ' ' . $ticket->city);
            $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false&key=AIzaSyDDsLpHUkMF5buf-9tGWOTk1qdzmQblZaY');
            $output = json_decode($geocode);

            debug($output->status);

            if(!empty($output->results)) {
                $ticket->latitude = $output->results[0]->geometry->location->lat;
                $ticket->longitude = $output->results[0]->geometry->location->lng;
            } else {
                $ticket->latitude = $ticket->longitude = null;
            }

            $this->Tickets->save($ticket);
        }

        die();*/

        $this->set([
            'stats' => [
                'tickets' => [
                    'total' => $this->Tickets->find('all')->count(),
                    'paid' => $this->Tickets->find('all')->where(['paid' => true])->count(),
                    'pending' => $this->Tickets->find('all')->where(['paid' => true, 'state' => 'pending'])->count(),
                    'printed' => $this->Tickets->find('all')->where(['paid' => true, 'state' => 'printed'])->count()
                ]
            ],
            'charts' => [
                'map' => $this->_getTicketsCoordinates()
            ]
        ]);
    }
}