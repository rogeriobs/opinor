<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminMenuItens Model
 *
 * @property \Cake\ORM\Association\BelongsTo $AdminMenu
 *
 * @method \App\Model\Entity\AdminMenuIten get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdminMenuIten newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdminMenuIten[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenuIten|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdminMenuIten patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenuIten[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenuIten findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminMenuItensTable extends Table
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

        $this->setTable('admin_menu_itens');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('AdminMenu', [
            'foreignKey' => 'admin_menu_id',
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
            ->requirePresence('descricao', 'create')
            ->notBlank('descricao');

        $validator
            ->integer('ordem')
            ->notBlank('ordem');

        $validator
            ->requirePresence('action_perm', 'create')
            ->notBlank('action_perm');
        
        $validator
            ->requirePresence('admin_menu_id', 'create')
            ->notBlank('admin_menu_id');

        $validator
            ->allowEmpty('params');

        $validator
            ->requirePresence('controller_go', 'create')
            ->notBlank('controller_go');

        $validator
            ->requirePresence('action_go', 'create')
            ->notBlank('action_go');

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
        $rules->add($rules->existsIn(['admin_menu_id'], 'AdminMenu'));

        return $rules;
    }
}
