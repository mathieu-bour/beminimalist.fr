<?php
namespace App\Shell;

use App\Model\Table\TicketsTable;
use Cake\Console\Shell;
use Cake\I18n\Time;
use Cake\Mailer\Email;

/**
 * Class TicketsShell
 * @package App\Shell
 *
 * @property TicketsTable $Tickets
 */
class TicketsShell extends Shell {
    public function counter($message, $i, $total) {
        $wipe = strlen($message . ' [' . ($i - 1) . '/' . $total . ']');
        $this->_io->overwrite($message . ' [' . $i . '/' . $total . ']', 0, $wipe);
    }

    public function remind() {
        $this->loadModel('Tickets');

        $tickets = $this->Tickets->find('all')
            ->select(['firstname', 'lastname', 'email'])
            ->where([
                'paid' => false,
                'type' => 'perm'
            ])->toArray();

        $count = count($tickets);
        $this->out($count . ' emails à envoyer');

        foreach ($tickets as $i => $ticket) {
            $this->counter('Envoi de l\'e-mail', $i + 1, $count);

            // Send confirmation e-mail
            $email = new Email();
            $email
                ->viewVars(compact('ticket'))
                ->template('remind')
                ->emailFormat('text')
                ->from(['contact@beminimalist.fr' => 'Minimalist'])
                ->to($ticket->email)
                ->subject('Rappel - Gala d\'hiver 2016')
                ->send();
        }
        $this->out($this->nl(0));

        $this->out('Tous les e-mails ont été envoyés !');
    }
}
