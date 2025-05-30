<?php
session_start();
?>

<!-- Estilos para tablas de trámites y seguimiento: alineación y verticalidad -->
<style>
  #tabla_tramite th,
  #tabla_tramite td,
  #tabla_seguimiento th,
  #tabla_seguimiento td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script con lógica específica del módulo trámite -->
<script src="../js/console_tramite.js?rev=<?php echo time();?>"></script>

<!-- Estilos para checkboxes personalizados -->
<link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- Encabezado principal -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><b>Gestión de Trámites</b></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
                <li class="breadcrumb-item active">Gestión de Trámites</li>
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
                <!-- Descripción y botón para nuevo registro, visible solo para ADMIN -->
                <div class="card-header">
                    <h3 class="card-title">
                        <b>Descripción: </b>Visualiza, registra y da seguimiento a los trámites académicos o administrativos ingresados por los usuarios.
                    </h3>
                    <?php if ($_SESSION['S_ROL'] == 'ADMIN') { ?>
                    <button class="btn btn-danger btn-sm float-right" onclick="cargar_contenido('contenido_principal','tramite/view_tramite_registro.php')">
                        <i class="fas fa-plus"></i> Nuevo Registro
                    </button>
                    <?php } ?>
                </div>

                <!-- Filtro por estado del trámite -->
                <div class="card-body">
                    <label for="filter_estado">Filtrar por Estado:</label>
                    <select id="filter_estado" style="width: 200px; margin-bottom: 10px;">
                        <option value="">TODOS</option>
                        <option value="EN PROCESO">EN PROCESO</option>
                        <option value="FINALIZADO">FINALIZADO</option>
                    </select>

                    <!-- Tabla principal que lista los trámites -->
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
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<!-- Modal para visualizar el seguimiento detallado del trámite -->
<div class="modal fade" id="modal_seguimiento"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lbl_titulo">SEGUIMIENTO DEL TRÁMITE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>  

<!-- Modal para mostrar más información detallada del trámite y remitente -->
<div class="modal fade" id="modal_mas"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="lbl_titulo_datos">MÁS INFORMACIÓN DEL TRÁMITE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-tabs">
                    <div class="card-header p-0 pt-1">
                        <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Información</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-home" aria-selected="false">Datos del Remitente</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-one-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6 form-group">
                                            <label for="" style="font-size:small;">PROCEDENCIA</label>
                                            <select class="js-example-basic-single" id="select_area_p" style="width:100%" disabled>
                                            </select>
                                        </div>
                                        <div class="col-6 form-group">
                                            <label for="" style="font-size:small;">ÁREA DE DESTINO</label>
                                            <select class="js-example-basic-single" id="select_area_d" style="width:100%" disabled>
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="" style="font-size:small;">TIPO TRÁMITE</label>
                                            <select class="js-example-basic-single" id="select_tipo" style="width:100%" disabled>
                                            </select>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="" style="font-size:small;">CORRELATIVO</label>
                                            <input type="text" class="form-control" id="txt_ndocumento" disabled>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="" style="font-size:small;">ASUNTO TRÁMITE</label>
                                            <textarea  id="txt_asunto" rows="3" class="form-control" style="resize:none" disabled></textarea>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label for="" style="font-size:small;">DESCRIPCIÓN</label>
                                            <textarea  id="txt_descripcion" rows="3" class="form-control" style="resize:none" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">Nº DNI</label>
                                        <input type="text" class="form-control" id="txt_dni" disabled>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">NOMBRE</label>
                                        <input type="text" class="form-control" id="txt_nom" disabled>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">APELLIDO PATERNO</label>
                                        <input type="text" class="form-control" id="txt_apepat" disabled>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">APELLIDO MATERNO</label>
                                        <input type="text" class="form-control" id="txt_apemat" disabled>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">CELULAR</label>
                                        <input type="text" class="form-control" id="txt_cel" disabled>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for=""style="font-size:small;">EMAIL</label>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>  

<!-- Script de inicialización -->
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        Listar_Tramite();
        Cargar_Select_Area();
        Cargar_Select_Tipo();
    });
</script>