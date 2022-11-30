<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Media Model
 *
 * @property \App\Model\Table\I18nTable|\Cake\ORM\Association\BelongsToMany $I18n
 *
 * @method \App\Model\Entity\Media get($primaryKey, $options = [])
 * @method \App\Model\Entity\Media newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Media[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Media|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Media patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Media[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Media findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MediaTable extends Table
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

        $this->setTable('media');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->addBehavior('Translate', [
            'fields' => ['title_ete','title_hiver','lien_ete','lien_hiver'],
            'translationTable' => 'MediaI18n'
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
            ->scalar('name_key')
            ->maxLength('name_key', 255)
            ->requirePresence('name_key', 'create')
            ->notEmpty('name_key');

        $validator
            ->scalar('title_ete')
            ->maxLength('title_ete', 255)
            ->requirePresence('title_ete', 'create')
            ->notEmpty('title_ete');

        $validator
            ->scalar('title_hiver')
            ->maxLength('title_hiver', 255)
            ->requirePresence('title_hiver', 'create')
            ->notEmpty('title_hiver');

        $validator
            ->scalar('lien_ete')
            ->maxLength('lien_ete', 255)
            // ->requirePresence('lien_ete', 'create')
            ->allowEmpty('lien_ete');

        $validator
            ->scalar('lien_hiver')
            ->maxLength('lien_hiver', 255)
            // ->requirePresence('lien_hiver', 'create')
            ->allowEmpty('lien_hiver');

        return $validator;
    }
}
