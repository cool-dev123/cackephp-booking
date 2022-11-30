<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;
use SoapClient;
use Cake\Utility\Xml;
use \SoapServer;
use \Panier;
use Cake\Datasource\ConnectionManager;
/**
 * Report Controller
 *
 */
class ReportController extends AppController
{
    
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $session = $this->request->session();
                                if(!$session->check("Gestionnaire.info")){
                                        return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
                                }
    }
	public $helpers = ['Text','AnnonceFormater'];
	//Create on date 22-02-17
    public function view()
    {
        $conn = ConnectionManager::get('default');

        $session = $this->request->session();
        $this->set('InfoGes',$session->read('Gestionnaire.info'));

        $session_array = array();
        $session_array = $session->read('Gestionnaire.info');

        $session_id = $session_array[G][id];
        $session_role = $session_array[G][role];

        $results = array();

        if(isset($_POST['search']))
        {
					$deb = explode('/', $_POST['start_date']);
					$date=date("Y-m-d", mktime(0, 0, 0, $deb[1],$deb[0],$deb[2]));
            //If logged in user is admin, then show the compleate records
            if($session_role=='admin')
            {
                if($_POST['day']=='Day')
                {
                    $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio, L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
										mail_prop,P.portable as proprietaire_port1,P.portable2 as proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as commentaire
                        from reservations R
                        inner join utilisateurs L on R.utilisateur_id=L.id
                        inner join annonces A on A.id=R.annonce_id
                        inner join lieugeos LG on A.lieugeo_id=LG.id
                        inner join utilisateurs P on P.id=A.proprietaire_id
                        inner join dispos D on D.reservation_id=R.id
                        inner join residences RS on A.batiment=RS.id
                        left join annoncegestionnaires AG on AG.id_annonces=A.id
                        left join gestionnaires G on AG.id_gestionnaires=G.id
                        where R.statut= 90 and R.dbt_at='".$date."'
                        group by R.id order by R.dbt_at DESC");
                }
                elseif($_POST['day']=='Week')
                {


                    $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio, L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as
										mail_prop,P.portable as proprietaire_port1,P.portable2 as proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as commentaire
                        from reservations R
                        inner join utilisateurs L on R.utilisateur_id=L.id
                        inner join annonces A on A.id=R.annonce_id
                        inner join lieugeos LG on A.lieugeo_id=LG.id
                        inner join utilisateurs P on P.id=A.proprietaire_id
                        inner join dispos D on D.reservation_id=R.id
                        inner join residences RS on A.batiment=RS.id
                        left join annoncegestionnaires AG on AG.id_annonces=A.id
                        left join gestionnaires G on AG.id_gestionnaires=G.id
                        where R.statut= 90 and YEARWEEK(R.dbt_at)=YEARWEEK('".$date."')
                        group by R.id order by R.dbt_at DESC");
                }
            }
            //Else logged in user is a manager
            elseif($session_role=='gestionnaire')
            {
                if($_POST['day']=='Day')
                {
                    $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio, L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as mail_prop,P.portable as proprietaire_port1,P.portable2 as proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as commentaire
                        from reservations R
                        inner join utilisateurs L on R.utilisateur_id=L.id
                        inner join annonces A on A.id=R.annonce_id
                        inner join lieugeos LG on A.lieugeo_id=LG.id
                        inner join utilisateurs P on P.id=A.proprietaire_id
                        inner join dispos D on D.reservation_id=R.id
                        inner join residences RS on A.batiment=RS.id
                        inner join annoncegestionnaires AG on AG.id_annonces=A.id
                        inner join gestionnaires G on AG.id_gestionnaires=G.id
                        where R.statut= 90 and R.dbt_at='".$date."' and G.id=".$session_id."
                        group by R.id order by R.dbt_at DESC");
                }
                elseif($_POST['day']=='Week')
                {

                    $stmt = $conn->execute("select P.prenom as prenom_proprio,P.nom_famille as nom_proprio, P.email as email_proprio, L.prenom as prenom_loc,L.nom_famille as nom_loc,R.dbt_at,R.fin_at,IF(D.promo_yn = 0, D.prix, D.promo_px) as prix,G.name as gestionnaire,RS.name as residence,LG.name as station,L.email as mail_locataire,L.portable as locataire_port1,L.portable2 as locataire_port2,P.email as mail_prop,P.portable as proprietaire_port1,P.portable2 as proprietaire_port2,A.num_app,DATEDIFF(R.fin_at,R.dbt_at) as duration,R.comment as commentaire
                        from reservations R
                        inner join utilisateurs L on R.utilisateur_id=L.id
                        inner join annonces A on A.id=R.annonce_id
                        inner join lieugeos LG on A.lieugeo_id=LG.id
                        inner join utilisateurs P on P.id=A.proprietaire_id
                        inner join dispos D on D.reservation_id=R.id
                        inner join residences RS on A.batiment=RS.id
                        inner join annoncegestionnaires AG on AG.id_annonces=A.id
                        inner join gestionnaires G on AG.id_gestionnaires=G.id
                        where R.statut= 90 and YEARWEEK(R.dbt_at)=YEARWEEK('".$date."') and G.id=".$session_id."
                        group by R.id order by R.dbt_at DESC");
                }

            }

            $results = $stmt ->fetchAll('assoc');

            $this->set('pagecontent',$results);
            $this->set('radio',$_POST['day']);

            $this->viewBuilder()->layout('manager');

        }
        else
        {
            $this->set('pagecontent',$results);
            $this->viewBuilder()->layout('manager');
        }


    }



}
