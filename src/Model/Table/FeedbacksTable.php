<?php
namespace App\Model\Table;

use App\Model\Entity\Feedback;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Feedbacks Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Annonces * @property \Cake\ORM\Association\BelongsTo $Utilisateurs * @property \Cake\ORM\Association\HasMany $Ratings */
class FeedbacksTable extends Table
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

        $this->table('feedbacks');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Annonces', [
            'foreignKey' => 'annonce_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Utilisateurs', [
            'foreignKey' => 'utilisateur_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Ratings', [
            'foreignKey' => 'feedback_id',
            'dependent' => true,
            'cascadeCallbacks' => true
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
            ->integer('id')            ->allowEmpty('id', 'create');
        $validator
            ->requirePresence('titre', 'create')            ->notEmpty('titre');
        $validator
            ->requirePresence('commentaire', 'create')            ->notEmpty('commentaire');
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
        $rules->add($rules->existsIn(['annonce_id'], 'Annonces'));
        $rules->add($rules->existsIn(['utilisateur_id'], 'Utilisateurs'));
        return $rules;
    }
    /**
     *
     **/
    public function getarraycommentaires($url,$get,$gestId=null){
        if($gestId != null){
            $listerating = $this->find()->join([
                'Ratings' => [
                    'table' => 'ratings',
                    'type' => 'inner',
                    'conditions' => 'Ratings.feedback_id = Feedbacks.id',
                ],
                'Utilisateurs' => [
                    'table' => 'utilisateurs',
                    'type' => 'inner',
                    'conditions' => 'Utilisateurs.id = Feedbacks.utilisateur_id',
                ],
                'Annonces' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['Annonces.id=Feedbacks.annonce_id','Annonces.id_gestionnaires'=>$gestId]
                ],
                'Contrat' => [
                    'table' => 'contrats',
                    'type' => 'inner',
                    'conditions' => ['Contrat.annonce_id=Annonces.id','Contrat.visible'=>1]
                ]
            ]);
        }else{
            $listerating = $this->find()->join([
                'Ratings' => [
                    'table' => 'ratings',
                    'type' => 'inner',
                    'conditions' => 'Ratings.feedback_id = Feedbacks.id',
                ],
                'Utilisateurs' => [
                    'table' => 'utilisateurs',
                    'type' => 'inner',
                    'conditions' => 'Utilisateurs.id = Feedbacks.utilisateur_id',
                ],
                'Annonces' => [
                    'table' => 'annonces',
                    'type' => 'inner',
                    'conditions' => ['Annonces.id=Feedbacks.annonce_id']
                ],
                // 'Contrat' => [
                //     'table' => 'contrats',
                //     'type' => 'inner',
                //     'conditions' => ['Contrat.annonce_id=Annonces.id','Contrat.visible'=>1]
                // ]
            ]);
        }
        
        $listerating->group(['Feedbacks.id','Feedbacks.annonce_id','Feedbacks.titre','Feedbacks.activated','Utilisateurs.prenom','Utilisateurs.nom_famille','Annonces.proprietaire_id'])
        ->order(['Feedbacks.activated' => 'ASC'])
        ->select(['Feedbacks.id','Feedbacks.annonce_id','Feedbacks.titre','Feedbacks.activated','Utilisateurs.prenom','Utilisateurs.nom_famille','Annonces.proprietaire_id','Ratings__note'=>'ROUND(sum(Ratings.note)/3,1)']);
        $output = array(
            "sEcho" => intval($get['sEcho']),
            "iTotalRecords" => $listerating->count(),
            "iTotalDisplayRecords" => $listerating->count(),
            "data" => array()
        );
      // Notes Globales
  		foreach ($listerating as $key) {
            //Propriétaire détail
            $utilisateurs = TableRegistry::get('Utilisateurs');
            $proprietaire = $utilisateurs->find()->where(['id'=>$key['Annonces']['proprietaire_id']]);
            if($proprietaire = $proprietaire->first()){
                $row[0] = $key->id;
                $row[1] = $key['Utilisateurs']['prenom']." ".$key['Utilisateurs']['nom_famille'];
                $row[2] = $key->annonce_id;
                $row[3] = $proprietaire->prenom." ".$proprietaire->nom_famille;
                $row[4] = $proprietaire->portable." / ".$proprietaire->email;
                $row[5] = $key->titre;
                $row[6] = "<div class='text-center'><strong>".$key['Ratings']['note']." / 5 </strong></div>";
                $row[7] = "<button data-toggle=\"modal\" data-target=\"#send_mail_modal\" data-href='".$url."manager/gestionnaires/sendmailCommentaire/".$proprietaire->email."' class=\"contacterProp btn btn-sm btn-success btn-rounded\"><span class=\"btn-text\">Contacter Propriétaire</span> <span class=\"btn-label\"></span></button>";
                if($key->activated == 0){
                    $row[8] = "<a id=\"activate_$key->id\" alt='activer' style='cursor:pointer' data-type=\"activate\" data-key=\"$key->id\" class=\"exclamation-circle\" href=\"#\"><i class=\"fa fa-exclamation-circle\"></i></a>";
                }
                if($key->activated == 1){
                    $row[8] = "<a id=\"activate_$key->id\" alt='desactiver' style='cursor:pointer' data-type=\"desactivate\" data-key=\"$key->id\" class=\"check-circle\" href=\"#\"><i class=\"fa fa-check-circle\"></i></a>";
                }
                $row[9] = '<div class="text-center">'
                        . '<button data-href="'.$url.'manager/gestionnaires/editcommentaire/'.$key->id.'" data-toggle="modal" data-target="#comment_details" class="edit_loca btn btn-sm btn-default btn-icon-anim btn-circle"><i class="fa fa-search"></i></button>'
                        . '<button data-key="'.$key->id.'" class="delete_loc btn btn-sm btn-info btn-icon-anim btn-circle"><i class="icon-trash"></i></button>'
                        . '</div>';
        
                $output['data'][] = $row;
            }       
  		}

      return $output;
    }
}
