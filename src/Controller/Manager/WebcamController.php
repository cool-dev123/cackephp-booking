<?php
namespace App\Controller\Manager;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Manager/webcamController Controller
 *
 * @property \App\Model\Table\Manager/webcamControllerTable $Manager/webcamController */
class WebcamController extends AppController
{

    public function beforeFilter(Event $event){
        $session = $this->request->session();

        if(!$session->check("Gestionnaire.info")){
            return $this->redirect(["controller"=>"utilisateurs","action"=>"loginmanager","prefix"=>false]);
        }

        $this->set('InfoGes',$session->read('Gestionnaire.info'));
    }

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->viewBuilder()->layout('manager');
        $cams[1]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=43bdee6af8bd0fa4',
            'titre'=>'<span class=\'route_rouge\'>N90</span> Bourg-St-Maurice PR75+210',
            'direction'=>'vers Albertville'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[4]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5f6576a3e777b8b5',
            'titre'=>'<span class=\'route_bleu\'>A41 A43 N201</span> Chambéry nord accès A41 A43 N201 PR6+823',
            'direction'=>'vers Lyon'
            ];
        $cams[9]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ad00fcc0b6e70808',
              'titre'=>'<span class=\'route_rouge\'>N90</span> La Léchère PR44+53',
            'direction'=>'vers Moûtiers'
            //  'paragraphe'=>'paragraphe3 paragraphe3 paragraphe3'
            ];
        $cams[8]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=c7033a977bea92a3',
            'titre'=>'<span class=\'route_rouge\'>N90</span> Gilly-sur-Isère PR20+29',
            'direction'=>'vers Albertville'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[13]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=65d34bbbccd226d6',
            'titre'=>'<span class=\'route_rouge\'>N201</span> Sortie 15 Chambéry centre PR4+1033',
            'direction'=>'vers Lyon'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[0]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1610ec102cfab1d5',
            'titre'=>'<span class=\'route_rouge\'>N90</span> Aime PR63+900',
            'direction'=>'vers Albertville'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[14]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=296590e83815ffd7',
            'titre'=>'<span class=\'route_rouge\'>N85</span> Vizille PR56',
            'direction'=>'vers Grenoble'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[11]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1583f342ac82b18b',
            'titre'=>'<span class=\'route_bleu\'>A480</span> Rondeau PR7+384',
            'direction'=>'Lyon ou Aix en Pce'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[12]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=605d0f8dbb928f52',
            'titre'=>'<span class=\'route_rouge\'>N87</span> Rondeau PR1+1627',
            'direction'=>'vers Chambéry'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[7]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=3db31ba1af6c5536',
            'titre'=>'<span class=\'route_rouge\'>N87</span> Eybens PR4+200',
            'direction'=>'vers Aix-en-Pce'
            ];
        $cams[10]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=53e042b4ed44f138',
            'titre'=>'<span class=\'route_rouge\'>N87</span> Meylan PR10+590',
            'direction'=>'vers Aix-en-Pce'
            ];
        $cams[2]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ba615cbbbbe498b3',
            'titre'=>'<span class=\'route_bleu\'>A43</span> Bron PR2+841',
            'direction'=>'vers Lyon'
            ];
        $cams[3]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ba615cbbbbe498b3',
            'titre'=>'<span class=\'route_bleu\'>A43</span> Bron PR2+841',
            'direction'=>'vers Lyon'
            ];
        $cams[6]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=2463103484cafa66',
            'titre'=>'<span class=\'route_rouge\'>N85</span> Champagnier PR52+438',
            'direction'=>'vers Grenoble'
            ];
        $cams[5]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5840c840a0b33271',
            'titre'=>'<span class=\'route_rouge\'>N201</span> Chambéry sortie centre commercial PR5+980',
            'direction'=>'vers Albertville'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $this->set('cams',$cams);
    }
}
