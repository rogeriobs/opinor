<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PollOptionsVotes Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Ipsum
 * @property \Cake\ORM\Association\BelongsTo $PollOptions
 * @property \Cake\ORM\Association\BelongsTo $Poll
 *
 * @method \App\Model\Entity\PollOptionsVote get($primaryKey, $options = [])
 * @method \App\Model\Entity\PollOptionsVote newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PollOptionsVote[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PollOptionsVote|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PollOptionsVote patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PollOptionsVote[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PollOptionsVote findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PollOptionsVotesTable extends Table
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

        $this->setTable('poll_options_votes');
        $this->setDisplayField('ipsum_id');
        $this->setPrimaryKey(['ipsum_id', 'poll_options_id']);

        $this->addBehavior('Timestamp');

        $this->belongsTo('Ipsum', [
            'foreignKey' => 'ipsum_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('PollOptions', [
            'foreignKey' => 'poll_options_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Poll', [
            'foreignKey' => 'poll_id',
            'joinType' => 'INNER'
        ]);
    }

}
