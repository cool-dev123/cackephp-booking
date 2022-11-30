<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NumeroUtiles Model
 *
 * @method \App\Model\Entity\NumeroUtile get($primaryKey, $options = [])
 * @method \App\Model\Entity\NumeroUtile newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NumeroUtile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NumeroUtile|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NumeroUtile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NumeroUtile[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NumeroUtile findOrCreate($search, callable $callback = null, $options = [])
 */
class NumeroUtilesTable extends Table
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

        $this->setTable('numero_utiles');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Lieugeos', [
            'foreignKey' => 'id_lieugeo',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('Bibliotheques',[
            'foreignKey' => 'id_bibliotheque',
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
            ->scalar('nom')
            ->maxLength('nom', 255)
            ->requirePresence('nom', 'create')
            ->notEmpty('nom');

        $validator
            ->integer('id_lieugeo')
            ->requirePresence('id_lieugeo', 'create')
            ->notEmpty('id_lieugeo');

        $validator
            ->scalar('number')
            ->maxLength('number', 255)
            ->requirePresence('number', 'create')
            ->notEmpty('number');
        $validator
            ->email('email')
            ->maxLength('email', 255)
            ->requirePresence('email', 'create')
            ->notEmpty('email');
        $validator
            ->scalar('latitude')
            ->maxLength('latitude', 255)
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');
        $validator
            ->scalar('longitude')
            ->maxLength('longitude', 255)
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');
            // $validator
            //     ->requirePresence('image', 'create')
            //     ->notEmpty('image')
            //     ->add('image', '_chkImageExtension' , array(
            //                 'rule' => 'chkImageExtension',
            //                 'provider'=>'table',
            //                 'message' => 'S\'il vous plaît télécharger une image valide.'
            //             ));

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

        /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['id_lieugeo'], 'Lieugeos'));
        $rules->add($rules->existsIn(['id_bibliotheque'], 'Bibliotheques'));

        return $rules;
    }

    public function getNutiles($gestId){
        $nUtiles=$this->find()->join([
            'lieugeo'=>[
                'table'=>'lieugeos',
                'type'=>'inner',
                'conditions'=>'lieugeo.id=NumeroUtiles.id_lieugeo'
            ]
        ]);
        if($gestId!=null){
            $nUtiles->join([
                'Village' => [
                    'table' => 'villages',
                    'type' => 'inner',
                    'conditions' => ['Village.lieugeo_id=lieugeo.id']
                ],
                'GV' => [
                    'table' => 'gestionnaires_villages',
                    'type' => 'inner',
                    'conditions' => ['GV.gestionnaire_id'=>$gestId,'Village.id=GV.villages_id']
                ],
            ]);
        }
        return $nUtiles->select(['NumeroUtiles.id','NumeroUtiles.nom','NumeroUtiles.number','lieugeo.name']);
    }
}
