<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

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
            'className' => 'Users',
            'foreignKey' => 'user_code',
            'propertyName' => 'code'
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
}
