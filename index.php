<?php
  // Inicia una nueva sesión o reanuda la existente
  session_start();

  // Si hay una sesión activa (usuario ya autenticado), redirige al panel principal
  if (isset($_SESSION['S_ID'])) {
    header('Location: view/index.php');
    exit(); // Importante: detiene la ejecución del resto del script
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DocumentTracker | Login</title>

  <!-- Estilos y librerías -->
  <link rel="stylesheet" href="template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <link rel="stylesheet" href="template/assets/css/styles.css">
</head>

<body class="hold-transition login-page">

  <!-- Contenedor principal del login -->
  <div class="container">
    <div class="login__content">
      <div class="login__form">

        <!-- Encabezado del formulario -->
        <div>
          <h1 class="login__title">
            <span>Document</span> Tracker
          </h1>
          <p class="login__description">
            Sigue cada trámite. Mejora cada proceso.
          </p>
        </div>

        <!-- Inputs de usuario y contraseña -->
        <div>
          <div class="login__inputs">
            <div>
              <label for="txt_usuario" class="login__label">Usuario</label>
              <input type="text" id="txt_usuario" placeholder="Ingresa tu Usuario" required class="login__input">
            </div>

            <div>
              <label for="txt_contra" class="login__label">Contraseña</label>
              <div class="login__box">
                <input type="password" id="txt_contra" placeholder="Ingresa tu Contraseña" required class="login__input">
                <!-- Icono para mostrar/ocultar contraseña -->
                <i class="ri-eye-off-line login__eye" id="input-icon"></i>
              </div>
            </div>
          </div>

          <!-- Checkbox para recordar usuario -->
          <div class="login__check">
            <input type="checkbox" class="login__check-input" id="remember">
            <label for="remember" class="login__check-label">Recordar Usuario</label>
          </div>
        </div>

        <!-- Botón de inicio de sesión -->
        <div>
          <div class="login__buttons">
            <button type="submit" class="login__button" onclick="Iniciar_Sesion()">Iniciar Sesión</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Scripts necesarios -->
  <script src="template/assets/js/main.js"></script>
  <script src="template/plugins/jquery/jquery.min.js"></script>
  <script src="template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="template/dist/js/adminlte.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <!-- Script principal con función de login -->
  <script src="js/console_usuario.js?rev=<?php echo time(); ?>"></script>

  <!-- Lógica para recordar usuario y contraseña con localStorage -->
  <script>
    const rmcheck = document.getElementById('remember'),
          usuarioInput = document.getElementById('txt_usuario'),
          passInput = document.getElementById('txt_contra');

    if (localStorage.checkbox && localStorage.checkbox !== "") {
      rmcheck.setAttribute("checked", "checked");
      usuarioInput.value = localStorage.usuario;
      passInput.value = localStorage.pass;
    } else {
      rmcheck.removeAttribute("checked");
      usuarioInput.value = "";
      passInput.value = "";
    }
  </script>
</body>
</html>