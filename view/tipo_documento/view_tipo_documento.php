<!-- Estilo para la tabla -->
<style>
  #tabla_tipo th,
  #tabla_tipo td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script con funciones del módulo tipo de documento -->
<script src="../js/console_tipodocumento.js?rev=<?php echo time();?>"></script>

<!-- Encabezado de sección -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Gestión de Tipo de Trámites</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Gestión de Tipo de Trámites</li>
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
          <!-- Cabecera de tarjeta con descripción y botón -->
          <div class="card-header">
            <h3 class="card-title">
              <b>Descripción:</b> Define los tipos de trámites disponibles en el sistema para su clasificación y gestión adecuada.
            </h3>
            <button class="btn btn-danger btn-sm float-right" onclick="AbrirRegistro()">
              <i class="fas fa-plus"></i> Nuevo Registro
            </button>
          </div>

          <!-- Tabla de tipo de trámites -->
          <div class="card-body">
            <table id="tabla_tipo" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>TIPO TRÁMITE</th>
                  <th>FECHA REGISTRO</th>
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

<!-- Modal para registrar tipo de trámite -->
<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Registro de Tipo de Documento</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label>TIPO TRÁMITE</label>
            <input type="text" class="form-control" id="txt_tipo">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onclick="Registrar_Tipo()">Registrar</button>
      </div>
    </div>
  </div>
</div>  

<!-- Modal para editar tipo de trámite -->
<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Editar datos de Tipo de Documento</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label>TIPO TRÁMITE</label>
            <input type="text" class="form-control" id="txt_tipo_editar">
            <input type="text" id="txt_idtipo" hidden>
          </div>
          <div class="col-12">
            <label>ESTADO</label>
            <select id="select_status" class="form-control">
              <option value="ACTIVO">ACTIVO</option>
              <option value="INACTIVO">INACTIVO</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onclick="Modificar_Tipo()">Modificar</button>
      </div>
    </div>
  </div>
</div>  

<!-- Script de inicialización -->
<script>
  $(document).ready(function() {
    Listar_TipoDocumento();
  });

  // Al abrir el modal de registro, enfoca el input de tipo
  $('#modal_registro').on('shown.bs.modal', function () {
    $('#txt_tipo').trigger('focus');
  });
</script>
