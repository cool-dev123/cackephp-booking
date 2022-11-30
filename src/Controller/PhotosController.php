<?php
namespace App\Controller;

use App\Controller\AppController;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Cake\Cache\Cache;

/**
 * Photos Controller
 *
 * @property \App\Model\Table\PhotosTable $Photos
 */
class PhotosController extends AppController
{

  /**
   * Index method
   *
   * @return \Cake\Network\Response|null
   */
  public function index(){
    $this->paginate = ['contain' => ['Annonces']];
    $photos = $this->paginate($this->Photos);
    $this->set(compact('photos'));
    $this->set('_serialize', ['photos']);
  }
  /**
   * View method
   *
   * @param string|null $id Photo id.
   * @return \Cake\Network\Response|null
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null){
    $photo = $this->Photos->get($id, ['contain' => ['Annonces']]);
    $this->set('photo', $photo);
    $this->set('_serialize', ['photo']);
  }
  /**
   * Add method
   *
   * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
   */
  public function add(){
    $photo = $this->Photos->newEntity();
    if ($this->request->is('post')) {
        $photo = $this->Photos->patchEntity($photo, $this->request->data);
        if ($this->Photos->save($photo)) {
            // $this->Flash->success(__('The photo has been saved.'),['clear'=> true]);
            return $this->redirect(['action' => 'index']);
        } else {
            // $this->Flash->error(__('The photo could not be saved. Please, try again.'),['clear'=> true]);
        }
    }
    $annonces = $this->Photos->Annonces->find('list', ['limit' => 200]);
    $this->set(compact('photo', 'annonces'));
    $this->set('_serialize', ['photo']);
  }
  /**
   * Edit method
   *
   * @param string|null $id Photo id.
   * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Network\Exception\NotFoundException When record not found.
   */
  public function edit($id = null)
  {
      $photo = $this->Photos->get($id, [
          'contain' => []
      ]);
      if ($this->request->is(['patch', 'post', 'put'])) {
          $photo = $this->Photos->patchEntity($photo, $this->request->data);
          if ($this->Photos->save($photo)) {
            //   $this->Flash->success(__('The photo has been saved.'),['clear'=> true]);
              return $this->redirect(['action' => 'index']);
          } else {
            //   $this->Flash->error(__('The photo could not be saved. Please, try again.'),['clear'=> true]);
          }
      }
      $annonces = $this->Photos->Annonces->find('list', ['limit' => 200]);
      $this->set(compact('photo', 'annonces'));
      $this->set('_serialize', ['photo']);
  }

