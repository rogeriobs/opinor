<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NewsortopicCommentsRating Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ipsum
 * @property \Cake\ORM\Association\BelongsTo $NewsortopicComments
 *
 * @method \App\Model\Entity\NewsortopicCommentsRating get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicCommentsRating findOrCreate($search, callable $callback = null, $options = [])
 */
class NewsortopicCommentsRatingTable extends Table
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

        $this->setTable('newsortopic_comments_rating');
        $this->setDisplayField('ipsum_id');
        $this->setPrimaryKey(['ipsum_id', 'newsortopic_comments_id']);

        $this->belongsTo('Ipsum', [
            'foreignKey' => 'ipsum_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('NewsortopicComments', [
            'foreignKey' => 'newsortopic_comments_id',
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
            ->requirePresence('type', 'create')
            ->notEmpty('type');

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
        $rules->add($rules->existsIn(['ipsum_id'], 'Ipsum'));
        $rules->add($rules->existsIn(['newsortopic_comments_id'], 'NewsortopicComments'));

        return $rules;
    }
}
