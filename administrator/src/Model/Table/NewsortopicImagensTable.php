<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NewsortopicImagens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Newsortopic
 *
 * @method \App\Model\Entity\NewsortopicImagen get($primaryKey, $options = [])
 * @method \App\Model\Entity\NewsortopicImagen newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NewsortopicImagen[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicImagen|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NewsortopicImagen patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicImagen[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NewsortopicImagen findOrCreate($search, callable $callback = null, $options = [])
 */
class NewsortopicImagensTable extends Table
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

        $this->setTable('newsortopic_imagens');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
                ->integer('id')
                ->allowEmpty('id', 'create');

        $validator
                ->requirePresence('filename', 'create')
                ->notEmpty('filename');

        $validator
                ->boolean('head')
                ->requirePresence('head', 'create')
                ->notEmpty('head');

        $validator
                ->allowEmpty('legenda');

        $validator
                ->requirePresence('real_width', 'create')
                ->notEmpty('real_width');

        $validator
                ->requirePresence('real_height', 'create')
                ->notEmpty('real_height');

        $validator
                ->requirePresence('use_width', 'create')
                ->notEmpty('use_width');

        $validator
                ->requirePresence('use_height', 'create')
                ->notEmpty('use_height');

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

    public function afterDelete($event, $entity, $options)
    {
        $file_alta = DIR_FRONT . 'webroot/img/articles/alta/' . $entity->filename;
        $file_leve = DIR_FRONT . 'webroot/img/articles/leve/' . $entity->filename;

        if(file_exists($file_alta)):

            unlink($file_alta);

        endif;
        
        if(file_exists($file_leve)):

            unlink($file_leve);

        endif;

        return true;

    }

}
