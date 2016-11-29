<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EarlyCodes Model
 *
 * @method \App\Model\Entity\EarlyCode get($primaryKey, $options = [])
 * @method \App\Model\Entity\EarlyCode newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EarlyCode[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EarlyCode|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EarlyCode patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EarlyCode[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EarlyCode findOrCreate($search, callable $callback = null)
 */
class EarlyCodesTable extends Table
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

        $this->table('early_codes');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('code');

        $validator
            ->dateTime('expire')
            ->allowEmpty('expire');

        $validator
            ->integer('remaining_uses')
            ->allowEmpty('remaining_uses');

        return $validator;
    }
}
