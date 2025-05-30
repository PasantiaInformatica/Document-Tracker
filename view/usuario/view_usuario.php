<!-- Estilo para la tabla -->
<style>
  #tabla_usuario th,
  #tabla_usuario td {
    text-align: left !important;
    vertical-align: middle !important;
  }
</style>

<!-- Script del módulo usuario (evita caché con timestamp) -->
<script src="../js/console_usuario.js?rev=<?php echo time();?>"></script>

<!-- Encabezado de la sección -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Gestión de Usuarios</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Gestión de Usuarios</li>
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
          <!-- Encabezado con botón para nuevo registro -->
          <div class="card-header">
            <h3 class="card-title">
              <b>Descripción:</b> Administra las cuentas de usuario, asigna roles y define las áreas a las que pertenecen dentro del sistema.
            </h3>
            <button class="btn btn-danger btn-sm float-right" onclick="AbrirRegistro()">
              <i class="fas fa-plus"></i> Nuevo Registro
            </button>
          </div>
          
          <!-- Tabla de usuarios -->
          <div class="card-body">
            <table id="tabla_usuario" class="display" style="width:100%">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>USUARIO</th>
                  <th>ÁREA</th>
                  <th>ROL</th>
                  <th>NOMBRE EMPLEADO</th>
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

<!-- Modal para registro de usuario -->
<div class="modal fade" id="modal_registro"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registro de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-6">
                <label for="">USUARIO</label>
                <input type="text" class="form-control" id="txt_usu">
            </div>
            <div class="col-6">
                <label for="">CONTRASEÑA</label>
                <input type="password" class="form-control" id="txt_con">
            </div>
            <div class="col-12">
              <label for="">NOMBRE EMPLEADO</label>
              <select class="js-example-basic-single" id= "select_empleado"
              style="width:100%">
              </select>
            </div>
            <div class="col-6">
              <label for="">ÁREA</label>
              <select class="js-example-basic-single" id="select_area"
              style="width:100%">
              </select>
            </div>
            <div class="col-6">
              <label for="">ROL</label>
              <select class="js-example-basic-single" id="select_rol"
              style="width:100%">
              <option value="ADMIN">ADMIN</option>
              <option value="SECRETARÍA ACADÉMICA">SECRETARÍA ACADÉMICA</option>
              <option value="VICEDECANATO">VICEDECANATO</option>
              <option value="DECANATO">DECANATO</option>
              </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Registrar_Usuario()">Registrar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Modal para editar usuario -->
<div class="modal fade" id="modal_editar"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Datos de Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="">USUARIO</label>
                <input type="text" class="form-control" id="txt_usu_editar"disabled>
                <input type="text" id="txt_idusuario" hidden>
            </div>
            <div class="col-12">
              <label for="">NOMBRE EMPLEADO</label>
              <select class="js-example-basic-single" id= "select_empleado_editar"
              style="width:100%">
              </select>
            </div>
            <div class="col-6">
              <label for="">ÁREA</label>
              <select class="js-example-basic-single" id="select_area_editar"
              style="width:100%">
              </select>
            </div>
            <div class="col-6">
              <label for="">ROL</label>
              <select class="js-example-basic-single" id="select_rol_editar"
              style="width:100%">
              <option value="ADMIN">ADMIN</option>
              <option value="SECRETARÍA ACADÉMICA">SECRETARÍA ACADÉMICA</option>
              <option value="VICEDECANATO">VICEDECANATO</option>
              <option value="DECANATO">DECANATO</option>
              </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Modificar_Usuario()">Modificar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="modal_contra"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar Contraseña de usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label for="">NUEVA CONTRASEÑA</label>
                <input type="password" class="form-control" id="txt_contra_nueva">
                <input type="text" id="txt_idusuario_contra" hidden>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="Modificar_Usuario_Contra()">Modificar</button>
      </div>
    </div>
  </div>
</div>   

<!-- Script de inicialización -->
<script>
  $(document).ready(function() {
    Listar_Usuario(); // Carga los datos de la tabla
    $('.js-example-basic-single').select2(); // Aplica Select2 a los select
    Cargar_Select_Empleado(); // Llena el select de empleados
    Cargar_Select_Area(); // Llena el select de áreas
  });
</script>