var  tbl_tramite; // Variable global para almacenar la instancia de DataTable

/*
    Configura y carga una DataTable con el listado de trámites/documentos:
        - Incluye botones de acción (detalles y seguimiento)
        - Formatea estados con badges (Proceso=amarillo, Observado=rojo, Finalizado=verde)
*/
function Listar_Tramite(){
    tbl_tramite = $("#tabla_tramite").DataTable({
        "ordering":false,   
        "bLengthChange":true,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "async": false ,
        "processing": true,
        "ajax":{
            "url":"../controller/tramite/controlador_listar_tramite.php",
            type:'POST'
        },
        "columns":[
            {"data":"documento_id"},
            {"data":"doc_asunto"},
            {"data":"tipodo_descripcion"},
            {"data":"REMITENTE"},
            {"defaultContent":"<button class='mas btn btn-danger btn-sm'><i class='fa fa-search'></i></button>"},
            {"defaultContent":"<button class='seguimiento btn btn-success btn-sm'><i class='fa fa-search'></i></button>"},
            {"data":"origen"},
            {"data":"destino"},
            {
                "data": "doc_status",
                "render": function(data, type, row){
                    if(type === 'display'){
                        if(data == 'EN PROCESO'){
                            return '<span class="badge bg-warning">EN PROCESO</span>';
                        } else if(data == 'OBSERVADO'){
                            return '<span class="badge bg-danger">OBSERVADO</span>';
                        } else {
                            return '<span class="badge bg-success">FINALIZADO</span>';
                        }
                    }
                    // Para filtrado y orden retorna el valor limpio
                    return data;
                }
            }          
        ],
  
        "language":idioma_espanol,
        select: true
    });
}

/*
    Inicialización al cargar la página:
        - Carga la tabla de trámites
        - Configura filtro por estado
*/
$(document).ready(function() {
    Listar_Tramite();

    $('#filter_estado').on('change', function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        tbl_tramite
            .column(8) // columna Estado
            .search(val ? '^' + val + '$' : '', true, false)
            .draw();
    });
});

/*
    Manejador para botón de edición:
        - Abre modal de edición
        - Precarga datos del trámite seleccionado
*/
$('#tabla_tramite').on('click','.editar',function(){
    var data = tbl_tramite.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_tramite.row(this).child.isShown()){
        var data = tbl_tramite.row(this).data();
    }
    $("#modal_editar").modal('show');
    document.getElementById('txt_area_editar').value=data.area_nombre;
    document.getElementById('txt_idarea').value=data.area_cod;
    document.getElementById('select_status').value=data.area_estado;
})

/*
    Manejador para botón de seguimiento:
        - Abre modal de seguimiento
        - Carga historial del trámite
*/
$('#tabla_tramite').on('click','.seguimiento',function(){
    var data = tbl_tramite.row($(this).parents('tr')).data();
    if(tbl_tramite.row(this).child.isShown()){
        var data = tbl_tramite.row(this).data();
    }
    $("#modal_seguimiento").modal('show');
    document.getElementById('lbl_titulo').innerHTML="SEGUIMIENTO DEL TRÁMITE "+data.documento_id;
    Listar_Seguimiento_Tramite(data.documento_id);
})

/*
    Manejador para botón de detalles:
        - Abre modal con información completa
        - Precarga todos los datos del trámite
 */
$('#tabla_tramite').on('click','.mas',function(){
    var data = tbl_tramite.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_tramite.row(this).child.isShown()){
        var data = tbl_tramite.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    $("#modal_mas").modal('show');
    document.getElementById('lbl_titulo_datos').innerHTML="DATOS DEL TRÁMITE "+data.documento_id;
    document.getElementById('txt_ndocumento').value=data.doc_nrodocumento;
    document.getElementById('txt_descripcion').value=data.doc_descripcion;
    document.getElementById('txt_asunto').value=data.doc_asunto;
    $("#select_area_p").select2().val(data.area_origen).trigger('change.select2');
    $("#select_area_d").select2().val(data.area_destino).trigger('change.select2');
    $("#select_tipo").select2().val(data.tipodocumento_id).trigger('change.select2');

    document.getElementById('txt_dni').value=data.doc_dniremitente;
    document.getElementById('txt_nom').value=data.doc_nombreremitente;
    document.getElementById('txt_apepat').value=data.doc_apepatremitente;
    document.getElementById('txt_apemat').value=data.doc_apematremitente;
    document.getElementById('txt_cel').value=data.doc_celremitente;
    document.getElementById('txt_email').value=data.doc_emailremitente;
})

