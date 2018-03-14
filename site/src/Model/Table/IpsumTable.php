<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ipsum Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Cidades
 * @property \Cake\ORM\Association\HasMany $IpsumActivityLog
 * @property \Cake\ORM\Association\HasMany $NewsortopicComments
 * @property \Cake\ORM\Association\HasMany $NewsortopicCommentsRating
 * @property \Cake\ORM\Association\HasMany $PollOptionsVotes
 *
 * @method \App\Model\Entity\Ipsum get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ipsum newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ipsum[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ipsum|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ipsum patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ipsum[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ipsum findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class IpsumTable extends Table
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

        $this->table('ipsum');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Cidades', [
            'foreignKey' => 'cidade_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('IpsumActivityLog', [
            'foreignKey' => 'ipsum_id'
        ]);
        $this->hasMany('NewsortopicComments', [
            'foreignKey' => 'ipsum_id'
        ]);
        $this->hasMany('NewsortopicCommentsRating', [
            'foreignKey' => 'ipsum_id'
        ]);
        $this->hasMany('PollOptionsVotes', [
            'foreignKey' => 'ipsum_id'
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
                ->notBlank('nome', '× Digite seu nome');

        $validator
                ->email('email', false, '× E-mail inválido')
                ->requirePresence('email', 'create')
                ->notBlank('email', "× Digite um e-mail válido")
                ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table', 'message' => '× Este e-mail já foi cadastrado no site']);

        $validator
                ->requirePresence('password', 'create')
                ->notBlank('password', "× Digite uma senha");

        $validator->requirePresence('data_nascimento', 'create')
                ->date("data_nascimento", ['ymd'], "× Data de nascimento inválida")
                ->add('data_nascimento', 'custom', [
                    'rule' => [$this, 'validate_datanascimento'],
                    'message' => '× A idade minima para o cadastro é de 18 anos'
        ]);

        $validator
                ->requirePresence('cidade_id', 'create')
                ->notBlank('cidade_id', '× Selecione uma cidade na lista acima');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['cidade_id'], 'Cidades'));

        return $rules;

    }

    public function validate_datanascimento($value, $context)
    {
        $ano_atual = date("Y");
                        
        $ano_do_nascimento = $value['year'];
        
        if(strlen($ano_do_nascimento) == 4){
                                    
            if(intval($ano_atual) > intval($ano_do_nascimento)){
                
                return (intval($ano_atual) - intval($ano_do_nascimento)) >= 18;
                
            }
            
        }
        
        return false;
    }

}
