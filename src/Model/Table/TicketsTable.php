<?php
namespace App\Model\Table;

use App\Model\Entity\Ticket;
use Cake\Event\Event;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Exception;
use Geocoder\Model\Address;
use Geocoder\Provider\GoogleMaps;
use Http\Adapter\Guzzle6\Client;

/**
 * Tickets Model
 *
 * @method \App\Model\Entity\Ticket get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ticket newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ticket[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ticket|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ticket patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ticket[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ticket findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TicketsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tickets');
        $this->displayField('id');
        $this->primaryKey('id');

        // Relations
        $this->belongsTo('Users', [
            'foreignKey' => 'user_code'
        ]);

        // Behaviors
        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Users' => ['ticket_count']
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            // id
            ->integer('id')
            ->allowEmpty('id', 'create')
            // barcode
            ->integer('barcode')
            ->allowEmpty('barcode', 'update')
            // type
            ->inList('type', ['paypal', 'perm'])
            // paid
            ->boolean('paid')
            // state
            ->inList('state', ['pending', 'printed', 'sent'])
            // user_code
            ->allowEmpty('user_code')
            // firstname
            // lastname
            // gender
            ->inList('gender', ['M', 'F'])
            // birthdate
            ->date('birthdate')
            // email
            ->email('email')
            // address
            // zip_code
            ->integer('zip_code')
            // created
            ->dateTime('created')
            ->allowEmpty('created');

        return $validator;
    }

    /* = Callbacks
     * =========================================================== */
    /**
     * @param Event $event
     * @param Ticket $entity
     * @param array|\ArrayObject $options
     * @param $operation
     */
    public function beforeRules(Event $event, Ticket $entity, $options, $operation)
    {
        // Generate barcode
        if (empty($entity->barcode)) {
            $entity->set('barcode', rand(100000000, 999999999));
        }

        // Generate clean address
        if (!empty($entity->address) && !empty($entity->zip_code) && !empty($entity->city)) {
            $rawAddress = $entity->address . ' ' . $entity->zip_code . ' ' . $entity->city;

            try {
                $adapter = new Client();
                $geocoder = new GoogleMaps($adapter, 'fr_FR', 'France', true, 'AIzaSyDDsLpHUkMF5buf-9tGWOTk1qdzmQblZaY');
                $result = $geocoder->limit(1)->geocode($rawAddress);
                $array = iterator_to_array($result);
                $address = reset($array);

                /** @var Address $address */
                $entity->set([
                    'address' => trim($address->getStreetNumber() . ' ' . $address->getStreetName()),
                    'zip_code' => $address->getPostalCode(),
                    'city' => $address->getLocality()
                ]);
            } catch (Exception $e) {
                // Do something when lookup fail
            }
        }
    }
}
