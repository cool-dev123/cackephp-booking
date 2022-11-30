<?php $this->start('cssTop'); ?>
    <style>
        .fileinput.input-group.fileinput-exists {
            overflow: hidden;
        }
        div.background-gris{
          background-color: #f2f2f2;
        }
        .zoom{
            transition: transform .5s;
        }
        .zoom:hover {
            transform: scale(3);
            margin-bottom: 100px;
        }
    </style>
<?php $this->end(); ?>

<!-- Summernote Plugin JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/dist/summernote.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/summernote/lang/summernote-fr-FR.js", array('block' => 'scriptBottom')); ?>
<!-- Summernote css -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/summernote/dist/summernote.css", array('block' => 'cssTop')); ?>

<div class="row heading-bg icantSelectIt">
    <div class="col-lg-12">
      <h5 class="txt-dark">Modifier Station</h5>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default card-view">
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                <div class="form-wrap col-sm-12 col-xs-12">
                        <?=$this->Form->create($Lieugeo,['type' => 'file','id'=>'station','class'=> 'form-horizontal','onsubmit'=>"return validateMyForm();"]);?>
                        <?php echo $this->Form->input('niveau',['type'=>'hidden','id'=>'niveau','value'=>3,'label'=>false]);  ?>
                        <?php if( (!empty($Lieugeo->invalid())) || (isset($Lieugeo->lit) && !empty($Lieugeo->lit[0]->invalid())) ): ?>
                          <div class="row">
                            <div class="col-sm-8">
                              <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Vérifier les données saisies.</p>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                          </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('name',['type'=>'text','id'=>'name','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Préposition: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('preposition_a',['type'=>'text','id'=>'preposition_a','label'=>false,'class'=>'form-control','placeholder'=>'à, au, aux ...', 'required']);  ?>
                                  </div>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                  <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Article: <sup class='text-danger'>*</sup></label>
                                  <div class="col-sm-12">
                                      <?php echo $this->Form->input('article_de',['type'=>'text','id'=>'article_de','label'=>false,'class'=>'form-control','placeholder'=>'du, de l\', des ...', 'required']);  ?>
                                  </div>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Nom à utiliser dans l'url: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('nom_url',['type'=>'text','id'=>'nom_url','label'=>false,'class'=>'form-control','placeholder'=>'nom-station', 'required']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Massif: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('massif_id',$massifs,['id'=>'massif_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                        <?= $this->Form->isFieldError('massif_id') ? $this->Form->error('massif_id') : '';?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Domaine: </label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->select('domaine_id',$domaines,['id'=>'domaine_id','label'=>false,'class'=>'select2 form-control']);  ?>
                                        <?= $this->Form->isFieldError('domaine_id') ? $this->Form->error('domaine_id') : '';?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ml-5">
                            <div class="row">
                                <label class="control-label mb-10 col-sm-2 col-lg-2 text-left font-16 txt-black">Position : <sup class='text-danger'>*</sup></label>
                            </div>
                            <div class="row mt-10">
                                <div class="col-sm-3 mt-60">
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Latitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('latitude',['type'=>'text','id'=>'lat','label'=>false,'class'=>'form-control','placeholder'=>"saisir latitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row mb-20">
                                        <label class="control-label col-sm-4 col-md-4 text-left font-16 txt-black">Longitude</label>
                                        <div class="col-sm-8 col-md-8">
                                            <?php echo $this->Form->input('longitude',['type'=>'text','id'=>'lng','label'=>false,'class'=>'form-control','placeholder'=>"saisir longitude"]);  ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button type="button" id="search_button" class="btn btn-warning btn-anim"><i class="fa fa-search"></i><span class="btn-text">Chercher</span></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <input id="searchmap" class="form-control" type="text" placeholder="Chercher une adresse"  style="width: 50%; margin: 10px 0px 0px 10px; height: 38px !important;">

                                    <div id="map-canvas" style="width: 100%; height: 400px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Url Blog:</label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('urlBlog',['type'=>'text','id'=>'urlBlog','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                              <label class="control-label pl-0 mb-10 mt-10 col-sm-12 text-left font-16 txt-black">À afficher: <sup class='text-danger'>*</sup></label>
                              <input id="Acontacter_switch" type="checkbox" data-off-text="NON" data-off-color="danger" data-on-text="OUI" data-on-color="success" class="bs-switch">
                              <input id="radioOui" name="etat" class="hidden" type="radio" value="1" <?=$Lieugeo->etat=='1'?'checked':''?>>
                              <input id="radioNon" name="etat" class="hidden" type="radio" value="0" <?=$Lieugeo->etat=='0'?'checked':''?>>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ALT BAS: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('ALT_BAS',['type'=>'text','id'=>'ALT_BAS','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ALT HAUT: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('ALT_HAUT',['type'=>'text','id'=>'ALT_HAUT','label'=>false,'class'=>'form-control']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ID Correspondance Catégorie Blog: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('input_blog',['type'=>'text','id'=>'input_blog','label'=>false,'class'=>'form-control', 'required']);  ?>
                                    </div>
                                </div>                                
                            </div>
                            <div class="col-sm-6">
                               <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">ID Correspondance Catégorie Blog (Anglais): <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php echo $this->Form->input('input_blog_EN',['type'=>'text','id'=>'input_blog_EN','label'=>false,'class'=>'form-control', 'required']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Correspondance Boutique (Anglais): <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                        <?php //echo $this->Form->input('input_boutique_EN',['type'=>'text','id'=>'input_boutique_EN','label'=>false,'class'=>'form-control','placeholder'=>'Exp : arc_1600_en', 'required']);  ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Correspondance Boutique: <sup class='text-danger'>*</sup></label>
                                    <div class="col-sm-12">
                                    <?php //echo $this->Form->input('input_boutique',['type'=>'text','id'=>'input_boutique','label'=>false,'class'=>'form-control','placeholder'=>'Exp : arc_1600_fr', 'required']);  ?>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Description:</label>
                            <div class="col-sm-12">
                                <?= $this->Form->input("descreption",[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->descreption.'</textarea >'],
                                        'type'=>'textarea','rows'=>'5',]);
                                ?>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Sous Description:</label>
                            <div class="col-sm-12">
                                <?= $this->Form->input("sous_description",[
                                        'label'=>false,
                                        'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->sous_description.'</textarea >'],
                                        'type'=>'textarea','rows'=>'5',]);
                                ?>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6">
                              <label class="control-label mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Accessibilité:</label>
                              <div class="col-sm-12">
                                  <?= $this->Form->input("description_acc",[
                                          'label'=>false,
                                          'templates' => ['inputContainer' => "{{content}}" , 'textarea' => '<textarea class="input text" type="{{type}}" name="{{name}}" {{attrs}} >'.$Lieugeo->description_acc.'</textarea >'],
                                          'type'=>'textarea','rows'=>'5',]);
                                  ?>
                              </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image logo (png) <?php if($Lieugeo->image == "") echo "<sup class='text-danger'>*</sup>"; ?> :</label>
                            <div class="mb-10 col-sm-12 text-left font-12"><span>L'image sera enregistrée avec la taille (350 x 150)</span></div>
                            <div class="col-sm-6">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php 
                                      if($Lieugeo->image != "") echo $this->Form->file('image',['accept'=>'image/png']);
                                      else echo $this->Form->file('image',['accept'=>'image/png', 'required']);
                                    ?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image') ? $this->Form->error('image') : '';?>
                            </div>
                            <?php if($Lieugeo->image != ""){ ?>
                            <div style="text-align: center" class="col-sm-6">
                                <h5>Ancien Logo</h5>
                                <img class="zoom" height="100" width="100" src="<?= $this->Url->build('/',true)?>images/partners/<?= $Lieugeo->image.".png";?>">
                            </div>
                            <?php } ?>
                        </div> 

                        <div class="form-group row">
                          <div class="col-sm-6">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image header été <?php if($Lieugeo->image_header_ete == "") echo "<sup class='text-danger'>*</sup>"; ?> :</label>
                            <div class="mb-10 col-sm-12 text-left font-12"></div>
                            <div class="col-sm-12">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php 
                                      if($Lieugeo->image_header_ete != "") echo $this->Form->file('image_header_ete',['accept'=>'image/*']);
                                      else echo $this->Form->file('image_header_ete',['accept'=>'image/*', 'required']);
                                    ?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image_header_ete') ? $this->Form->error('image_header_ete') : '';?>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <label class="mb-10 mt-10 col-sm-12 text-left font-16 txt-black">Image header hiver <?php if($Lieugeo->image_header_hiver == "") echo "<sup class='text-danger'>*</sup>"; ?> :</label>
                            <div class="mb-10 col-sm-12 text-left font-12"></div>
                            <div class="col-sm-12">
                                <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                    <div class="form-control" data-trigger="fileinput"> <i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
                                    <span class="input-group-addon fileupload btn btn-info btn-anim btn-file"><i class="fa fa-upload"></i> <span class="fileinput-new btn-text">Choisir un fichier</span> <span class="fileinput-exists btn-text">Modifier</span>
                                    <input type="hidden"><?php 
                                      if($Lieugeo->image_header_hiver != "") echo $this->Form->file('image_header_hiver',['accept'=>'image/*']);
                                      else echo $this->Form->file('image_header_hiver',['accept'=>'image/*', 'required']);
                                    ?>
                                    </span> <a href="#" class="input-group-addon btn btn-danger btn-anim fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash"></i><span class="btn-text"> Supprimer</span></a>
                                </div>
                                <?= $this->Form->isFieldError('image_header_hiver') ? $this->Form->error('image_header_hiver') : '';?>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-6">
                            <?php if($Lieugeo->image_header_ete != ""){ ?>
                            <h5>Ancienne Image header été</h5>
                            <img height="200" width="100%" src="<?= $this->Url->build('/',true)?>images/header_station/<?= $Lieugeo->image_header_ete;?>">
                            <?php } ?>
                          </div>
                          <div class="col-sm-6">
                            <?php if($Lieugeo->image_header_hiver != ""){ ?>
                            <h5>Ancienne Image header hiver</h5>
                            <img height="200" width="100%" src="<?= $this->Url->build('/',true)?>images/header_station/<?= $Lieugeo->image_header_hiver;?>">
                            <?php } ?>
                          </div>
                        </div>

                        <div class="row">
                          <div class="panel-group accordion-struct pl-10 pr-10" id="accordion_1" role="tablist" aria-multiselectable="true">
                            <?php foreach($lits as $lit): ?>
                              <div class="panel panel-default mb-5">
                                <div class="panel-heading" role="tab" id="heading_<?=$lit->anne?>">
                                  <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapse_<?=$lit->anne?>" aria-expanded="false"><i class="fa fa-plus-square"></i> Lits <?=$lit->anne?></a>
                                </div>
                                <div id="collapse_<?=$lit->anne?>" class="panel-collapse collapse" role="tabpanel" aria-expanded="false" style="height: 0px;">
                                  <div class="panel-body pa-15">
                                  <button type="button" data-id="<?=$lit->id?>" class="btn btn-warning btn-xs edit_lit">Modifier <i class="fa fa-pencil"></i></button>
                                  <button type="button" data-id="<?=$lit->id?>" data-anne="<?=$lit->anne?>" class="btn btn-danger btn-xs delete_lit">Supprimer <i class="fa fa-trash"></i></button>
                                  <div class="table-wrap">
                                    <div class="table-responsive">
                                      <table class="table mb-0" id="table-Lit<?=$lit->id?>">
                                        <thead>
                                          <tr>
                                            <th>Année</th>
                                            <th>Meublés Classés</th>
                                            <th>RT classés & non</th>
                                            <th>Hotels</th>
                                            <th>Lits Camping</th>
                                            <th>Lits Divers</th>
                                            <th>Lits Refuges</th>
                                            <th>Clé vacances + gites</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td id="td-lit<?=$lit->id?>anne"><?=$lit->anne?></td>
                                            <td id="td-lit<?=$lit->id?>meublesClasses"><?=$lit->meublesClasses?></td>
                                            <td id="td-lit<?=$lit->id?>rtClassesNon"><?=$lit->rtClassesNon?></td>
                                            <td id="td-lit<?=$lit->id?>hotels"><?=$lit->hotels?></td>
                                            <td id="td-lit<?=$lit->id?>litsCamping"><?=$lit->litsCamping?></td>
                                            <td id="td-lit<?=$lit->id?>litsDivers"><?=$lit->litsDivers?></td>
                                            <td id="td-lit<?=$lit->id?>litsRefuges"><?=$lit->litsRefuges?></td>
                                            <td id="td-lit<?=$lit->id?>clesVacancesGites"><?=$lit->clesVacancesGites?></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  </div>
                                </div>
                              </div>
                            <?php endforeach; ?>
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-12">
                            <div class="panel background-gris panel-default card-view">
                              <div class="panel-heading">
                                <div class="pull-left">
                                  <h6 class="panel-title txt-dark">Informations Lits :</h6>
                                </div>
                                <div class="clearfix"></div>
                              </div>
                              <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Année: <i class="fa fa-question-circle-o" data-toggle="tooltip" data-placement="top" title="Choisir une année pour ajouter un lit"></i></label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.anne',['type'=>'number','id'=>'anne','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Meublés Classés:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.meublesClasses',['type'=>'number','id'=>'meublesClasses','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">RT classés & non:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.rtClassesNon',['type'=>'number','id'=>'rtClassesNon','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Hotels:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.hotels',['type'=>'number','id'=>'hotels','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Lits Camping:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.litsCamping',['type'=>'number','id'=>'litsCamping','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Lits Divers:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.litsDivers',['type'=>'number','id'=>'litsDivers','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Lits Refuges:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.litsRefuges',['type'=>'number','id'=>'litsRefuges','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                    <div class="form-group">
                                      <label class="col-sm-3 text-left font-16 txt-black mt-10">Clé vacances + gites:</label>
                                      <div class="col-sm-9 col-md-4 col-lg-3">
                                        <?php echo $this->Form->input('lit.0.clesVacancesGites',['type'=>'number','id'=>'clesVacancesGites','label'=>false,'class'=>'form-control']);  ?>                     
                                      </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group mb-0">
                            <div class="row mb-10">
                                <div class="col-sm-12 ml-30">
                                    <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <a href="<?php echo $this->Url->build('/',true);?>manager/stations/index" class="btn btn-default">Retour </a>
                                </div>
                                <div class="col-sm-offset-2 col-sm-3">
                                    <button type="submit" class="btn btn-success btn-anim"><i class="fa fa-save"></i><span class="btn-text">Enregistrer</span></button>
                                </div>
                            </div>
                        </div>
                        <?=$this->Form->end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.modal -->
<div id="modal-editLit" class="modal fade" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h5 id="modal-title" class="modal-title">Modifier Lits <span id="litId"></span></h5>
            </div>
            <div id="modal-body" class="modal-body">
              <div id="lits-Error" class="row ml-10 mr-10" style="display: none;">
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <i class="zmdi zmdi-block pr-15 pull-left"></i><p class="pull-left">Vérifier les données saisies.</p>
                  <div class="clearfix"></div>
                </div>
              </div>
                <form id="editLit-form">
                  <?=$this->Form->hidden('id',['id'=>'litId-modal'])?>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Meublés Classés:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('meublesClasses',['type'=>'number','id'=>'meublesClasses-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">RT classés & non:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('rtClassesNon',['type'=>'number','id'=>'rtClassesNon-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Hotels:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('hotels',['type'=>'number','id'=>'hotels-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Lits Camping:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('litsCamping',['type'=>'number','id'=>'litsCamping-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Lits Divers:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('litsDivers',['type'=>'number','id'=>'litsDivers-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Lits Refuges:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('litsRefuges',['type'=>'number','id'=>'litsRefuges-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-12 text-left font-16 txt-black mt-10">Clé vacances + gites:</label>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <?= $this->Form->input('clesVacancesGites',['type'=>'number','id'=>'clesVacancesGites-modal','label'=>false,'class'=>'form-control']);  ?>                     
                    </div>
                  </div>
                </form>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                    <button id="saveLit" type="button" class="btn btn-danger">Enregistrer</button>
            </div>
        </div>
    </div>
</div>

<?php $this->Html->script("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js", array('block' => 'scriptBottom')); ?>
<?php $this->Html->script("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js", array('block' => 'scriptBottom')); ?>
<!-- Bootstrap Select JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/js/intlTelInput.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/select2/dist/js/select2.full.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->script("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.min.js", array('block' => 'scriptBottom')); ?>

<!-- Google map -->
<?php $this->Html->script("https://maps.googleapis.com/maps/api/js?key=AIzaSyDmcMahz5aDoDozkosBjzy5e469hgAVzPs&libraries=places", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css", array('block' => 'cssTop')); ?>
<!-- Jasny-bootstrap CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/select2/dist/css/select2.min.css", array('block' => 'cssTop')); ?>

<!-- Bootstrap Switches CSS -->
<?php $this->Html->css("/manager-arr/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css", array('block' => 'cssTop')); ?>
<!-- Bootstrap Switch JavaScript -->
<?php $this->Html->script("/manager-arr/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js", array('block' => 'scriptBottom')); ?>

<?php $this->Html->css("/css/intlTelInput.css", array('block' => 'cssTop')); ?>

<?php $this->Html->css("/manager-arr/vendors/bower_components/sweetalert/dist/sweetalert.css", array('block' => 'cssTop')); ?>

<?php $this->Html->scriptStart(array('block' => 'scriptBottom')); ?>
//<script>
$(".select2").select2();

$('#descreption').summernote({
    height: 200,
    lang:"fr-FR",
    fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontname',['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['picture',['picture']],
        ['link',['linkDialogShow', 'unlink']],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']],
        ['undo',['undo']],
        ['redo',['redo']],
    ],
    callbacks: {
        onChange: function (contents, $editable) {
            // Note that at this point, the value of the `textarea` is not the same as the one
            // you entered into the summernote editor, so you have to set it yourself to make
            // the validation consistent and in sync with the value.
            $('#descreption').val($('#descreption').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#descreption'));
        }
    }
}); 

$('#sous-description').summernote({
    height: 200,
    lang:"fr-FR",
    fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontname',['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['picture',['picture']],
        ['link',['linkDialogShow', 'unlink']],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']],
        ['undo',['undo']],
        ['redo',['redo']],
    ],
    callbacks: {
        onChange: function (contents, $editable) {
            // Note that at this point, the value of the `textarea` is not the same as the one
            // you entered into the summernote editor, so you have to set it yourself to make
            // the validation consistent and in sync with the value.
            $('#sous-description').val($('#sous-description').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#sous-description'));
        }
    }
}); 

$('#description-acc').summernote({
    height: 200,
    lang:"fr-FR",
    fontNames: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    fontNamesIgnoreCheck: ["Times New Roman","Helvetica", "sans-serif", "Arial", "Arial Black", "Comic Sans MS", "Courier New"],
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontname',['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['picture',['picture']],
        ['link',['linkDialogShow', 'unlink']],
        ['fullscreen',['fullscreen']],
        ['codeview',['codeview']],
        ['undo',['undo']],
        ['redo',['redo']],
    ],
    callbacks: {
        onChange: function (contents, $editable) {
            // Note that at this point, the value of the `textarea` is not the same as the one
            // you entered into the summernote editor, so you have to set it yourself to make
            // the validation consistent and in sync with the value.
            $('#description-acc').val($('#description-acc').summernote('isEmpty') ? "" : contents);

            // You should re-validate your element after change, because the plugin will have
            // no way to know that the value of your `textarea` has been changed if the change
            // was done programmatically.
            summernoteValidator.element($('#description-acc'));
        }
    }
}); 

<?php // if($Lieugeo->description_acc != ''){ ?>
  // $('#description-acc').summernote('disable');
<?php // } ?>

$('#Acontacter_switch').bootstrapSwitch('state', <?=$Lieugeo->etat=='1'?'true':'false'?>);
$('#Acontacter_switch').on('switchChange.bootstrapSwitch', function (e, state) {
    if(state)
        $('#radioOui').prop("checked", true);
    else
        $('#radioNon').prop("checked", true);
});

var validport =false;
var validtel =true;
var validtelPro = true;
function validateMyForm(){
    $('#tel').val(telInputrestel.intlTelInput("getNumber"))
    $('#portable').val(mobileInputport.intlTelInput("getNumber"))
    $('#tel_pro').val(telInputrestelPro.intlTelInput("getNumber"))
    if (mobileInputport.intlTelInput("isValidNumber")==false || validtel==false || validtelPro==false) {
        if(mobileInputport.intlTelInput("isValidNumber")==false)
        {
            validMsgportable.addClass("hide");
            errorMsgportable.removeClass("hide");
        }
        if(validtel==false)
        {
            validMsgtel.addClass("hide");
            errorMsgtel.removeClass("hide");
        }
        if(validtelPro==false)
        {
            validMsgtelPro.addClass("hide");
            errorMsgtelPro.removeClass("hide");
        }
        return false
    }
    return true
}
errorMsgportable = $("#error-msg"),
validMsgportable = $("#valid-msg");
var mobileInputport = $("#portable");
mobileInputport.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset1 = function() {
                errorMsgportable.addClass("hide");
                validMsgportable.addClass("hide");
            };
            mobileInputport.blur(function() {
            reset1();
            if ($.trim(mobileInputport.val())) {
            if (mobileInputport.intlTelInput("isValidNumber")) {
                validMsgportable.removeClass("hide");
                validport = true;
            } else {
                validport = false;
                errorMsgportable.removeClass("hide");
            }
            }
        });
errorMsgtel = $("#error-msgTel"),
validMsgtel = $("#valid-msgTel");
var telInputrestel = $("#tel");
telInputrestel.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset2 = function() {
                errorMsgtel.addClass("hide");
                validMsgtel.addClass("hide");
            };
            telInputrestel.blur(function() {
            reset2();
            if ($.trim(telInputrestel.val())) {
            if (telInputrestel.intlTelInput("isValidNumber")) {
                validMsgtel.removeClass("hide");
                validtel = true;
            } else {
                validtel = false;
                errorMsgtel.removeClass("hide");
            }
            }
        });
errorMsgtelPro = $("#error-msgTelPro"),
validMsgtelPro = $("#valid-msgTelPro");
var telInputrestelPro = $("#tel_pro");
telInputrestelPro.intlTelInput({
            utilsScript: '<?php echo $this->Url->build('/',true) ?>js/utils.js',
            initialCountry: 'fr',
            autoPlaceholder: true
            });
            var reset3 = function() {
                errorMsgtelPro.addClass("hide");
                validMsgtelPro.addClass("hide");
            };
            telInputrestelPro.blur(function() {
            reset3();
            if ($.trim(telInputrestelPro.val())) {
            if (telInputrestelPro.intlTelInput("isValidNumber")) {
                validMsgtelPro.removeClass("hide");
                validtelPro = true;
            } else {
                validtelPro = false;
                errorMsgtelPro.removeClass("hide");
            }
            }
        });
//payschange(); getDomaines();
$("#massif_id").change(function() {
    $.ajax({
        type: "GET",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/massif/getDomaines/"+$(this).val(),
        success:function(data){
          $('#domaine_id').empty();
          $('#domaine_id').append('<option value= >Pas de domaine</option>');
          for (var i = 0; i < data.length; i++) {
              $('#domaine_id').append('<option value=' + data[i].id + '>' + (data[i].nom).toLowerCase() + '</option>');
          }
        }
    });
});

$(".edit_lit").click(function() {
  $('body').loadingModal({
          position: 'auto',
          text: '',
          color: '#fff',
          opacity: '0.7',
          backgroundColor: 'rgb(0,0,0)',
          animation: 'doubleBounce'
  });
  $('#editLit-form').get(0).reset();
  var idLit=$(this).attr('data-id');
  $.ajax({
        type: "GET",
        dataType : 'json',
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/stations/getLit/"+idLit,
        success:function(data){
          $('#litId').html(data.anne);
          $('#litId-modal').val(data.id);
          $('#meublesClasses-modal').val(data.meublesClasses);
          $('#rtClassesNon-modal').val(data.rtClassesNon);
          $('#hotels-modal').val(data.hotels);
          $('#litsCamping-modal').val(data.litsCamping);
          $('#litsDivers-modal').val(data.litsDivers);
          $('#litsRefuges-modal').val(data.litsRefuges);
          $('#clesVacancesGites-modal').val(data.clesVacancesGites);
          $('#modal-editLit').modal('show');
          $('body').loadingModal('destroy');
        },error:function(){
          $('body').loadingModal('destroy');
          $.toast({
              heading: "Anomalie au moment de chargement du lit",
              text: '',
              position: 'bottom-right',
              loaderBg:'#fec107',
              icon: 'error',
              hideAfter: 7000
          });
          $('#modal-editLit').modal('hide');
        }
    });
})

$('.delete_lit').click(function(){
  var id = $(this).attr("data-id");
  var anne = $(this).attr("data-anne");
        swal({
            title: "Êtes-vous sûr de vouloir supprimer Lits "+anne+"?",   
            text: "",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#e6b034",   
            confirmButtonText: "OK",
            cancelButtonText: "ANNULER",  
            closeOnConfirm: true 
            }, function(){
            $('body').loadingModal({
                position: 'auto',
                text: 'Suppression en cours',
                color: '#fff',
                opacity: '0.7',
                backgroundColor: 'rgb(0,0,0)',
                animation: 'doubleBounce'
                });
            $.ajax({
            type: "delete",
            url: "<?php echo $this->Url->build('/',true)?>/manager/stations/deletelit/"+id,

            success:function(xml){
                $('body').loadingModal('destroy');
                swal("", "Vous venez de supprimer Lits "+anne, "success");
                $('#heading_'+anne).remove()
                $('#collapse_'+anne).remove()
                },
                error: function(){
                    $('body').loadingModal('destroy');
                    $.toast().reset('all');
                        $("body").removeAttr('class');
                        $.toast({
                            heading: 'Erreur',
                            text: '',
                            position: 'bottom-right',
                            loaderBg:'#fec107',
                            icon: 'error',
                            hideAfter: 4000
                        });
                }
            }); 
        });
})

function arrayToData(array)
{
  json={}
  array.forEach(function(element) {
    json[element.name]=element.value
  })
  return json
}

$('#saveLit').click(function() {
  $('body').loadingModal({
          position: 'auto',
          text: '',
          color: '#fff',
          opacity: '0.7',
          backgroundColor: 'rgb(0,0,0)',
          animation: 'doubleBounce'
  });
  arrayData=$('#editLit-form').serializeArray()
  $.ajax({
        type: "POST",
        dataType : 'json',
        data : arrayToData(arrayData),
        async: false,
        url: "<?php echo $this->Url->build('/',true)?>manager/stations/updateLit",
        success:function(data){
          console.log(data);
          if(data.res=='error')
          {
            $('#lits-Error').show();
            $('body').loadingModal('destroy')
          }else{
            $('#lits-Error').hide();
            $('#td-lit'+data.id+'anne').html(data.anne)
            $('#td-lit'+data.id+'clesVacancesGites').html(data.clesVacancesGites)
            $('#td-lit'+data.id+'hotels').html(data.hotels)
            $('#td-lit'+data.id+'litsCamping').html(data.litsCamping)
            $('#td-lit'+data.id+'litsDivers').html(data.litsDivers)
            $('#td-lit'+data.id+'litsRefuges').html(data.litsRefuges)
            $('#td-lit'+data.id+'meublesClasses').html(data.meublesClasses)
            $('#td-lit'+data.id+'rtClassesNon').html(data.rtClassesNon)
            $('body').loadingModal('destroy')
            $('#modal-editLit').modal('hide')
            $.toast().reset('all');
            $("body").removeAttr('class');
            $.toast({
                heading: 'Modifications effectuées avec succes',
                text: '',
                position: 'bottom-right',
                loaderBg:'#fec107',
                icon: 'success',
                hideAfter: 7000
            })
          }
        },
        error:function(data) {
          $.toast({
            heading: "Anomalie au moment de la modification",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
        }
  })
})

<?php if(!empty($confirm_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: 'Vous avez modifier Une Station',
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'success',
            hideAfter: 7000
        });
    <?php endif;?>
    <?php if(!empty($error_res)): ?>
        $.toast().reset('all');
        $("body").removeAttr('class');
        $.toast({
            heading: "Anomalie au moment de l'enregistrement du Station",
            text: '',
            position: 'bottom-right',
            loaderBg:'#fec107',
            icon: 'error',
            hideAfter: 7000
        });
    <?php endif;?>

    //google map
    var map = new google.maps.Map(document.getElementById('map-canvas'),{
        disableDoubleClickZoom: true,
        styles:[
    {
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "elementType": "labels.icon",
      "stylers": [
        {
          "visibility": "off"
        }
      ]
    },
    {
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "elementType": "labels.text.stroke",
      "stylers": [
        {
          "color": "#f5f5f5"
        }
      ]
    },
    {
      "featureType": "administrative.land_parcel",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#bdbdbd"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "poi",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "poi.park",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "road",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#ffffff"
        }
      ]
    },
    {
      "featureType": "road.arterial",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#757575"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#dadada"
        }
      ]
    },
    {
      "featureType": "road.highway",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#616161"
        }
      ]
    },
    {
      "featureType": "road.local",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    },
    {
      "featureType": "transit.line",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#e5e5e5"
        }
      ]
    },
    {
      "featureType": "transit.station",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#eeeeee"
        }
      ]
    },
    {
      "featureType": "water",
      "stylers": [
        {
          "color": "#3cacff"
        },
        {
          "visibility": "on"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "geometry",
      "stylers": [
        {
          "color": "#c9c9c9"
        }
      ]
    },
    {
      "featureType": "water",
      "elementType": "labels.text.fill",
      "stylers": [
        {
          "color": "#9e9e9e"
        }
      ]
    }
  ],
            center :{
              lat: <?=$Lieugeo->latitude?$Lieugeo->latitude:46.734255?>,
              lng: <?=$Lieugeo->longitude?$Lieugeo->longitude:2.418815?>
            },
            zoom:10,
        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('searchmap'));

        var input = document.getElementById('searchmap');
        
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);



        var marker = new google.maps.Marker({
            position: {
                lat: <?=$Lieugeo->latitude?$Lieugeo->latitude:46.734255?>,
                lng: <?=$Lieugeo->longitude?$Lieugeo->longitude:2.418815?>
            },
            map :map,
            draggable: true
        });

        google.maps.event.addListener(searchBox,'places_changed',function () {
            var places = searchBox.getPlaces();
            var bounds = new google.maps.LatLngBounds();
            var i,place;

            for(i=0;place=places[i];i++){
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);
            }

            map.fitBounds(bounds);
            map.setZoom(15);
        });
        function findcords() {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();
            //var country,region;
            //$.get("http://maps.googleapis.com/maps/api/geocode/json?latlng="+lat+","+lng+"&sensor=false",function (data) {
            //    var resultat=data['results'][0];
             //   resultat['address_components'].forEach(function(comp) {
             //       if (comp['types']['0']=='country') country = comp['long_name'];
             //       if (typeof comp['types']['0'] != "undefined" && comp['types']['0']=='locality') region = comp['long_name'];
             //   });
             //   $('#lat').val(lat);     $('#lng').val(lng);
            //    $('#country').val(country);
            //    $('#adress').val(resultat['formatted_address']);
            //    $('#region').val(region);
                //console.log(resultat['formatted_address'],"country = "+country,"region = "+region);
            //});
            $('#lat').val(lat);     $('#lng').val(lng);
        };
        google.maps.event.addListener(map,'idle',function () {
            findcords();
        });
        
        google.maps.event.addListener(map, 'dblclick', function(e) {
        var positionDoubleclick = e.latLng;
        marker.setPosition(positionDoubleclick);
        findcords();
        });

        google.maps.event.addListener(marker,'dragend',function () {
            findcords();
        });
        
        $('#search_button').click(function(){
            var latlng = new google.maps.LatLng($('#lat').val(), $('#lng').val());
            marker.setPosition(latlng);
            map.setCenter(latlng);
        }); 
    //end google map
<?php $this->Html->scriptEnd(); ?>