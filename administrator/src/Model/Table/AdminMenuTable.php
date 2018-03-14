<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AdminMenu Model
 *
 * @property \Cake\ORM\Association\HasMany $AdminMenuItens
 *
 * @method \App\Model\Entity\AdminMenu get($primaryKey, $options = [])
 * @method \App\Model\Entity\AdminMenu newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AdminMenu[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenu|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AdminMenu patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenu[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AdminMenu findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AdminMenuTable extends Table
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

        $this->setTable('admin_menu');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('AdminMenuItens', [
            'foreignKey' => 'admin_menu_id'
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
            ->notEmpty('descricao');

        $validator
            ->integer('ordem')
            ->allowEmpty('ordem');

        $validator
            ->requirePresence('faicon', 'create')
            ->notEmpty('faicon');

        return $validator;
    }
}
