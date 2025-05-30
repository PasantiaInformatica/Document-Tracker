<?php
  // Inicia una nueva sesión o reanuda la existente
  session_start();

  // Si no hay sesión iniciada, redirige al login
  if (!isset($_SESSION['S_ID'])) {
    header('Location: ../index.php');
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Document Tracker</title>

  <!-- Fuentes y estilos -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="../template/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../template/dist/css/adminlte.min.css">
  <link href="../utilitario/DataTables/datatables.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

  <style>
    /* Ajuste visual del sidebar */
    .main-sidebar .nav-link {
      padding-top: 12px !important;
      padding-bottom: 12px !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar (solo visible en dispositivos pequeños) -->
  <nav class="main-header navbar navbar-expand navbar-danger navbar-dark d-lg-none">
    <!-- Menú lateral toggle -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
        <a href="index.php" class="nav-link">Volver a la Página Principal</a>
      </li>
    </ul>

    <!-- Usuario logueado y opción de cerrar sesión -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <?php echo $_SESSION['S_USU']; ?>
          <i class="fas fa-caret-down"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div class="dropdown-divider"></div>
          <a href="../controller/usuario/controlador_cerrar_sesion.php" class="dropdown-item">
            <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
          </a>
        </div>
      </li>
    </ul>
  </nav>

  <!-- Sidebar lateral -->
  <aside class="main-sidebar sidebar-dark-danger elevation-4">
    <!-- Logo -->
    <a href="index.php" class="brand-link">
      <img src="../template/dist/img/UPCHlogo.png" alt="Logo" class="brand-image">
      <span class="brand-text font-weight-light">Document Tracker</span>
    </a>

    <!-- Usuario en sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../controller/empleado/fotos/admin.png" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['S_USU']; ?></a>
        </div>
      </div>

      <!-- Menú según el rol del usuario -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <?php if($_SESSION['S_ROL']=='ADMIN') { ?>
            <!-- Opciones para administrador -->
            <li class="nav-item">
              <a href="index.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-home"></i>
                <p>Página Principal</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Gestión de Trámites</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','seguimiento.php')" class="nav-link">
                <i class="nav-icon fas fa-spinner"></i>
                <p>Seguimiento de Trámites</p>
              </a>
            </li>            

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','usuario/view_usuario.php')" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Gestión de Usuarios</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','empleado/view_empleado.php')" class="nav-link">
                <i class="nav-icon fas fa-user-tie"></i>
                <p>Gestión de Empleados</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','area/view_area.php')" class="nav-link">
                <i class="nav-icon fas fa-cogs"></i>
                <p>Gestión de Áreas</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','tipo_documento/view_tipo_documento.php')" class="nav-link">
                <i class="nav-icon fas fa-th-list"></i>
                <p>Tipo de Trámites</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../controller/usuario/controlador_cerrar_sesion.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Cerrar Sesión</p>
              </a>
            </li>
          <?php } elseif(in_array($_SESSION['S_ROL'], ['SECRETARÍA ACADÉMICA', 'VICEDECANATO', 'DECANATO'])) { ?>
            <!-- Opciones para usuarios con roles específicos -->
            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Página Principal</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','tramite_area/view_tramite.php')" class="nav-link">
                <i class="nav-icon fas fa-file-alt"></i>
                <p>Gestión de Trámites</p>
              </a>
            </li>

            <li class="nav-item">
              <a onclick="cargar_contenido('contenido_principal','seguimiento.php')" class="nav-link">
                <i class="nav-icon fas fa-spinner"></i>
                <p>Seguimiento de trámites</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="../controller/usuario/controlador_cerrar_sesion.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Cerrar Sesión</p>
              </a>
            </li>
          <?php } ?>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Identificadores para uso en JS -->
  <input type="text" id="txtprincipalid" value="<?php echo $_SESSION['S_ID']; ?>" hidden>
  <input type="text" id="txtprincipalusu" value="<?php echo $_SESSION['S_USU']; ?>" hidden>
  <input type="text" id="txtprincipalrol" value="<?php echo $_SESSION['S_ROL']; ?>" hidden>

  <!-- Contenedor dinámico para cargar vistas -->
  <div class="content-wrapper" id="contenido_principal">
    <!-- Encabezado -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><b>Página Principal</b></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="card card-widget widget-user">
        <div class="widget-user-header text-white" style="background: url('../template/assets/img/coverupch.jpg') center center;">
        </div>
        <div class="widget-user-image">
          <img class="img-circle" src="../template/assets/img/60anios.png" alt="User Avatar">
        </div>
        <div class="card-footer">
          <div class="row">
            <div class="col-sm-12">
              <div class="description-block">
                <h5 class="description-header">UNIVERSIDAD PERUANA CAYETANO HEREDIA</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Contenido Principal -->
    <div class="content">
      <h3 class="mt-4 mb-4">Resumen de Trámites</h3>
      <div class="container-fluid">
        <div class="row">
          <?php if($_SESSION['S_ROL']=='ADMIN') {?>
            <div class="col-lg-4 col-4">
                <!-- small card -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3 id="lbl_tramite">0</h3>

                    <p>TRÁMITES REGISTRADOS</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>  

            <div class="col-lg-4 col-4">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3 id="lbl_tramite_pendiente">0</h3>

                    <p>TRÁMITES PENDIENTES</p>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>

            <div class="col-lg-4 col-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3 id="lbl_tramite_finalizado">0</h3>

                    <p>TRÁMITES FINALIZADOS</p>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>
          <?php } elseif(in_array($_SESSION['S_ROL'], ['SECRETARÍA ACADÉMICA', 'VICEDECANATO', 'DECANATO'])) { ?>
            <div class="col-lg-4 col-4">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3 id="lbl_tramite">0</h3>

                    <p>TRÁMITES REGISTRADOS</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite_area/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>  

            <div class="col-lg-4 col-4">
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3 id="lbl_tramite_pendiente">0</h3>

                    <p>TRÁMITES PENDIENTES</p>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite_area/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>

            <div class="col-lg-4 col-4">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3 id="lbl_tramite_finalizado">0</h3>

                    <p>TRÁMITES FINALIZADOS</p>
                  </div>
                  <a onclick="cargar_contenido('contenido_principal','tramite_area/view_tramite.php')" class="small-box-footer">
                    Ver Trámites <i class="fas fa-arrow-circle-right"></i>
                  </a>
                </div>
            </div>
          <?php } ?>  
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="main-footer">
    <!-- Derecha -->
    <div class="float-right d-none d-sm-inline">
      Decanato FACI-FAVEZ
    </div>
    <!-- Izquierda -->
    Copyright &copy; <?php echo date("Y"); ?> Universidad Peruana Cayetano Heredia. Todos los derechos reservados.
  </footer>
</div>

<!-- SCRIPTS -->
 
<script>
  /**
   * Carga contenido de forma dinámica mediante AJAX.
   * @param {string} id - ID del contenedor donde se cargará el contenido.
   * @param {string} vista - Ruta del archivo que se cargará.
   */
  function cargar_contenido(id, vista){
      $("#" + id).load(vista);
  }

  /**
   * Traducción personalizada al español para DataTables.
   * Se usa para tablas con paginación, filtros, etc.
   */
  var idioma_espanol = {
    select: { rows: "%d fila seleccionada" },
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Registros del (_START_ al _END_) total de _TOTAL_ registros",
    "sInfoEmpty":      "Registros del (0 al 0) total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sSearch":         "Buscar:",
    "sLoadingRecords": "<b>No se encontraron datos</b>",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar ascendente",
        "sSortDescending": ": Activar para ordenar descendente"
    }
  };

  /**
   * Permite ingresar solo números en un input.
   */
  function soloNumeros(e){
    let tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8) return true; // Permitir backspace

    let patron = /[0-9]/;
    let tecla_final = String.fromCharCode(tecla);
    return patron.test(tecla_final);
  }

  /**
   * Permite ingresar solo letras (y algunos caracteres especiales como espacio).
   */
  function soloLetras(e){
    let key = e.keyCode || e.which;
    let tecla = String.fromCharCode(key).toLowerCase();
    let letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
    let especiales = [8, 37, 39, 46]; // Backspace, flechas, delete

    if (letras.indexOf(tecla) === -1 && !especiales.includes(key)) {
      return false;
    }
  }

  /**
   * Permite ingresar solo números flotantes (hasta 2 decimales).
   */
  function filterFloat(evt, input){
    let key = window.Event ? evt.which : evt.keyCode;
    let chark = String.fromCharCode(key);
    let tempValue = input.value + chark;

    if (key >= 48 && key <= 57) {
      return filter(tempValue);
    } else if ([8, 13, 0].includes(key)) {
      return true;
    } else if (key == 46) { // punto decimal
      return filter(tempValue);
    } else {
      return false;
    }
  }

  /**
   * Valida si un valor es un número flotante válido con hasta 2 decimales.
   */
  function filter(__val__){
    let preg = /^([0-9]+\.?[0-9]{0,2})$/;
    return preg.test(__val__);
  }
