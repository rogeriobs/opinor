<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DominusPerfis Model
 *
 * @method \App\Model\Entity\DominusPerfi get($primaryKey, $options = [])
 * @method \App\Model\Entity\DominusPerfi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DominusPerfi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DominusPerfi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DominusPerfi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DominusPerfi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DominusPerfi findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class DominusPerfisTable extends Table
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

        $this->setTable('dominus_perfis');
        $this->setDisplayField('descricao');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->requirePresence('role', 'create')
            ->notEmpty('role');

        $validator
            ->requirePresence('permissoes', 'create')
            ->notEmpty('permissoes');

        return $validator;
    }
}
