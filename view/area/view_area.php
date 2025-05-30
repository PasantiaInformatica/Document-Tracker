<!-- Estilo para la tabla -->
<style>
  #tabla_area th,
  #tabla_area td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script del módulo área -->
<script src="../js/console_area.js?rev=<?php echo time();?>"></script>

<!-- Encabezado de sección -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Gestión de Áreas</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Gestión de Áreas</li>
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
          <!-- Cabecera con descripción y botón -->
          <div class="card-header">
            <h3 class="card-title">
              <b>Descripción:</b> Consulta, edita o agrega nuevas áreas de trabajo dentro de la institución para su asignación a usuarios y trámites.
            </h3>
            <button class="btn btn-danger btn-sm float-right" onclick="AbrirRegistro()">
              <i class="fas fa-plus"></i> Nuevo Registro
            </button>
          </div>

          <!-- Tabla de áreas -->
          <div class="card-body">
            <table id="tabla_area" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>ÁREA</th>
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

<!-- Modal de registro de nueva área -->
<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Área</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="">ÁREA</label>
                <input type="text" class="form-control" id="txt_area">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Registrar_Area()">Registrar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Modal para editar área existente -->
<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar datos de Área</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="">ÁREA</label>
                <input type="text" class="form-control" id="txt_area_editar">
                <input type="text" id="txt_idarea" hidden>
            </div>
            <div class="col-12">
                <label for="">ESTADO</label>
                <select name="" id="select_status" class="form-control">
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="INACTIVO">INACTIVO</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Modificar_Area()">Modificar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Inicialización del módulo -->
<script>
  $(document).ready(function() {
    Listar_Area();
  });

  // Enfocar campo al abrir modal de registro
  $('#modal_registro').on('shown.bs.modal', function () {
    $('#txt_area').trigger('focus');
  });
</script>