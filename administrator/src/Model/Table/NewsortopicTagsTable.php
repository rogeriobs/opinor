<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NewsortopicTags Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Newsortopic
 *
 * @method \App\Model\Entity\NewsortopicTag get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewsortopicTag newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewsortopicTag[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicTag|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewsortopicTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicTag[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicTag findOrCreate($search, callable $callback = null, $options = [])
 */
class NewsortopicTagsTable extends Table
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

        $this->setTable('newsortopic_tags');
        $this->setDisplayField('tag');
        $this->setPrimaryKey(['newsortopic_id', 'tag']);

        $this->belongsTo('Newsortopic', [
            'foreignKey' => 'newsortopic_id',
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
            ->allowEmpty('tag', 'create');

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

        return $rules;
    }
}
