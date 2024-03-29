

<!-- daterange picker -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/datepicker/datepicker3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= base_url() ?>public/plugins/select2/select2.min.css">

  <!--<link rel="stylesheet" href="<?= base_url() ?>public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">//-->
  
  <section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-body with-border">
        <div class="col-md-6">
          <h4><i class="fa fa-plus"></i> &nbsp; Nova Audiência</h4>
        </div>
        <div class="col-md-6 text-right">
          <a href="<?= base_url('admin/audiencia'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Voltar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alerta!</h4>
                  <?= validation_errors();?>
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
           
            <?php echo form_open(base_url('admin/audiencia/add'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <label for="codigo" class="col-sm-2 control-label">Código</label>

                <div class="col-sm-9">
                  <input readonly value="<?= $codigo ?>" type="text" name="codigo" class="form-control" id="codigo" placeholder="">
                </div>
              </div>

              <div class="form-group">
                
                <label for="data" class="col-sm-2 control-label">Data</label>
                <div class="col-lg-4">
                  <div class="input-group date ">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input value="<?= set_value('data'); ?>" type="text" name="data" class="form-control pull-right" id="datepicker">
                    <!-- /input-group -->
                  </div>
                </div>
                <!-- /.col-lg-6 -->
                <label for="hora" class="col-sm-2 control-label">Hora</label>
                <div class="col-lg-3">
                  <div class="input-group">
                  <input value="<?= set_value('hora'); ?>"  type="text" name="hora" class="form-control" id="hora" placeholder="">
                  </div>
                  <!-- /input-group -->
                </div>
              </div>

              <div class="form-group">
                <label for="codigo_comarca" class="col-sm-2 control-label">Comarca</label>
                <div class="col-sm-9">
                <select onchange="BuscaAdvogados(this.value)" name="codigo_comarca" class="form-control select2" id="codigo_comarca" data-placeholder="Selecione" style="width: 100%;">
                    <?php foreach($comarcas as $role): ?>
                      <option value="<?= $role['codigo']; ?>"><?= $role['estado']; ?> - <?= $role['comarca']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="banco" class="col-sm-2 control-label">Advogado</label>
                <div class="col-sm-9">
                <select name="codigo_advogado" class="form-control select2" id="codigo_advogado" data-placeholder="Selecione" style="width: 100%;">
                    <option value="">Selecione a Comarca</option>
                  </select>
                </div>
              </div>              

              <div class="form-group">
                <label for="processo" class="col-sm-2 control-label">Processo</label>
                <div class="col-lg-4">
                  
                  <div class="input-group">
                    <input value="<?= set_value('processo'); ?>" name="processo" type="text" class="form-control">
                  </div>
                  <!-- /input-group -->
                </div>
                <!-- /.col-lg-6 -->
                <label for="grupo_cota" class="col-sm-2 control-label">Grupo/Cota</label>
                <div class="col-lg-3">
                  <div class="input-group">
                    <input value="<?= set_value('grupo_cota'); ?>"  name="grupo_cota" type="text" class="form-control">
                  </div>
                  <!-- /input-group -->
                </div>
              </div>

              <div class="form-group">
                <label for="tipo_audiencia" class="col-sm-2 control-label">Tipo Audiência</label>
                <div class="col-sm-9">
                <select name="tipo_audiencia" class="form-control select2" id="tipo_audiencia" data-placeholder="Selecione" style="width: 100%;">
                  <option value="1">Justiça Comum</option>
                  <option value="2">Advogado + Preposto</option>
                  <option value="3">Presposto</option>
                  <option value="4">Procon</option>
                  <option value="5">Trabalhista</option>
                  <option value="6">Outros</option>
                </select>
                </div>
              </div> 

              <hr/>
              <div class="form-group"><b>Partes</b></div>

              <div class="form-group">
                  <label for="parte_1" class="col-sm-2 control-label">Parte 1</label>

                  <div class="col-sm-9">
                  <input value="<?= set_value('parte_1'); ?>" type="text" name="parte_1" class="form-control" id="parte_1" placeholder="">
                  </div>
              </div>

              <div class="form-group">
                  <label for="parte_2" class="col-sm-2 control-label">Parte 2</label>

                  <div class="col-sm-9">
                  <input value="<?= set_value('parte_2'); ?>" type="text" name="parte_2" class="form-control" id="parte_2" placeholder="">
                  </div>
              </div>

              <div class="form-group">
                  <label for="adv_escritorio" class="col-sm-2 control-label">Advogado Escritório</label>

                  <div class="col-sm-9">
                  <input value="<?= set_value('adv_escritorio'); ?>" type="text" name="adv_escritorio" class="form-control" id="adv_escritorio" placeholder="">
                  </div>
              </div>

              <div class="form-group">
                <label for="observacoes" class="col-sm-2 control-label">Observações</label>
                <div class="box-body pad col-sm-9">
                    <textarea  name="observacoes" rows="4" class="textarea" placeholder="Digite aqui as observações desta audiência..." style="width: 100%; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= set_value('observacoes'); ?></textarea>
                </div>
              </div>
              
              <hr/>
              <div class="form-group"><b>Status da audiência</b></div>

              <div class="form-group">
                <label for="status" class="col-sm-2 control-label">Status</label>
                <div class="col-sm-9">
                <select name="status" class="form-control select2" id="status" data-placeholder="Selecione" style="width: 100%;">
                  <option value="1">Audiência Cadastrada</option>
                  <option value="2">Advogado Confirmado</option>
                  <option value="3">Defesa Elaborada</option>
                  <option value="4">Protocolado</option>
                  <option value="5">Enviado Correspondente</option>
                  <option value="6">Ata Recebida</option>
                  <option value="7">Pago</option>
                  <option value="8">Arquivado</option>
                </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Salvar" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close(); ?>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 

<!-- Select2 -->
<script src="<?= base_url() ?>public/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="<?= base_url() ?>public/plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?= base_url() ?>public/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?= base_url() ?>public/plugins/input-mask/jquery.inputmask.extensions.js"></script>

<!-- bootstrap datepicker -->
<script src="<?= base_url() ?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<!-- Page script -->
<script>

  function BuscaAdvogados(comarca)
  {
      $.ajax({
          type: 'GET',
          url: '<?= base_url("admin/advogado/get_advogados_por_comarca/"); ?>'+comarca,
          success: function(response){
            var data = JSON.parse(response);
            html='';
            for(var i=0; i<data.length; i++)
            {
              html += '<option value='+data[i].codigo_advogado+'>'+data[i].nome+'</option>';
            }
            $('#codigo_advogado').html(html);
          }
        });
  }
  $( document ).ready(function() {
    BuscaAdvogados($('#codigo_comarca').val());
  });
  
    

  $(function () {

    //Initialize Select2 Elements
    $(".select2").select2();

    //Datemask dd/mm/yyyy
    //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Money Euro
    //$("[data-mask]").inputmask();
    
    $("#hora").inputmask("99:99");

    //Date picker
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'dd/mm/yyyy',                
        language: 'pt-BR',
    });

  });


</script>


<style>
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: black;
}
.ui-widget-content {
    z-index: 9999 !important;
}
</style>
