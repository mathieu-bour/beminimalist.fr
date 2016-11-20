<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Permanencies Model
 *
 * @method \App\Model\Entity\Permanency get($primaryKey, $options = [])
 * @method \App\Model\Entity\Permanency newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Permanency[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Permanency|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Permanency patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Permanency[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Permanency findOrCreate($search, callable $callback = null)
 */
class PermanenciesTable extends Table
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

        $this->table('permanencies');
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
            ->dateTime('begin')
            ->allowEmpty('begin');

        $validator
            ->allowEmpty('location');

        return $validator;
    }
}
