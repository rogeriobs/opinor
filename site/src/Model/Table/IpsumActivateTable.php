<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * IpsumActivate Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ipsum
 *
 * @method \App\Model\Entity\IpsumActivate get($primaryKey, $options = [])
 * @method \App\Model\Entity\IpsumActivate newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\IpsumActivate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\IpsumActivate|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\IpsumActivate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\IpsumActivate[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\IpsumActivate findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IpsumActivateTable extends Table
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

        $this->table('ipsum_activate');
        $this->displayField('ipsum_id');
        $this->primaryKey('ipsum_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ipsum', [
            'foreignKey' => 'ipsum_id',
            'joinType' => 'INNER'
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
            ->allowEmpty('token')
            ->add('token', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->date('expiration_date')
            ->requirePresence('expiration_date', 'create')
            ->notEmpty('expiration_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['token']));
        $rules->add($rules->existsIn(['ipsum_id'], 'Ipsum'));

        return $rules;
    }
}