  function getId(){
    $result = $this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$this->request->data['id'], "Photos.numero <> 1"]]);
    $i = 0;
    foreach ($result as $d){
        $data[$i]['id'] = $d->id;
        $data[$i]['numero'] = $d->numero;
        $i = $i+1;
    }
    $this->set("tab",$data);
    Cache::clear(false);
  }
  /**
   * Delete method
   *
   * @param string|null $id Photo id.
   * @return \Cake\Network\Response|null Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  function delete()
  {
      if(!empty($this->request->data['id']))
      {
          $photo = $this->Photos->get($this->request->data['photo_id']);
          if ($this->Photos->delete($photo)) {
            $prefixe = $_SERVER['DOCUMENT_ROOT'];
            $vignette ="vignette-".$photo->annonce_id."-".$photo->numero.".jpg";

            $this->loadModel('Annonces');
            $annonce=$this->Annonces->get($photo->annonce_id, ['contain' => ['Lieugeos','Villages']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
            $village_nom = str_replace(" – ", "-", $village_nom);
            $village_nom = str_replace(" ", "-", $village_nom);
            $vignetteG = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$photo->annonce_id."-".$photo->numero."-Alpissime.jpg";
            // $vignetteG="vignette-".$photo->annonce_id."-".$photo->numero.".G.jpg";

            $vignetteP="vignette-".$photo->annonce_id."-".$photo->numero.".P.jpg";
            $destname = "$prefixe/webroot/images_ann/".$photo->annonce_id."/";
            unlink($destname.$vignette);
            unlink($destname.$vignetteG);
            unlink($destname.$vignetteP);
            Cache::clear(false);
            $this->Flash->success(__('Les modifications ont bien été enregistrées'),['clear'=> true]);
          }
      }
  }
  /**
   *
   **/
  function deletefirst(){
    if(!empty($this->request->data['id']))
    {
        $photo = $this->Photos->find()->where(["Photos.annonce_id=".$this->request->data['id'], "Photos.numero=1"])->first();
        if ($this->Photos->delete($photo)) {
            $prefixe = $_SERVER['DOCUMENT_ROOT'];
            $vignette ="vignette-".$photo->annonce_id."-".$photo->numero.".jpg";

            $this->loadModel('Annonces');
            $annonce=$this->Annonces->get($photo->annonce_id, ['contain' => ['Lieugeos','Villages']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
            $village_nom = str_replace(" – ", "-", $village_nom);
            $village_nom = str_replace(" ", "-", $village_nom);
            $vignetteG = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$photo->annonce_id."-".$photo->numero."-Alpissime.jpg";
            // $vignetteG="vignette-".$photo->annonce_id."-".$photo->numero.".G.jpg";

            $vignetteP="vignette-".$photo->annonce_id."-".$photo->numero.".P.jpg";
            $destname = "$prefixe/webroot/images_ann/".$photo->annonce_id."/";
            unlink($destname.$vignette);
            unlink($destname.$vignetteG);
            unlink($destname.$vignetteP);
            Cache::clear(false);
            $this->Flash->success(__('Les modifications ont bien été enregistrées'),['clear'=> true]);
        }
    }
  }
    /**
     * Uploadnew method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function uploadnew(){  
        if($this->request->data['pronumber'] != 0){
            $prefixe = $_SERVER['DOCUMENT_ROOT'];
            $destname = "$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/";  
            if(!is_dir($destname))   @mkdir("$prefixe/webroot/images_ann/".$this->request->data['pronumber'], 0777, true); 
    
          if(!empty($_FILES)){
            $data = $this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$this->request->data['pronumber']]]);
            $count = $data->count();
            if($count < 20){
                $i = 2;
                while($i<21){
                    $f = $this->Photos->find("all",["conditions"=>["Photos.numero"=>$i,"Photos.annonce_id"=>$this->request->data['pronumber']]])->count();
                    if($f == 1)
                    {
                            $i++;
                    }else{
                        $num = $i;
                        $i = 21;
                    }
                }
            $filename = $_FILES["file"]["tmp_name"];       
            $exif = exif_read_data($filename);
            if (!empty($exif['Orientation'])) {
                $imageResource = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
                switch ($exif['Orientation']) {
                    case 3:
                        $imagerotate = imagerotate($imageResource, 180, 0);
                        break;
                    case 6:
                        $imagerotate = imagerotate($imageResource, -90, 0);
                        break;
                    case 8:
                        $imagerotate = imagerotate($imageResource, 90, 0);
                        break;
                    default:
                        $imagerotate = $imageResource;
                }
                imagejpeg($imagerotate, PATH_ALPISSIME."webroot/images_ann/".$this->request->data['pronumber']."/imagerotatetest.jpg", 90);
                $filename = PATH_ALPISSIME."webroot/images_ann/".$this->request->data['pronumber']."/imagerotatetest.jpg";
            }        
            
           $sizes = getimagesize($filename);
           /* on verifie taille image */
            $largeur = $sizes[0] ;
            $hauteur = $sizes[1];
             if($largeur<700 && $hauteur<525){
                 $msg = "dimension";
                 $this->set("msg",$msg);
             }else{
            //    if($hauteur>$largeur){
            //        $msg = "vertical";
            //        $this->set("msg",$msg);
            //    }else{
                
                $vignette ="vignette-".$this->request->data['pronumber']."-".$num.".jpg";
                $vignetteP ="vignette-".$this->request->data['pronumber']."-".$num.".P.jpg";
                // $vignetteG="vignette-".$this->request->data['pronumber']."-".$num.".G.jpg";
    
                $this->loadModel('Annonces');
                // $annonce=$this->Annonces->get($this->request->data['pronumber'], ['contain' => ['Lieugeos','Villages']]);
                $annonce=$this->Annonces->find("all")->where(["Annonces.id"=>$this->request->data['pronumber']])->contain(['Lieugeos','Villages']);
                if($annonce = $annonce->first()){
                    $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
                    $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
                    $village_nom = str_replace(" – ", "-", $village_nom);
                    $village_nom = str_replace(" ", "-", $village_nom);
                    $vignetteG = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$this->request->data['pronumber']."-".$num."-Alpissime.jpg";
                }else{
                    $vignetteG = $this->request->data['pronumber']."-".$num."-Alpissime.jpg";
                }       
                
                
    
                $this->set("vignette",$this->request->data['pronumber']."/".$vignette);
                
                //print_r($destname.$vignette);
    
                $imagine = new Imagine();
                /********** IL FAUT METTRE destination marker ************/
                $watermark = $imagine->open("$prefixe/webroot/logoalpissimecertif.png");
                $bottomRight = new Point(5, 5);
                
                $image = $imagine->open($filename);
                if($hauteur>$largeur){
                    $image->resize(new Box(525, 700));   
                }else{
                    $image->resize(new Box(700, 525));   
                }                     
                $image->paste($watermark, $bottomRight);
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $image->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignetteG", array('jpeg_quality' => 75));
                
                $imageP = $imagine->open($filename);
                $imageP->resize(new Box(363, 272));
                $imageP->paste($watermark, $bottomRight);
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $imageP->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignetteP", array('jpeg_quality' => 75));
                
                $imagepetite = $imagine->open($filename);
                $imagepetite->resize(new Box(170, 120));
                $imagepetite->paste($watermark, $bottomRight);
                /********** IL FAUT METTRE : $destname.$vignette ************/
                $imagepetite->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignette", array('jpeg_quality' => 75));
                //print_r($image);
                //exit;
                
                
                $this->set("name",$vignette);
                $pieces = explode(".", $vignette);
                $ttre = $pieces[0];
                $colonne = $this->Photos->newEntity();
                $colonne->titre = $vignetteG;
                $colonne->annonce_id = $this->request->data['pronumber'];
                $colonne->numero = $num;
                if($this->Photos->save($colonne))  $idFile = $this->Photos->save($colonne)->id;
                  $this->Flash->success(__('Les modifications ont bien été enregistrées'),['clear'=> true]);
                $this->set("id",$idFile);            
                $msg = 'ok';
            //    }
              }
           } else {
              $msg = 'overload';
           }
    
          }else {
          $msg = 'error';
          }
          
        }else {
            $msg = 'error';
        }
        $this->set("msg",$msg);
        Cache::clear(false);
    }
    /**
     *
     **/
     public function uploadnumberone(){
       if(!empty($_FILES)){
           $filename = $_FILES["image-file"]["tmp_name"];
           $prefixe = $_SERVER['DOCUMENT_ROOT'];
           $vignette ="vignette-".$this->request->data['pronumber']."-1.jpg";
           $vignetteP ="vignette-".$this->request->data['pronumber']."-1.P.jpg";
        //    $vignetteG="vignette-".$this->request->data['pronumber']."-1.G.jpg";

            $this->loadModel('Annonces');
            // $annonce=$this->Annonces->get($this->request->data['pronumber'], ['contain' => ['Lieugeos','Villages']]);
            $annonce=$this->Annonces->find("all")->where(["Annonces.id"=>$this->request->data['pronumber']])->contain(['Lieugeos','Villages']);
            if($annonce = $annonce->first()){
                $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
                $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
                $village_nom = str_replace(" – ", "-", $village_nom);
                $village_nom = str_replace(" ", "-", $village_nom);
                $vignetteG = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$this->request->data['pronumber']."-".$num."-Alpissime.jpg";
            }else{
                $vignetteG = $this->request->data['pronumber']."-1-Alpissime.jpg";
            }   
            

           $destname = "$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/";
           if(!is_dir($destname))   @mkdir("$prefixe/webroot/images_ann/".$this->request->data['pronumber'], 0777, true);

           $this->set("vignette",$this->request->data['pronumber']."/".$vignette);
           
           $exif = exif_read_data($filename);
            if (!empty($exif['Orientation'])) {
                $imageResource = imagecreatefromjpeg($_FILES["image-file"]["tmp_name"]);
                switch ($exif['Orientation']) {
                    case 3:
                        $imagerotate = imagerotate($imageResource, 180, 0);
                        break;
                    case 6:
                        $imagerotate = imagerotate($imageResource, -90, 0);
                        break;
                    case 8:
                        $imagerotate = imagerotate($imageResource, 90, 0);
                        break;
                    default:
                        $imagerotate = $imageResource;
                }
                imagejpeg($imagerotate, PATH_ALPISSIME."webroot/images_ann/".$this->request->data['pronumber']."/imagerotatetest.jpg", 90);
                $filename = PATH_ALPISSIME."webroot/images_ann/".$this->request->data['pronumber']."/imagerotatetest.jpg";
            } 
            
            $imagine = new Imagine();
            $watermark = $imagine->open("$prefixe/webroot/logoalpissimecertif.png");
            $bottomRight = new Point(5, 5);

            $sizes = getimagesize($filename);
            /* on verifie taille image */
            $largeur = $sizes[0] ;
            $hauteur = $sizes[1];
            
            $image = $imagine->open($filename);            
            if($hauteur>$largeur){
                $image->resize(new Box(525, 700));   
            }else{
                $image->resize(new Box(700, 525));   
            }                
            $image->paste($watermark, $bottomRight);
            /********** IL FAUT METTRE : $destname.$vignette ************/
            $image->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignetteG", array('jpeg_quality' => 75));
            
            $imageP = $imagine->open($filename);
            $imageP->resize(new Box(363, 272));
            $imageP->paste($watermark, $bottomRight);
            /********** IL FAUT METTRE : $destname.$vignette ************/
            $imageP->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignetteP", array('jpeg_quality' => 75));
            
            $imagepetite = $imagine->open($filename);
            $imagepetite->resize(new Box(170, 120));
            $imagepetite->paste($watermark, $bottomRight);
            /********** IL FAUT METTRE : $destname.$vignette ************/
            $imagepetite->save("$prefixe/webroot/images_ann/".$this->request->data['pronumber']."/$vignette", array('jpeg_quality' => 75));
           
           $this->set("name",$vignette);
           $photoupdate = $this->Photos->find()->where(["Photos.annonce_id = ".$this->request->data['pronumber'], "Photos.numero=1"]);
           if(!$photoupdate->first()){
             $pieces = explode(".", $vignette);
             $ttre = $pieces[0];
             $colonne = $this->Photos->newEntity();
             $colonne->titre = $vignetteG;
             $colonne->annonce_id = $this->request->data['pronumber'];
             $colonne->numero = 1;
             $this->Photos->save($colonne);
           }
           $msg = 'ok';          
         }else {
           $msg = 'error';
         }
         $this->set("msg",$msg);
         Cache::clear(false);
     }
    /**
     * Upload method
     *
     * @param string|null $id Photo id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function upload()
    {
        if(!empty($this->request->data))
        {
            $filename = $this->request->data["File"]["tmp_name"];

            $prefixe = $_SERVER['DOCUMENT_ROOT'];

            $vignette ="vignette-".$this->request->data['annonce_id']."-".$this->request->data['numero'].".jpg";
            // $vignetteG="vignette-".$this->request->data['annonce_id']."-".$this->request->data['numero'].".G.jpg";

            $this->loadModel('Annonces');
            $annonce=$this->Annonces->get($this->request->data['pronumber'], ['contain' => ['Lieugeos','Villages']]);
            $natureAnnURL = array("STD"=>"studio","APP"=>"appartement","CHA"=>"chalet","DIV"=>"location","VIL"=>"villa","GIT"=>"gite");
            $village_nom = str_replace(" - ", "-", $annonce['village']["name"]);
            $village_nom = str_replace(" – ", "-", $village_nom);
            $village_nom = str_replace(" ", "-", $village_nom);
            $vignetteG = "location-".$natureAnnURL[$annonce['nature']]."-".$village_nom."-".$annonce->personnes_nb."-personnes-".$this->request->data['pronumber']."-".$this->request->data['numero']."-Alpissime.jpg";
            

            $destname = "$prefixe/webroot/images_ann/".$this->request->data['annonce_id']."/";
            if(!is_dir($destname))    @mkdir("$prefixe/webroot/images_ann/".$this->request->data['annonce_id'], 0777, true);

            $this->set("vignette",$this->request->data['annonce_id']."/".$vignette);
            list($width, $height) = getimagesize($filename);
            $source = imagecreatefromjpeg($filename);

            $thumb = imagecreatetruecolor(170,120);
            imagecopyresized($thumb, $source, 0, 0, 0, 0, 170, 120, $width, $height);
            $mini_left = imagecreatefrompng("$prefixe/webroot/logoalpissimecertif.png");

            imagejpeg($thumb,$destname.$vignette);
            $thumbG = imagecreatetruecolor(700, 525);
            imagecopyresized($thumbG, $source, 0, 0, 0, 0, 700, 525, $width, $height);

            $largeur_source = imagesx($mini_left);
            $hauteur_source = imagesy($mini_left);
            $destination_x = 700 - $largeur_source;
            $destination_y =  522 - $hauteur_source;
            $a_pos=array(array(5,5),array(585,5),array(5,5),array(585,5));
            $rand= rand(0,3);

            imagecopyresampled($thumbG,$mini_left,$a_pos[$rand][0],$a_pos[$rand][1],0,0,$largeur_source,$hauteur_source,$largeur_source,$hauteur_source);
            imagejpeg($thumbG,$destname.$vignetteG);

            $data = $this->Photos->find("all",["conditions"=>["Photos.annonce_id"=>$this->request->data['annonce_id'],"Photos.numero"=>$this->request->data['numero']]]);
            if(empty($data->first()))
            {
                $photo = $this->Photos->newEntity($this->request->data);
                $photo->titre = $vignetteG;
                $action="add";
            }
            else
            {
                $ph=$data->first();
                $photo = $this->Photos->get($ph->id, [
                    'contain' => []
                ]);
                $photo = $this->Photos->patchEntity($photo, $this->request->data);
                $photo->titre = $vignetteG;
                $action="update";
            }
            if ($this->Photos->save($photo)) {
                $res = $this->Photos->find("all",array(
                    "conditions"=>array(
                        "Photos.annonce_id"=>$this->request->data['annonce_id'],
                        "Photos.numero"=>$this->request->data['numero'])));
                $ph=$res->first();
                $this->set('id',$ph->id);
                $this->set('action',$action);
                $this->render('ok','ajax');
                return ;
            }
        }
    }


}
