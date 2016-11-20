<?php
namespace App\Controller\Component;

use angelleye\PayPal\PayPal;
use Cake\Controller\Component;
use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Network\Session;

/**
 * Class PayPalComponent
 * @package App\Controller\Component
 * @property PayPal $PayPal
 * @property AppController $Controller
 * @property Session $Session
 */
class PayPalComponent extends Component
{
    public $components = ['Session'];

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->Controller = $this->_registry->getController();
        $this->Session = $this->Controller->request->session();

        $PayPalConfig = array(
            'Sandbox' => true,
            'APIUsername' => 'vendeur_api1.pixelads.fr',
            'APIPassword' => 'JUQ6JRL2EEHLL6H4',
            'APISignature' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31A0eQREb91gGLBHQgYBB-xzah4eYl',
            'APIVersion' => '97.0',
            'APISubject' => '',
            'PrintHeaders' => false,
            'LogResults' => false,
            'LogPath' => false,
        );
        $this->PayPal = new PayPal($PayPalConfig);
    }

    private function _generatePayments()
    {
        return [
            [
                'amt' => 10.5,
                'currencycode' => 'EUR',
                'itemamt' => 10.5,
                'shippingamt' => 0,
                'taxamt' => 0,
                'desc' => 'MINIMALIST - Entrée au Gala d\'hiver 2016',
                'order_items' => [
                    [
                        'name' => 'MINIMALIST - Entrée au Gala d\'hiver 2016',
                        'desc' => 'MINIMALIST - Entrée au Gala d\'hiver 2016',
                        'amt' => 10.5,
                        'qty' => '1',
                        'taxamt' => '0'
                    ]
                ]
            ]
        ];
    }

    public function SetExpressCheckout()
    {
        $SECFields = [
            'maxamt' => '4.5',
            'returnurl' => Router::url(['controller' => 'Tickets', 'action' => 'success'], true),
            'cancelurl' => Router::url(['controller' => 'Tickets', 'action' => 'book'], true),
            'noshipping' => '1',
            'localecode' => 'fr',
            'skipdetails' => '1',
            'brandname' => 'MINIMALIST'
        ];

        $SetExpressCheckoutResults = $this->PayPal->SetExpressCheckout([
            'SECFields' => $SECFields,
            'SurveyChoices' => ['Yes', 'No'],
            'Payments' => $this->_generatePayments()
        ]);
        $this->Session->write('SetExpressCheckoutResult', $SetExpressCheckoutResults);

        return !empty($SetExpressCheckoutResults['TOKEN']);
    }

    public function DoExpressCheckoutPayment()
    {
        $GECDResult = $this->PayPal->GetExpressCheckoutDetails($this->Session->read('SetExpressCheckoutResult.TOKEN'));

        $DECPFields = [
            'token' => $this->Session->read('SetExpressCheckoutResult.TOKEN'),
            'payerid' => $GECDResult['PAYERID']
        ];

        $DoExpressCheckoutPaymentResult = $this->PayPal->DoExpressCheckoutPayment([
            'DECPFields' => $DECPFields,
            'Payments' => $this->_generatePayments()
        ]);

        $this->Session->write('DoExpressCheckoutPayment', $DoExpressCheckoutPaymentResult);

        return $DoExpressCheckoutPaymentResult['ACK'] == 'Success';
    }
}