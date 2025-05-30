<!-- Estilo para la tabla -->
<style>
  #tabla_tramite th,
  #tabla_tramite td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script con funciones del módulo de trámite por área -->
<script src="../js/console_tramite_area.js?rev=<?php echo time();?>"></script>

<!-- Estilo para los checkboxes personalizados -->
<link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- Encabezado de sección -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Trámites Pendientes</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Trámites Pendientes</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Contenido principal -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <!-- Encabezado con descripción y botón -->
          <div class="card-header">
            <h3 class="card-title">
              <b>Descripción:</b> Revisa y gestiona los trámites que están en proceso y requieren atención o validación por parte del área correspondiente.
            </h3>
            <button class="btn btn-danger btn-sm float-right" onclick="cargar_contenido('contenido_principal','tramite/view_tramite_registro.php')">
              <i class="fas fa-plus"></i> Nuevo Registro
            </button>
          </div>

          <!-- Filtro y tabla de trámites -->
          <div class="card-body">
            <label for="filter_estado">Filtrar por Estado:</label>
            <select id="filter_estado" style="width: 200px; margin-bottom: 10px;">
              <option value="">TODOS</option>
              <option value="EN PROCESO">EN PROCESO</option>
              <option value="FINALIZADO">FINALIZADO</option>
            </select>

            <table id="tabla_tramite" class="display compact" style="width:100%">
              <thead>
                <tr>
                  <th>NRO SEGUIMIENTO</th>
                  <th>ASUNTO TRÁMITE</th>
                  <th>TIPO TRÁMITE</th>
                  <th>REMITENTE</th>
                  <th>MÁS DATOS</th>
                  <th>SEGUIMIENTO</th>
                  <th>ÁREA ORIGEN</th>
                  <th>ÁREA DESTINO</th>
                  <th>ESTADO</th>
                  <th>ACCIÓN</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal de seguimiento del trámite -->
<div class="modal fade" id="modal_seguimiento" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_titulo">SEGUIMIENTO DEL TRÁMITE</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <table id="tabla_seguimiento" class="display compact" style="width:100%">
              <thead>
                <tr>
                  <th>PROCEDENCIA</th>
                  <th>DESTINO</th>
                  <th>FECHA</th>
                  <th>DESCRIPCIÓN</th>
                  <th>ARCHIVOS ANEXADOS</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal con más información del trámite -->
<div class="modal fade" id="modal_mas" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_titulo_datos">MÁS INFORMACIÓN DEL TRÁMITE</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <!-- Tabs con información general y del remitente -->
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs">
                  <li class="nav-item">
                    <a class="nav-link active" data-toggle="pill" href="#custom-tabs-one-home">Información</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" data-toggle="pill" href="#custom-tabs-one-profile">Datos del Remitente</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <!-- Tab de información del trámite -->
                  <div class="tab-pane fade show active" id="custom-tabs-one-home">
                    <div class="row">
                      <div class="col-6 form-group">
                        <label>PROCEDENCIA</label>
                        <select class="js-example-basic-single" id="select_area_p" style="width:100%" disabled></select>
                      </div>
                      <div class="col-6 form-group">
                        <label>ÁREA DE DESTINO</label>
                        <select class="js-example-basic-single" id="select_area_d" style="width:100%" disabled></select>
                      </div>
                      <div class="col-12 form-group">
                        <label>TIPO TRÁMITE</label>
                        <select class="js-example-basic-single" id="select_tipo" style="width:100%" disabled></select>
                      </div>
                      <div class="col-12 form-group">
                        <label>CORRELATIVO</label>
                        <input type="text" class="form-control" id="txt_ndocumento" disabled>
                      </div>
                      <div class="col-12 form-group">
                        <label>ASUNTO TRÁMITE</label>
                        <textarea id="txt_asunto" rows="3" class="form-control" style="resize:none" disabled></textarea>
                      </div>
                      <div class="col-12 form-group">
                        <label>DESCRIPCIÓN</label>
                        <textarea id="txt_descripcion" rows="3" class="form-control" style="resize:none;" disabled></textarea>
                      </div>
                    </div>
                  </div>

                  <!-- Tab de datos del remitente -->
                  <div class="tab-pane fade" id="custom-tabs-one-profile">
                    <div class="row">
                      <div class="col-6 form-group">
                        <label>Nº DNI</label>
                        <input type="text" class="form-control" id="txt_dni" disabled>
                      </div>
                      <div class="col-6 form-group">
                        <label>NOMBRE</label>
                        <input type="text" class="form-control" id="txt_nom" disabled>
                      </div>
                      <div class="col-6 form-group">
                        <label>APELLIDO PATERNO</label>
                        <input type="text" class="form-control" id="txt_apepat" disabled>
                      </div>
                      <div class="col-6 form-group">
                        <label>APELLIDO MATERNO</label>
                        <input type="text" class="form-control" id="txt_apemat" disabled>
                      </div>
                      <div class="col-6 form-group">
                        <label>CELULAR</label>
                        <input type="text" class="form-control" id="txt_cel" disabled>
                      </div>
                      <div class="col-6 form-group">
                        <label>EMAIL</label>
                        <input type="text" class="form-control" id="txt_email" disabled>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para derivar o finalizar trámite -->
<div class="modal fade" id="modal_derivar"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_titulo_derivar">SEGUIMIENTO DEL TRÁMITE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-6 form-group">
                <label for="">Fecha Registro:</label> 
                <input type="text" id="txt_fecha_de" class="form-control" disabled>
            </div>
            <div class="col-6">
                <label for="" style="font-size:small;">Acción:</label>
                <select class="js-example-basic-single" id="select_derivar_de" style="width:100%;">
                    <option value="DERIVAR">DERIVAR</option>
                    <option value="FINALIZAR">FINALIZAR</option>
                </select>
            </div>
            <div class="col-6 form-group div_derivacion">
                <label for="">Area Origen</label> 
                <input type="text" id="txt_origen_de" class="form-control" disabled>
            </div>
            <div class="col-6 form-group div_derivacion">
                <label for="">Area Destino</label> 
                <select class="js-example-basic-single" id="select_destino_de" style="width:100%;">
                </select>
            </div>
            <div class="col-12 form-group">
                <label for="">Anexar documento</label>
                <input type="file" id="txt_documento_de" multiple class="form-control">
            </div>
            <div class="col-12">
                <label for="">Descripción:</label>
                <textarea id="txt_descripcion_de" rows="3" class="form-control" style="resize:none;"></textarea>
            </div>
            <input type="text" id="txt_idocumento_de" hidden>
            <input type="text" id="txt_idareaorigen" hidden>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" onclick="Registrar_Derivacion()">Registrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script de inicialización y lógica del modal -->
<script>
    $(document).ready(function() {
    $('.js-example-basic-single').select2();
    Listar_Tramite();
    Cargar_Select_Area();
    Cargar_Select_Tipo();
    });

    // Cambia visibilidad de campos según acción seleccionada
    $("#select_derivar_de").change(function(){
        let de = document.getElementById('select_derivar_de').value;
        if(de=="DERIVAR"){
            let x = document.getElementsByClassName('div_derivacion');
            var i;
            for (i = 0; i < x.length; i++) {
                x[i].style.display = 'block';   
            }
        } else {
            let x = document.getElementsByClassName('div_derivacion');
            var i;
            for (i = 0; i < x.length; i++) {
                x[i].style.display = 'none';   
            }
        }
    });
</script>
