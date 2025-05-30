<?php
  session_start();
?>
<!-- Script con funciones específicas del módulo trámite -->
<script src="../js/console_tramite.js?rev=<?php echo time();?>"></script>

<!-- Estilos para checkboxes personalizados -->
<link rel="stylesheet" href="../template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

<!-- Encabezado principal -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Registro de Trámite</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php">Página Principal</a></li>
            <li class="breadcrumb-item active">Tramite</li>
        </ol>
        </div>
    </div>
    </div>
</div>

<!-- Contenedor principal -->
<div class="col-12">
    <div class="row">
        <!-- Sección de datos del remitente -->
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title">Datos del Remitente</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Campos para ingresar información personal del remitente -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">Nº DNI</label>
                            <input type="text" class="form-control" id="txt_dni">
                        </div>
                        <div class="col-12 form-group">
                            <label style="font-size:small;">NOMBRE</label>
                            <input type="text" class="form-control" id="txt_nom">
                        </div>
                        <div class="col-12 form-group">
                            <label style="font-size:small;">APELLIDO PATERNO</label>
                            <input type="text" class="form-control" id="txt_apepat">
                        </div>
                        <div class="col-12 form-group">
                            <label style="font-size:small;">APELLIDO MATERNO</label>
                            <input type="text" class="form-control" id="txt_apemat">
                        </div>
                        <div class="col-12 form-group">
                            <label style="font-size:small;">CELULAR</label>
                            <input type="text" class="form-control" id="txt_cel">
                        </div>
                        <div class="col-12 form-group">
                            <label style="font-size:small;">EMAIL</label>
                            <input type="text" class="form-control" id="txt_email">
                        </div>
                    </div>                                     
                </div>
            </div>
        </div>
        
        <!-- Sección de datos del documento -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Datos del Documento</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Campo para mostrar área de procedencia basado en rol del usuario -->
                        <div class="col-6 form-group">
                            <label style="font-size:small;">PROCEDENCIA DEL DOCUMENTO</label>
                            <input 
                                type="text" 
                                id="select_area_p" 
                                class="form-control" 
                                value="<?php
                                // Asignación segura de nombre de área según rol en sesión
                                $mapa_areas = [
                                    'DECANATO' => 'Decanato',
                                    'SECRETARÍA ACADÉMICA' => 'Secretaría Académica',
                                    'VICEDECANATO' => 'Vicedecanato',
                                    'ADMIN' => 'Administración'
                                ];
                                
                                $valor_fijo = 'ROL NO DEFINIDO';
                                if (!empty($_SESSION['S_ROL']) && array_key_exists($_SESSION['S_ROL'], $mapa_areas)) {
                                    $valor_fijo = $mapa_areas[$_SESSION['S_ROL']];
                                } elseif (!empty($_SESSION['S_ROL'])) {
                                    $valor_fijo = $_SESSION['S_ROL'];
                                }
                                
                                echo htmlspecialchars($valor_fijo, ENT_QUOTES, 'UTF-8');
                                ?>" 
                                readonly 
                                style="background-color: #f8f9fa; cursor: not-allowed;"
                                onfocus="this.blur()">
                        </div>

                        <!-- Select para elegir área de destino, cargado dinámicamente -->
                        <div class="col-6 form-group">
                            <label style="font-size:small;">AREA DE DESTINO</label>
                            <select class="js-example-basic-single" id="select_destino_de" style="width:100%"></select>
                        </div>

                        <!-- Select para tipo de documento -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">TIPO DOCUMENTO</label>
                            <select class="js-example-basic-single" id="select_tipo" style="width:100%"></select>
                        </div>

                        <!-- Campo para número correlativo del documento -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">CORRELATIVO</label>
                            <input type="text" class="form-control" id="txt_ndocumento">
                        </div>

                        <!-- Campo para asunto del trámite -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">ASUNTO DEL TRAMITE</label>
                            <input type="text" class="form-control" id="txt_asunto">
                        </div>

                        <!-- Input para adjuntar documentos, acepta múltiples archivos -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">ADJUNTAR DOCUMENTO</label>
                            <input type="file" class="form-control" id="txt_archivo" multiple>
                        </div>

                        <!-- Área para descripción adicional del trámite -->
                        <div class="col-12 form-group">
                            <label style="font-size:small;">DESCRIPCIÓN</label>
                            <textarea id="txt_descripcion" rows="3" class="form-control" style="resize:none"></textarea>
                        </div>

                        <!-- Checkbox para aceptación de veracidad de datos -->
                        <div class="col-12"><br>
                            <div class="form-group clearfix">
                                <div class="icheck-success d-inline">
                                    <input type="checkbox" id="checkboxSuccess1" onclick="validar_informacion()">
                                    <label for="checkboxSuccess1" style="text-align:justify;">
                                        Declaro bajo penalidad de perjurio, que toda la información proporcionada es correcta y verídica.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botón para registrar trámite, habilitado solo si se acepta veracidad -->
                        <div class="col-12" style="text-align:center">
                            <button class="btn btn-success btn-lg" onclick="Registrar_Tramite()" id="btn_registro">Registrar Trámite</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        Cargar_Select_Area_Destino(value="<?php
                            // Mapeo seguro de roles a áreas
                            $mapa_areas = [
                                'DECANATO' => '3',
                                'SECRETARÍA ACADÉMICA' => '1',
                                'VICEDECANATO' => '2',
                            ];
                            
                            // Valor fijo basado en el rol con triple validación
                            $valor_fijo = 'ROL NO DEFINIDO';
                            if (!empty($_SESSION['S_ROL']) && array_key_exists($_SESSION['S_ROL'], $mapa_areas)) {
                                $valor_fijo = $mapa_areas[$_SESSION['S_ROL']];
                            } elseif (!empty($_SESSION['S_ROL'])) {
                                $valor_fijo = $_SESSION['S_ROL'];
                            }
                            
                            echo htmlspecialchars($valor_fijo, ENT_QUOTES, 'UTF-8');
                            ?>")
        Cargar_Select_Tipo();
    });
    
    validar_informacion();

    function validar_informacion() {
        if (document.getElementById('checkboxSuccess1').checked == false) {
            $("#btn_registro").addClass("disabled");
        } else {
            $("#btn_registro").removeClass("disabled");
        }
    }

    $('input[type="file"]').on('change', function() {
        var ext = $(this).val().split('.').pop();
        console.log($(this).val());
        
        if ($(this).val() != '') {
            if (
                ext == "PDF" || ext == "pdf" || ext == "docx" || ext == "DOCX" ||
                ext == "zip" || ext == "png" || ext == "PNG" ||
                ext == "jpg" || ext == "JPG" || ext == "jpeg" || ext == "JPEG" ||
                ext == "rar" || ext == "xlsx" || ext == "xls"
            ) {
                if ($(this)[0].files[0].size > 31457280) { // 30 MB
                    Swal.fire(
                        "El archivo selecionado es demasiado pesado",
                        "<label style='color:#9B0000;'>seleccionar un archivo mas liviano</label>",
                        "warning"
                    );
                    $("#txt_archivo").val("");
                    return;
                } else {
                    // Archivo válido y tamaño permitido
                }
                $("#txtformato").val(ext);
            } else {
                $("#txt_archivo").val("");
                Swal.fire("Mensaje de Error", "Extensión no permitida: " + ext, "", "error");
            }
        }
    });

</script>