<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NewsortopicComments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Newsortopic
 * @property \Cake\ORM\Association\BelongsTo $Ipsum
 *
 * @method \App\Model\Entity\NewsortopicComment get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewsortopicComment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewsortopicComment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicComment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewsortopicComment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicComment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicComment findOrCreate($search, callable $callback = null, $options = [])
 */
class NewsortopicCommentsTable extends Table
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

        $this->setTable('newsortopic_comments');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Newsortopic', [
            'foreignKey' => 'newsortopic_id',
            'joinType' => 'INNER'
        ]);
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('comentario', 'create')
            ->notEmpty('comentario');

        $validator
            ->dateTime('data_e_hora')
            ->requirePresence('data_e_hora', 'create')
            ->notEmpty('data_e_hora');

        $validator
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['newsortopic_id'], 'Newsortopic'));
        $rules->add($rules->existsIn(['ipsum_id'], 'Ipsum'));

        return $rules;
    }
}
