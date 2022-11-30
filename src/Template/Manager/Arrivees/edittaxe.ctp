<div class="form-wrap col-sm-12 col-xs-12">
    <form id="frm" class="form-horizontal">
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Du : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-10 col-md-8">
                <input type="text" name="du" class="form-control" id="du" value='<?php echo $a_taxe->du->i18nFormat('dd-MM-yyyy') ?>' autocomplete="off">
                <input type="hidden" class="full" id="id_taxe" value="<?php echo $a_taxe->id?>"/>
                <input type="hidden" class="full" id="type" value="modifier">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Au : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-10 col-md-8">
                <input type="text" name="au" class="form-control" id="au" value='<?php echo $a_taxe->au->i18nFormat('dd-MM-yyyy') ?>' autocomplete="off">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Nombre étoiles : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-10 col-md-8">
                <select name="nb_etoiles" id='nb_etoiles' class="form-control">
                        <?php for($i=0;$i<6;$i++):?>
                            <option  <?php if($a_taxe->nb_etoile==$i) echo "SELECTED"?> value="<?php echo $i?>"><?php echo $i ?></option>
                        <?php endfor;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Département : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-10 col-md-8">
                <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control validate[required]','label'=>false,'options'=>'']);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Ville : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-10 col-md-8">
                <?php echo $this->Form->input('ville',['type'=>'select','class'=>'form-control validate[required]','label'=>false,'options'=>'']);?>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Taxe de séjour : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-5 col-sm-8 col-md-5">
                <div id="before_taxe_error" class="input-group">
                    <input type="number" class="form-control" name="taxe" id="taxe" value='<?php echo $a_taxe->valeur?>'>
                    <div class="input-group-addon" id="addonTaxe"></div>
                </div>
            </div>
        </div>
        <div class="row mb-10 mr-0 pr-0">
                <div class="col-sm-12">
                    <p class="control-label text-left mb-10 text-danger">(*) : champs obligatoires</p>
                </div>
        </div>
    </form>
</div>


<script type="text/javascript">
            $("#du" ).datetimepicker({
                useCurrent: false,
                format: 'DD-MM-YYYY',
                icons: {
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
                },
            });
            $("#au" ).datetimepicker({
                useCurrent: false,
                format: 'DD-MM-YYYY',
                minDate: moment('<?=$a_taxe->du->i18nFormat('dd-MM-yyyy')?>', "DD-MM-YYYY"),
                viewDate: moment('<?=$a_taxe->du->i18nFormat('dd-MM-yyyy')?>', "DD-MM-YYYY"),
                icons: {
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
                },
            });
                    
            $("#du").on('dp.change', function(e){
                if($("#du").val()!=""){
                    $('#au').data("DateTimePicker").destroy();

                        $('#au').datetimepicker({
                            useCurrent: false,
                            format: 'DD-MM-YYYY',
                            minDate: e.date.format("YYYY/MM/DD"),
                            icons: {
                            date: "fa fa-calendar",
                            up: "fa fa-arrow-up",
                            down: "fa fa-arrow-down"
                            },
                        });
                }
            });
            $('body').loadingModal('destroy');
            
     $( document ).ready(function() {
                $('#nb_etoiles').change(function(){
                    setIcon();
                });

                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    async: false,
                    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayregionfrance/",
                    success:function(xml){
                        data = xml.listefrregions;
                        $('#region').empty();
                        for (var i = 0; i < data.length; i++) {
                            $('#region').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                        }
                        $('#region').val(<?php echo $a_ville->departement_id ?>);
                    }
                });

                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    async: false,
                    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                    data: {departementid: <?php echo $a_ville->departement_id ?>},
                    success:function(xml){
                        data = xml.listepville;
                        $('#ville').empty();
                        for (var i = 0; i < data.length; i++) {
                            $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                        }
                        $('#ville').val(<?php echo $a_ville->id ?>);
                    }
                });

            });

            $("#region").change(function() {  
                $.ajax({
                    type: "POST",
                    dataType : 'json',
                    async: false,
                    url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                    data: {departementid: $(this).val()},
                    success:function(xml){
                    data = xml.listepville;
                    $('#ville').empty();
                    for (var i = 0; i < data.length; i++) {
                        $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                    }
                    }
                });
            });

            function setIcon(){
                var select=$('#nb_etoiles');
                if(select.val()==0){
                        $('#addonTaxe').html('<span style="font-weight: 900;">%</span>');
                    }else{
                        $('#addonTaxe').html('<i class="fa fa-eur"></i>');
                    }
            }
            setIcon();

</script>