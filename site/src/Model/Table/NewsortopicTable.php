<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Newsortopic Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Poll
 * @property \Cake\ORM\Association\BelongsTo $Dominus
 * @property \Cake\ORM\Association\HasMany $NewsortopicComments
 * @property \Cake\ORM\Association\HasMany $NewsortopicImagens
 * @property \Cake\ORM\Association\HasMany $NewsortopicTags
 *
 * @method \App\Model\Entity\Newsortopic get($primaryKey, $options = [])
 * @method \App\Model\Entity\Newsortopic newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Newsortopic[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Newsortopic|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Newsortopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Newsortopic[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Newsortopic findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NewsortopicTable extends Table
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

        $this->table('newsortopic');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Poll', [
            'foreignKey' => 'poll_id'
        ]);
        $this->belongsTo('Dominus', [
            'foreignKey' => 'dominus_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('NewsortopicComments', [
            'foreignKey' => 'newsortopic_id'
        ]);
        $this->hasMany('NewsortopicImagens', [
            'foreignKey' => 'newsortopic_id'
        ]);
        $this->hasMany('NewsortopicTags', [
            'foreignKey' => 'newsortopic_id'
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
            ->requirePresence('alias', 'create')
            ->notEmpty('alias')
            ->add('alias', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('data_de_publicacao')
            ->requirePresence('data_de_publicacao', 'create')
            ->notEmpty('data_de_publicacao');

        $validator
            ->dateTime('data_da_fonte')
            ->requirePresence('data_da_fonte', 'create')
            ->notEmpty('data_da_fonte');

        $validator
            ->requirePresence('texto_resumo', 'create')
            ->notEmpty('texto_resumo');

        $validator
            ->requirePresence('texto_full', 'create')
            ->notEmpty('texto_full');

        $validator
            ->allowEmpty('meta_title');

        $validator
            ->allowEmpty('meta_description');

        $validator
            ->allowEmpty('meta_keywords');

        $validator
            ->boolean('shutoff')
            ->requirePresence('shutoff', 'create')
            ->notEmpty('shutoff');

        $validator
            ->requirePresence('format_article', 'create')
            ->notEmpty('format_article');

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
        $rules->add($rules->isUnique(['alias']));
        $rules->add($rules->existsIn(['poll_id'], 'Poll'));
        $rules->add($rules->existsIn(['dominus_id'], 'Dominus'));

        return $rules;
    }
}
