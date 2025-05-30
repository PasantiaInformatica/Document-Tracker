<?php
// Inicia sesión para acceder a variables de sesión si son necesarias
session_start();
?>

<!-- Script que contiene funciones relacionadas con trámites, incluida la de seguimiento -->
<script src="../js/console_tramite.js?rev=<?php echo time(); ?>"></script>

<!-- Estilo para checkboxes personalizados -->
<link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- Header de contenido: muestra el título y la ruta de navegación -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0"><b>Seguimiento de Trámites</b></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
          <li class="breadcrumb-item active">Seguimiento de Trámites</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <!-- Contenedor principal -->
        <div class="card">
          <div class="card-header">
            <!-- Descripción de uso -->
            <h3 class="card-title">
              <b>Descripción:</b> Consulta el estado de un trámite ingresando el número de trámite y el número de DNI del solicitante.
            </h3>
          </div>
          <div class="card-body">
            <!-- Formulario para buscar un trámite -->
            <div class="card">
              <div class="card-header bg-dark">
                <h5 class="card-title m-0"><b>Buscador de trámite</b></h5>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-5">
                    <label for="">NRO SEGUIMIENTO</label>
                    <!-- Input para el número de seguimiento -->
                    <input type="text" class="form-control" id="txt_numero">
                  </div>
                  <div class="col-5">
                    <label for="">DNI</label>
                    <!-- Input para el DNI del solicitante -->
                    <input type="text" class="form-control" id="txt_dni">
                  </div>
                  <div class="col-2">
                    <label for="">&nbsp;</label><br>
                    <!-- Botón de búsqueda que llama a la función Traer_Datos_Seguimiento() -->
                    <button class="btn btn-danger" style="width:100%" onclick="Traer_Datos_Seguimiento()">
                      <i class="fa fa-search"></i> Buscar
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Sección de resultados que se muestra solo tras una búsqueda exitosa -->
            <div class="col-lg-12" id="div_buscador" style="display:none">
              <div class="card">
                <div class="card-header bg-dark">
                  <h5 class="card-title m-0" id="lbl_titulo"><b>Seguimiento</b></h5>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12" id="div_seguimiento">
                      <!-- Aquí se insertará dinámicamente la línea de tiempo o estados del trámite -->
                    </div>                 
                  </div>
                </div>
              </div>
            </div>
            <!-- Fin de la sección de Seguimiento -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script general de usuarios (puede incluir utilidades comunes) -->
<script src="../js/console_usuario.js?rev=<?php echo time(); ?>"></script>

</body>
</html>

