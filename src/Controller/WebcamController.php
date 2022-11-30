<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Http\Client;

/**
 * Manager/webcamController Controller
 *
 * @property \App\Model\Table\Manager/webcamControllerTable $Manager/webcamController */
class WebcamController extends AppController
{
    public function beforeRender() {
        $this->loadModel("Lieugeos");
		$enrs = $this->Lieugeos->find("all",["conditions"=>["niveau >="=>3, "etat = 1"],"order"=>"Lieugeos.name"]);
		$ar[]="Destination";
		foreach($enrs as $enr)  $ar[$enr->id]=$enr->name;
		$this->set("l_lieugeos",$ar);
    }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=43bdee6af8bd0fa4',
            'titre'=>'Bourg-St-Maurice N90 PR75+210',
            'direction'=>'vers Albertville',
            'lat'=>'45.6025834758',   'lng'=>'6.7539231883'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1610ec102cfab1d5',
            'titre'=>'Aime N90 PR63+900',
            'direction'=>'vers Albertville',
            'lat'=>'45.5531763326',   'lng'=>'6.644220686'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ad00fcc0b6e70808',
              'titre'=>'La Léchère N90 PR44+53',
            'direction'=>'vers Moûtiers',
            'lat'=>'45.5204065524',   'lng'=>'6.4852690214'
            //  'paragraphe'=>'paragraphe3 paragraphe3 paragraphe3'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=c7033a977bea92a3',
            'titre'=>'Gilly-sur-Isère N90 PR20+29',
            'direction'=>'vers Albertville',
            'lat'=>'45.6502275707',   'lng'=>'6.3465470639'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=65d34bbbccd226d6',
            'titre'=>'Sortie 15 Chambéry centre N201 PR4+1033',
            'direction'=>'vers Lyon',
            'lat'=>'45.5858072475',   'lng'=>'5.9068073314'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5840c840a0b33271',
            'titre'=>'Chambéry sortie centre commercial N201 PR5+980',
            'direction'=>'vers Albertville',
            'lat'=>'45.5918215718',   'lng'=>'5.8978312521'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=296590e83815ffd7',
            'titre'=>'Vizille N85 PR56',
            'direction'=>'vers Grenoble',
            'lat'=>'45.0834293591',   'lng'=>'5.7623345177'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1583f342ac82b18b',
            'titre'=>'Rondeau A480 PR7+384',
            'direction'=>'Lyon ou Aix en Pce',
            'lat'=>'45.1590147768',   'lng'=>'5.7008829625'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=605d0f8dbb928f52',
            'titre'=>'Rondeau N87 PR1+1627',
            'direction'=>'vers Chambéry',
            'lat'=>'45.1585665623',   'lng'=>'5.7068985357'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=3db31ba1af6c5536',
            'titre'=>'Eybens N87 PR4+200',
            'direction'=>'vers Aix-en-Pce',
            'lat'=>'45.1558033754',   'lng'=>'5.7469724507'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=53e042b4ed44f138',
            'titre'=>'Meylan N87 PR10+590',
            'direction'=>'vers Aix-en-Pce',
            'lat'=>'45.2037339102',   'lng'=>'5.7825788638'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ba615cbbbbe498b3',
            'titre'=>'Bron A43 PR2+841',
            'direction'=>'vers Lyon',
            'lat'=>'45.7261862655',   'lng'=>'4.9170020308'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5f6576a3e777b8b5',
            'titre'=>'Chambéry nord accès A41 A43 N201 PR6+823',
            'direction'=>'vers Lyon',
            'lat'=>'45.5985282081',   'lng'=>'5.8931476946'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=2463103484cafa66',
            'titre'=>'Champagnier N85 PR52+438',
            'direction'=>'vers Grenoble',
            'lat'=>'45.0936110211',   'lng'=>'5.7220846008'
            ];
        $villes=[
            'Toutes'=>['lat'=>45.5325731,'lng'=>5.7764053,'zoom'=>8.8],
            'Bourg-Saint-Maurice'=>['lat'=>45.6025834758,'lng'=>6.7539231883,'zoom'=>14],
            'Aime'=>['lat'=>45.5531763326,'lng'=>6.644220686,'zoom'=>14],
            'La Léchère'=>['lat'=>45.5204065524,'lng'=>6.4852690214,'zoom'=>14],
            'Gilly-sur-Isère'=>['lat'=>45.6502275707,'lng'=>6.3465470639,'zoom'=>14],
            'Chambéry'=>['lat'=>45.5858072475,'lng'=>5.9068073314,'zoom'=>13],
            'Vizille'=>['lat'=>45.0834293591,'lng'=>5.7623345177,'zoom'=>14],
            'Rondeau'=>['lat'=>45.1563329,'lng'=>5.7040436,'zoom'=>14],
            'Eybens'=>['lat'=>45.1558033754,'lng'=>5.7469724507,'zoom'=>14],
            'Meylan'=>['lat'=>45.2037339102,'lng'=>5.7825788638,'zoom'=>13],
            'Bron'=>['lat'=>45.7261862655,'lng'=>4.9170020308,'zoom'=>14],
            'Champagnier'=>['lat'=>45.0936110211,'lng'=>5.7220846008,'zoom'=>14],
        ];
        $this->set('places',$villes);
        $this->set('cams',$cams);
    }

    public function camvideo()
    {
        $this->viewBuilder()->layout(false);
        $this->set('url',$this->request->query['link']);
    }

    public function indexMobile(){
        $this->viewBuilder()->layout(false);
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=43bdee6af8bd0fa4',
            'titre'=>'Bourg-St-Maurice N90 PR75+210',
            'direction'=>'vers Albertville',
            'lat'=>'45.6025834758',   'lng'=>'6.7539231883'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1610ec102cfab1d5',
            'titre'=>'Aime N90 PR63+900',
            'direction'=>'vers Albertville',
            'lat'=>'45.5531763326',   'lng'=>'6.644220686'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ad00fcc0b6e70808',
              'titre'=>'La Léchère N90 PR44+53',
            'direction'=>'vers Moûtiers',
            'lat'=>'45.5204065524',   'lng'=>'6.4852690214'
            //  'paragraphe'=>'paragraphe3 paragraphe3 paragraphe3'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=c7033a977bea92a3',
            'titre'=>'Gilly-sur-Isère N90 PR20+29',
            'direction'=>'vers Albertville',
            'lat'=>'45.6502275707',   'lng'=>'6.3465470639'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=65d34bbbccd226d6',
            'titre'=>'Sortie 15 Chambéry centre N201 PR4+1033',
            'direction'=>'vers Lyon',
            'lat'=>'45.5858072475',   'lng'=>'5.9068073314'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5840c840a0b33271',
            'titre'=>'Chambéry sortie centre commercial N201 PR5+980',
            'direction'=>'vers Albertville',
            'lat'=>'45.5918215718',   'lng'=>'5.8978312521'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=296590e83815ffd7',
            'titre'=>'Vizille N85 PR56',
            'direction'=>'vers Grenoble',
            'lat'=>'45.0834293591',   'lng'=>'5.7623345177'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=1583f342ac82b18b',
            'titre'=>'Rondeau A480 PR7+384',
            'direction'=>'Lyon ou Aix en Pce',
            'lat'=>'45.1590147768',   'lng'=>'5.7008829625'
            //  'paragraphe'=>'paragraphe1 paragraphe1 paragraphe1'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=605d0f8dbb928f52',
            'titre'=>'Rondeau N87 PR1+1627',
            'direction'=>'vers Chambéry',
            'lat'=>'45.1585665623',   'lng'=>'5.7068985357'
            //  'paragraphe'=>'paragraphe2 paragraphe2 paragraphe2'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=3db31ba1af6c5536',
            'titre'=>'Eybens N87 PR4+200',
            'direction'=>'vers Aix-en-Pce',
            'lat'=>'45.1558033754',   'lng'=>'5.7469724507'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=53e042b4ed44f138',
            'titre'=>'Meylan N87 PR10+590',
            'direction'=>'vers Aix-en-Pce',
            'lat'=>'45.2037339102',   'lng'=>'5.7825788638'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=ba615cbbbbe498b3',
            'titre'=>'Bron A43 PR2+841',
            'direction'=>'vers Lyon',
            'lat'=>'45.7261862655',   'lng'=>'4.9170020308'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=5f6576a3e777b8b5',
            'titre'=>'Chambéry nord accès A41 A43 N201 PR6+823',
            'direction'=>'vers Lyon',
            'lat'=>'45.5985282081',   'lng'=>'5.8931476946'
            ];
        $cams[]=['url'=>'https://webvia.fr/ncs_nce/getSharedVideo.do?token=2463103484cafa66',
            'titre'=>'Champagnier N85 PR52+438',
            'direction'=>'vers Grenoble',
            'lat'=>'45.0936110211',   'lng'=>'5.7220846008'
            ];
        $villes=[
            'Toutes'=>['lat'=>45.5325731,'lng'=>5.7764053,'zoom'=>7.8],
            'Bourg-Saint-Maurice'=>['lat'=>45.6025834758,'lng'=>6.7539231883,'zoom'=>14],
            'Aime'=>['lat'=>45.5531763326,'lng'=>6.644220686,'zoom'=>14],
            'La Léchère'=>['lat'=>45.5204065524,'lng'=>6.4852690214,'zoom'=>14],
            'Gilly-sur-Isère'=>['lat'=>45.6502275707,'lng'=>6.3465470639,'zoom'=>14],
            'Chambéry'=>['lat'=>45.5858072475,'lng'=>5.9068073314,'zoom'=>13],
            'Vizille'=>['lat'=>45.0834293591,'lng'=>5.7623345177,'zoom'=>14],
            'Rondeau'=>['lat'=>45.1563329,'lng'=>5.7040436,'zoom'=>14],
            'Eybens'=>['lat'=>45.1558033754,'lng'=>5.7469724507,'zoom'=>14],
            'Meylan'=>['lat'=>45.2037339102,'lng'=>5.7825788638,'zoom'=>13],
            'Bron'=>['lat'=>45.7261862655,'lng'=>4.9170020308,'zoom'=>14],
            'Champagnier'=>['lat'=>45.0936110211,'lng'=>5.7220846008,'zoom'=>14],
        ];
        $this->set('places',$villes);
        $this->set('cams',$cams);
    }
}
