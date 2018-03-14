<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Estados Model
 *
 * @property \Cake\ORM\Association\HasMany $Cidades
 *
 * @method \App\Model\Entity\Estado get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estado newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Estado[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estado|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estado patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estado[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estado findOrCreate($search, callable $callback = null, $options = [])
 */
class EstadosTable extends Table
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

        $this->table('estados');
        $this->displayField('nome');
        $this->primaryKey('id');

        $this->hasMany('Cidades', [
            'foreignKey' => 'estado_id'
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
                ->requirePresence('nome', 'create')
                ->notEmpty('nome');

        $validator
                ->requirePresence('uf', 'create')
                ->notEmpty('uf');

        $validator
                ->integer('uf_ibge')
                ->requirePresence('uf_ibge', 'create')
                ->notEmpty('uf_ibge');

        $validator
                ->integer('uf_sl')
                ->requirePresence('uf_sl', 'create')
                ->notEmpty('uf_sl');

        $validator
                ->requirePresence('uf_ddd', 'create')
                ->notEmpty('uf_ddd');

        $validator
                ->requirePresence('regiao', 'create')
                ->notEmpty('regiao');

        return $validator;
    }

    public function get_for_options_in_select()
    {
        $list = [];
        
        $estados = $this->find("all", [
            "order" => [
                "Estados.nome" => "ASC"
            ]
        ])->toArray();
        
        foreach($estados as $estado):
            $list[] = ["text" => $estado->nome, "value" => $estado->id, "sigla" => $estado->uf];
        endforeach;
        
        return $list;
    }

}