/*
    Carga áreas disponibles en selectores
        - Usado en formularios de registro y edición
        - Maneja casos sin datos disponibles
*/
function Cargar_Select_Area(){
    $.ajax({
        "url":"../controller/usuario/controlador_cargar_select_area.php",
        type:'POST',
    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            let cadena = "<option value=''>Seleccionar Área</option>";
            for (let i = 0; i < data.length; i++) {
                cadena+="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>";    
            }
            document.getElementById('select_area_p').innerHTML=cadena;
            document.getElementById('select_area_d').innerHTML=cadena;


        }else{
            cadena+="<option value=''>No hay áreas disponibles</option>";
            document.getElementById('select_area_p').innerHTML=cadena;
            document.getElementById('select_area_d').innerHTML=cadena;

        }

    })
}

/*
    Carga tipos de documento disponibles
        - Similar a Cargar_Select_Area pero para tipos doc
*/
function Cargar_Select_Tipo(){
    $.ajax({
        "url":"../controller/tramite/controlador_cargar_select_tipo.php",
        type:'POST',
    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            let cadena = "<option value=''>Seleccionar Tipo Documento</option>";
            for (let i = 0; i < data.length; i++) {
                cadena+="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>";    
            }
            document.getElementById('select_tipo').innerHTML=cadena;

        }else{
            cadena+="<option value=''>No hay tipos disponibles</option>";
            document.getElementById('select_tipo').innerHTML=cadena;

        }

    })
}

/*
    Registra un nuevo trámite documentario:
        - Valida datos del remitente y documento
        - Verifica archivos adjuntos (tipo y tamaño)
        - Prepara y envía datos mediante FormData
        - Procesa respuesta del servidor
*/
function Registrar_Tramite() {
    // DATOS DEL REMITENTE
    let dni = document.getElementById('txt_dni').value;
    let nom = document.getElementById('txt_nom').value;
    let apt = document.getElementById('txt_apepat').value;
    let apm = document.getElementById('txt_apemat').value;
    let cel = document.getElementById('txt_cel').value;
    let ema = document.getElementById('txt_email').value;
    let idusu = document.getElementById('txtprincipalid').value;

    // DATOS DOCUMENTO 
    let rol = document.getElementById('txtprincipalrol').value;
    let arp = "";

    if (rol == "VICEDECANATO"){
        arp = "2";
    }
    if (rol == "DECANATO"){
        arp = "3";
    }
    if (rol == "SECRETARÍA ACADÉMICA"){
        arp = "1";
    }

    let ard = document.getElementById('select_destino_de').value;
    let tip = document.getElementById('select_tipo').value;
    let ndo = document.getElementById('txt_ndocumento').value;
    let asu = document.getElementById('txt_asunto').value;
    let desc = document.getElementById('txt_descripcion').value;

    // Validaciones
    if(dni.length==0 || nom.length==0 || apt.length==0 || apm.length==0 || cel.length==0 || ema.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Llene todos los datos del remitente","warning");
    }

    if(arp.length==0 || ard.length==0 || tip.length==0 || ndo.length==0 || asu.length==0 || desc.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Llene todos los datos del documento","warning");
    }

    // Obtener archivos seleccionados
    let archivos = $("#txt_archivo")[0].files;
    if(archivos.length == 0){
        return Swal.fire("Mensaje de Advertencia","Seleccione al menos un documento","warning");
    }

    // Validar tamaño y tipo de archivos
    for(let i = 0; i < archivos.length; i++) {
        let archivo = archivos[i];
        let ext = archivo.name.split('.').pop().toLowerCase();
        
        // Validar extensión
        let extensionesPermitidas = ['pdf', 'docx', 'xlsx', 'jpg', 'jpeg', 'png', 'zip', 'rar'];
        if(!extensionesPermitidas.includes(ext)) {
            return Swal.fire("Mensaje de Error","Tipo de archivo no permitido: " + ext,"error");
        }
        
        // Validar tamaño (30MB máximo)
        if(archivo.size > 31457280) {
            return Swal.fire("Mensaje de Error","El archivo " + archivo.name + " es demasiado grande (máximo 30MB)","error");
        }
    }

    // Preparar FormData
    let formData = new FormData();
    
    // Agregar datos del remitente
    formData.append("dni", dni);
    formData.append("nom", nom);
    formData.append("apt", apt);
    formData.append("apm", apm);
    formData.append("cel", cel);
    formData.append("ema", ema);
    
    // Agregar datos del documento
    formData.append("arp", arp);
    formData.append("ard", ard);
    formData.append("tip", tip);
    formData.append("ndo", ndo);
    formData.append("asu", asu);
    formData.append("desc", desc);
    formData.append("idusu", idusu);

    // Agregar cada archivo al FormData
    for(let i = 0; i < archivos.length; i++) {
        formData.append("archivos[]", archivos[i]);
    }

    // Mostrar loader
    Swal.fire({
        title: 'Procesando trámite',
        html: 'Por favor espere...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Enviar datos al servidor
    $.ajax({
        url: "../controller/tramite/controlador_registro_tramite.php",
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp){
            if(resp.length>0){
                Swal.fire("Mensaje de Confirmacion","El trámite se registró correctamente","success").then((result) => {
                    if (result.isConfirmed) {
                        $("#contenido_principal").load("tramite/view_tramite.php");
                    }
                });
            }else{
                Swal.fire("Mensaje de Error","No se pudo completar el proceso","error");
            }
        }
    });

    return false;
}

/*
    Carga áreas excluyendo una específica
        - Para selección de área destino en derivaciones
*/
function Cargar_Select_Area_Destino(arp){
    $.ajax({
        "url":"../controller/usuario/controlador_cargar_select_area.php",
        type:'POST',

    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            let cadena = "<option value=''>Seleccionar Área</option>";
            for (let i = 0; i < data.length; i++) {
                if(data[i][0]!=arp){
                cadena+="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>"; 
                }   
            }
            document.getElementById('select_destino_de').innerHTML=cadena;

        }else{
            cadena+="<option value=''>No hay áreas disponibles</option>";
            document.getElementById('select_destino_de').innerHTML=cadena;

        }

    })
}

