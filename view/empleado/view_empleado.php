<!-- Estilo para la tabla -->
<style>
  #tabla_empleado th,
  #tabla_empleado td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script con funciones del módulo empleado -->
<script src="../js/console_empleado.js?rev=<?php echo time();?>"></script>

<!-- Encabezado de sección -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Gestión de Empleados</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Gestión de Empleados</li>
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
              <b>Descripción:</b> Gestiona la información personal y de contacto del personal registrado en el sistema.
            </h3>
            <button class="btn btn-danger btn-sm float-right" onclick="AbrirRegistro()">
              <i class="fas fa-plus"></i> Nuevo Registro
            </button>
          </div>

          <!-- Tabla de empleados -->
          <div class="card-body">
            <table id="tabla_empleado" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>DNI EMPLEADO</th>
                  <th>EMPLEADO</th>
                  <th>CELULAR</th>
                  <th>EMAIL</th>
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

<!-- Modal para registrar empleado -->
<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">REGISTRO DE EMPLEADO</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <label>DNI EMPLEADO</label>
            <input type="text" class="form-control" id="txt_nro" onkeypress="return soloNumeros(event)">
          </div>
          <div class="col-8">
            <label>NOMBRES</label>
            <input type="text" class="form-control" id="txt_nom" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>APELLIDO PATERNO</label>
            <input type="text" class="form-control" id="txt_apepa" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>APELLIDO MATERNO</label>
            <input type="text" class="form-control" id="txt_apema" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>FECHA NACIMIENTO</label>
            <input type="date" class="form-control" id="txt_fnac">
          </div>
          <div class="col-6">
            <label>CELULAR</label>
            <input type="text" class="form-control" id="txt_cel" onkeypress="return soloNumeros(event)">
          </div>
          <div class="col-12">
            <label>DIRECCIÓN</label>
            <input type="text" class="form-control" id="txt_dire">
          </div>
          <div class="col-12">
            <label>EMAIL</label>
            <input type="text" class="form-control" id="txt_email">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button class="btn btn-success" onclick="Registrar_Empleado()">Registrar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Modal para editar empleado -->
<div class="modal fade" id="modal_editar" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">EDITAR DATOS DE EMPLEADO</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-4">
            <input type="text" id="txt_idempleado" hidden>
            <label>DNI EMPLEADO</label>
            <input type="text" class="form-control" id="txt_nro_editar" onkeypress="return soloNumeros(event)">
          </div>
          <div class="col-8">
            <label>NOMBRES</label>
            <input type="text" class="form-control" id="txt_nom_editar" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>APELLIDO PATERNO</label>
            <input type="text" class="form-control" id="txt_apepa_editar" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>APELLIDO MATERNO</label>
            <input type="text" class="form-control" id="txt_apema_editar" onkeypress="return soloLetras(event)">
          </div>
          <div class="col-6">
            <label>FECHA NACIMIENTO</label>
            <input type="date" class="form-control" id="txt_fnac_editar">
          </div>
          <div class="col-6">
            <label>CELULAR</label>
            <input type="text" class="form-control" id="txt_cel_editar" onkeypress="return soloNumeros(event)">
          </div>
          <div class="col-12">
            <label>DIRECCIÓN</label>
            <input type="text" class="form-control" id="txt_dire_editar">
          </div>
          <div class="col-8">
            <label>EMAIL</label>
            <input type="text" class="form-control" id="txt_email_editar">
          </div>
          <div class="col-4">
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
        <button class="btn btn-success" onclick="Modificar_Empleado()">Modificar</button>
      </div>
    </div>
  </div>
</div>

<!-- Script de inicialización -->
<script>
  $(document).ready(function() {
    Listar_Empleado();
  });

  // Enfocar campo DNI al abrir modal de registro
  $('#modal_registro').on('shown.bs.modal', function () {
    $('#txt_nro').trigger('focus');
  });
</script>