<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Massif Model
 *
 * @method \App\Model\Entity\Massif get($primaryKey, $options = [])
 * @method \App\Model\Entity\Massif newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Massif[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Massif|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Massif patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Massif[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Massif findOrCreate($search, callable $callback = null, $options = [])
 */
class MassifTable extends Table
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

        $this->setTable('massif');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Domaine')
            ->setForeignKey('massif_id')
            ->setDependent(true);

        $this->hasMany('Lieugeos')
            ->setForeignKey('massif_id')
            ->setDependent(true);

        $this->addBehavior('Translate', [
            'fields' => ['descreption', 'nom_url'],
            'translationTable' => 'MassifI18n'
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom')
            ->add('nom', [
                'unique' => [
                   'rule' => 'validateUnique',
                   'provider' => 'table',
                   'message' => 'Ce massif existe.']
                ]);

        $validator
            ->scalar('nom_url')
            ->maxLength('nom_url', 255)
            ->notEmpty('nom_url');

        $validator
            ->scalar('descreption')
            ->allowEmpty('descreption');

        // $validator
        //     ->requirePresence('image', 'create')
        //     ->allowEmpty('image', 'edit')
        //     ->add('image', '_chkImageExtension' , array(
        //         'rule' => 'chkImageExtension',
        //         'provider'=>'table',
        //         'message' => 'S\'il vous plaît télécharger une image valide.'
        //     ));
        return $validator;
    }

    // public function chkImageExtension($data,$context) {
    //     $return = true;
    //     if($data['name'] != ''){
    //         $fileData   = pathinfo($data['name']);
    //         $ext        = $fileData['extension'];
    //         $allowExtension = array('gif', 'jpeg', 'png', 'jpg');
    //         if(in_array($ext, $allowExtension)) {
    //             $return = true;
    //         } else {
    //             $return = false;
    //         }
    //     } else {
    //         $return = false;
    //     }
    //     return $return;
    // }
    function beforeDelete($event,$entity){
        $countDomaine = $this->Domaine->find()->where(['massif_id'=>$entity->id])->count();
        $countLieugeos = $this->Lieugeos->find()->where(['massif_id'=>$entity->id])->count();
        if ($countDomaine == 0 && $countLieugeos==0) {
            return true;
        } else {
            if($countDomaine != 0)
                $entity->setError('hasDomaines', ['']);
            if($countLieugeos != 0)
                $entity->setError('hasLieugeos', ['']);
            return false;
        }
    }
}