// SEGUIMIENTO DE TRÁMITE
var  tbl_seguimiento;

/*
    Configura DataTable para mostrar historial de trámite
        - Muestra origen, destino, fechas y descripciones
        - Maneja visualización de archivos adjuntos
*/
function Listar_Seguimiento_Tramite(id){
    tbl_seguimiento = $("#tabla_seguimiento").DataTable({
        "ordering":false,   
        "bLengthChange":true,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "async": false ,
        "processing": true,
        "ajax":{
            "url":"../controller/tramite/controlador_listar_tabla_seguimiento_tramite.php",
            type:'POST',
            data:{
                id:id
            }
        },
        "columns":[
            {"data":"area_origen_nombre"},
            {"data":"area_destino_nombre"},
            {"data":"mov_fecharegistro"},
            {"data":"mov_descripcion"},
            {"data":"mov_archivo",
                render: function(data,type,row){
                    if(data === null || data === '' || data === '[]') { // Manejar casos donde no hay archivos
                        return "<button class='btn btn-danger btn-sm' disabled><i class='fa fa-file-pdf'></i></button>";
                    } else {
                        try {
                            var archivos = JSON.parse(data); // Parsear la cadena JSON
                            let botones = '';
                            if (Array.isArray(archivos) && archivos.length > 0) {
                                archivos.forEach(function(archivo, index) {
                                    botones += `<button class='ver btn btn-danger btn-sm' data-archivo='${archivo}' data-index='${index}'><i class='fa fa-file-pdf'></i></button>&nbsp;`;
                                });
                                return botones;
                            } else {
                                return "<button class='btn btn-danger btn-sm' disabled><i class='fa fa-file-pdf'></i></button>"; // Si el array está vacío
                            }
                        } catch (error) {
                            console.error("Error al parsear mov_archivo como JSON:", error, data);
                            return "<button class='btn btn-warning btn-sm'><i class='fa fa-exclamation-triangle'></i> Error</button>"; // Mostrar un botón de error
                        }
                    }
                }
                },
            
        ],
  
        "language":idioma_espanol,
        select: true
    });
}

/*
    Manejador para visualización de archivos adjuntos
        - Abre archivos PDF en nueva pestaña
        - Construye ruta correcta al archivo
*/
$('#tabla_seguimiento').off('click', '.ver').on('click', '.ver', function() {
    var archivo = $(this).data('archivo');
    var baseUrl = window.location.origin + '/tramitedocumentario/';
    var filePath = archivo.replace('view/', '');
    window.open(baseUrl + filePath);
});