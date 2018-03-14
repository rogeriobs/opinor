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

        $this->table('poll_options');
        $this->displayField('id');
        $this->primaryKey('id');

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
                ->notEmpty('label_text');

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

    public function get_options_with_results($poll_id)
    {

        $sql = "WITH __options AS (
                        SELECT 
                        po.id,
                        po.label_text,
                        COUNT(pov.ipsum_id) AS votos
                        FROM poll_options po LEFT JOIN poll_options_votes pov ON po.id = pov.poll_options_id
                        WHERE po.poll_id = :poll_id
                        GROUP BY po.id
                        ORDER BY po.ordem, po.label_text
                )
                -- Para o calculo da porcentagem
                SELECT 
                    opt.id, 
                    opt.label_text, 
                    opt.votos,
                (SELECT SUM(votos) FROM __options) AS total_votos
                FROM __options opt";

        return array_map(function($a){
            
            $a['porcentagem'] = 0;

            if($a['total_votos']) {

                $a['porcentagem'] = ($a['votos'] * 100) / $a['total_votos'];
            }

            return $a;
        }, $this->connection()->execute($sql, ['poll_id' => $poll_id])->fetchAll('assoc'));
    }
    
    
}
