<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Perms Model
 *
 * @method \App\Model\Entity\Perm get($primaryKey, $options = [])
 * @method \App\Model\Entity\Perm newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Perm[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Perm|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Perm patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Perm[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Perm findOrCreate($search, callable $callback = null)
 */
class PermsTable extends Table
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

        $this->table('perms');
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
            ->allowEmpty('address');

        $validator
            ->integer('zip_code')
            ->allowEmpty('zip_code');

        $validator
            ->allowEmpty('city');

        $validator
            ->dateTime('datetime')
            ->allowEmpty('datetime');

        return $validator;
    }
}
