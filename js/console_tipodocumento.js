var  tbl_tipodocumento; // Variable global para almacenar la instancia de DataTable

/*
    Inicializa y configura la tabla de tipos de documento usando DataTables
    Realiza una petición AJAX al servidor para obtener los datos
    Muestra los registros con paginación, búsqueda y columnas personalizadas
*/
function Listar_TipoDocumento(){
    tbl_tipodocumento = $("#tabla_tipo").DataTable({
        // Configuración básica
        "ordering":false,   
        "bLengthChange":true,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "async": false ,
        "processing": true,
        // Configuración AJAX para obtener datos
        "ajax":{
            "url":"../controller/tipo/controlador_listar_tipo.php",
            type:'POST'
        },
        // Definición de columnas
        "columns":[
            {"defaultContent":""},
            {"data":"tipodo_descripcion"},
            {"data":"tipodo_fregistro"},
            {"data":"tipodo_estado",
                // Columna de estado con formato condicional
                render: function(data,type,row){
                        if(data=='ACTIVO'){
                        return '<span class="badge bg-success">ACTIVO</span>';
                        }else{
                        return '<span class="badge bg-danger">INACTIVO</span>';
                        }
                }   
            },
            // Columna de acciones con botón de edición
            {"defaultContent":"<button class='editar btn btn-primary'><i class='fa fa-edit'></i></button>"},
            
        ],
  
        "language":idioma_espanol,
        select: true
    });
    // Numeración consecutiva de filas considerando la paginación
    tbl_tipodocumento.on('draw.td',function(){
      var PageInfo = $("#tabla_tipo").DataTable().page.info();
      tbl_tipodocumento.column(0, {page: 'current'}).nodes().each(function(cell, i){
        cell.innerHTML = i + 1 + PageInfo.start;
      });
    });
}

/*
    Maneja el evento click en el botón editar de la tabla
    Obtiene los datos del tipo de documento seleccionado y los carga en el formulario de edición
*/
$('#tabla_tipo').on('click','.editar',function(){
    // Obtiene datos de la fila
    var data = tbl_tipodocumento.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_tipodocumento.row(this).child.isShown()){
        var data = tbl_tipodocumento.row(this).data();
    }
    // Abre modal y carga datos
    $("#modal_editar").modal('show');
    document.getElementById('txt_tipo_editar').value=data.tipodo_descripcion;
    document.getElementById('txt_idtipo').value=data.tipodocumento_id;
    document.getElementById('select_status').value=data.tipodo_estado;
})

/*
    Abre el modal de registro con configuración para evitar cierre accidental
*/
function AbrirRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}

/*
    Valida y envía los datos para registrar un nuevo tipo de documento
    Muestra feedback al usuario sobre el resultado de la operación
*/
function Registrar_Tipo(){
    let tipo = document.getElementById('txt_tipo').value;
    // Validación de campo vacío
    if(tipo.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/tipo/controlador_registro_tipo.php",
        type:'POST',
        data:{
            tipo:tipo
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Registro exitoso
                Swal.fire("Mensaje de Confirmacion","Nuevo Tipo de Documento Registrado","success").then((value)=>{
                    document.getElementById('txt_tipo').value="";
                    tbl_tipodocumento.ajax.reload();
                    $("#modal_registro").modal('hide');
                });
            }else{
                // Tipo ya existe
                Swal.fire("Mensaje de Advertencia","El tipo de documento ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo el registro","error");            
        }
    })
}

/*
    Valida y envía los datos para actualizar un tipo de documento existente
    Muestra feedback al usuario sobre el resultado de la operación
*/
function Modificar_Tipo(){
    let id   = document.getElementById('txt_idtipo').value;
    let tipo = document.getElementById('txt_tipo_editar').value;
    let esta = document.getElementById('select_status').value;
    // Validación de campos obligatorios
    if(tipo.length==0 || id.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/tipo/controlador_modificar_tipo.php",
        type:'POST',
        data:{
            id:id,
            tipo:tipo,
            esta:esta
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Actualización exitosa
                Swal.fire("Mensaje de Confirmacion","Datos Actualizados","success").then((value)=>{
                    tbl_tipodocumento.ajax.reload();
                    $("#modal_editar").modal('hide');
                });
            }else{
                // Tipo ya existe
                Swal.fire("Mensaje de Advertencia","El tipo de documento ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo la modificacion","error");            
        }
    })
}