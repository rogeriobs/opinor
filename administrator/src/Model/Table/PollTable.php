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
 * @property \Cake\ORM\Association\HasMany $PollOptionsVotes
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

        $this->setTable('poll');
        $this->setDisplayField('titulo');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Newsortopic', [
            'foreignKey' => 'poll_id'
        ]);
        $this->hasMany('PollOptions', [
            'foreignKey' => 'poll_id'
        ]);
        $this->hasMany('PollOptionsVotes', [
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
                ->boolean('shutoff')
                ->requirePresence('shutoff', 'create')
                ->notEmpty('shutoff');

        $validator
                ->date('expiration_date')
                ->allowEmpty('expiration_date');

        return $validator;

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

        return array_map(function($a)
        {

            $a['porcentagem'] = 0;

            if($a['total_votos']){

                $a['porcentagem'] = ($a['votos'] * 100) / $a['total_votos'];
            }

            return $a;
        }, $this->connection()->execute($sql, ['poll_id' => $poll_id])->fetchAll('assoc'));

    }

}
