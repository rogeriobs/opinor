<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Poll Model
 *
 * @property \Cake\ORM\Association\HasMany $Newsortopic
 * @property \Cake\ORM\Association\HasMany $PollOptions
 *
 * @method \App\Model\Entity\Poll get($primaryKey, $options = [])
 * @method \App\Model\Entity\Poll newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Poll[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Poll|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Poll patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Poll[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Poll findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PollTable extends Table
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

        $this->table('poll');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Newsortopic', [
            'foreignKey' => 'poll_id'
        ]);
        $this->hasMany('PollOptions', [
            'foreignKey' => 'poll_id'
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
            ->requirePresence('titulo', 'create')
            ->notEmpty('titulo');

        $validator
            ->requirePresence('texto_resumo', 'create')
            ->notEmpty('texto_resumo');

        $validator
            ->boolean('shutoff')
            ->requirePresence('shutoff', 'create')
            ->notEmpty('shutoff');

        $validator
            ->date('expiration_date')
            ->allowEmpty('expiration_date');

        return $validator;
    }
}