</script>

<!-- jQuery -->
<script src="../template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE (plantilla de interfaz) -->
<script src="../template/dist/js/adminlte.min.js"></script>
<!-- DataTables -->
<script src="../utilitario/DataTables/datatables.min.js"></script>
<!-- SweetAlert2 (para modales y alertas personalizadas) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Select2 (selects avanzados con búsqueda) -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- WIDGET: Resumen de trámites -->
<script>
  // Llama al backend y actualiza los contadores del dashboard (trámites)
  function Traer_Widget(){
    $.ajax({
      url: "../controller/usuario/controlador_traer_widget.php",
      type: 'POST',
    }).done(function(resp){
      let data = JSON.parse(resp);
      if(data.length > 0){
        document.getElementById('lbl_tramite').innerHTML = data[0][0];
        document.getElementById('lbl_tramite_pendiente').innerHTML = data[0][1];
        document.getElementById('lbl_tramite_finalizado').innerHTML = data[0][2];
      }
    });
  }

  // Ejecuta al cargar la página
  Traer_Widget();
</script>

<script>
  $(document).ready(function(){
    // Quitar clase 'active' de todos los nav-links
    $('.nav-link').click(function(){
      $('.nav-link').removeClass('active');
      $(this).addClass('active'); // Activar el clicado
    });

    // Activar automáticamente si ya estamos en index.php
    let currentPage = window.location.pathname.split("/").pop();
    if (currentPage === "index.php") {
      $('.nav-link[href="index.php"]').addClass('active');
    }
  });
</script>

</body>
</html>
