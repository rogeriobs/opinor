<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PollOptions Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Poll
 *
 * @method \App\Model\Entity\PollOption get($primaryKey, $options = [])
 * @method \App\Model\Entity\PollOption newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PollOption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PollOption|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PollOption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PollOption[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PollOption findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PollOptionsTable extends Table
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

        $this->setTable('poll_options');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Poll', [
            'foreignKey' => 'poll_id',
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
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('label_text', 'create')
                ->notBlank('label_text');

        $validator
                ->integer('ordem')
                ->requirePresence('ordem', 'create')
                ->notEmpty('ordem');

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
        $rules->add($rules->existsIn(['poll_id'], 'Poll'));

        return $rules;

    }
}
