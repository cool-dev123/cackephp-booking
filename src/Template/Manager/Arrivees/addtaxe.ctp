<div class="form-wrap col-sm-12 col-xs-12">
    <?php echo $this->Form->create(null,['url'=>'/manager/gestionnaires/addperiodestation','id'=>'frm','class'=> 'form-horizontal']); ?>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Du : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-12 col-md-8">
                <input type="text" name="du" class="form-control" id="du" autocomplete="off">
                <input type="hidden" class="full" id="id_taxe" value="0"/>
                <input type="hidden" class="full" id="type" value="add" >
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Au : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-12 col-md-8">
                <input type="text" name="au" class="form-control" id="au" autocomplete="off">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Nombre étoiles : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-12 col-md-8">
                <select id='nb_etoiles' name="nb_etoiles" class="form-control">
                        <?php for($i=0;$i<6;$i++):?>
                            <option  value="<?php echo $i?>"><?php echo $i ?></option>
                        <?php endfor;?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Département  : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-12 col-md-8">
                <?php echo $this->Form->input('region',['type'=>'select','class'=>'form-control validate[required]','label'=>false,'options'=>'']);?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Ville : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-8 col-sm-12 col-md-8">
                <?php echo $this->Form->input('ville',['type'=>'select','class'=>'form-control validate[required]','label'=>false,'options'=>'']);?>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label mb-10 col-sm-4 text-left font-16 txt-black">Taxe de séjour : <sup class='text-danger'>*</sup></label>
            <div class="col-lg-5 col-sm-8 col-md-5">
                <div id="before_taxe_error" class="input-group">
                    <input type="number" class="form-control" name="taxe" id="taxe">
                    <div class="input-group-addon" id="addonTaxe"><span style="font-weight: 900;">%</span></div>
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


<script>
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
                        icons: {
                        date: "fa fa-calendar",
                        up: "fa fa-arrow-up",
                        down: "fa fa-arrow-down"
                    },
                    });
                    
            $("#du").on('dp.change', function(e){
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
                });
        $( document ).ready(function() {
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
                }
            });
            
            $.ajax({
                type: "POST",
                dataType : 'json',
                async: false,
                url: "<?php echo $this->Url->build('/',true)?>utilisateurs/getarrayfrancevilles/",
                data: {departementid: 182},
                success:function(xml){
                data = xml.listepville;
                $('#ville').empty();
                for (var i = 0; i < data.length; i++) {
                    $('#ville').append('<option value=' + data[i].id + '>' + (data[i].name).toLowerCase() + '</option>');
                }
                }
            });
                $('#nb_etoiles').change(function(){
                    setIcon();
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