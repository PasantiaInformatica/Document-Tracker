var  tbl_area; // Variable global para almacenar la instancia de DataTable

/*
    Inicializa y configura la tabla de áreas usando DataTables
    Realiza una petición AJAX para obtener los datos del servidor
    y los muestra en una tabla con paginación, búsqueda y columnas personalizadas
*/
function Listar_Area(){
    tbl_area = $("#tabla_area").DataTable({
        // Configuración básica de DataTable
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
            "url":"../controller/area/controlador_listar_area.php",
            type:'POST'
        },
        // Definición de columnas
        "columns":[
            {"defaultContent":""},
            {"data":"area_nombre"},
            {"data":"area_fecha_registro"},
            // Columna de estado con formato condicional
            {"data":"area_estado",
                render: function(data,type,row){
                        // Muestra badge verde para ACTIVO, rojo para INACTIVO
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
    tbl_area.on('draw.td',function(){
      var PageInfo = $("#tabla_area").DataTable().page.info();
      tbl_area.column(0, {page: 'current'}).nodes().each(function(cell, i){
        cell.innerHTML = i + 1 + PageInfo.start;
      });
    });
}

/*
    Evento click para el botón editar en la tabla de áreas
    Obtiene los datos de la fila seleccionada y los carga en el modal de edición
*/
$('#tabla_area').on('click','.editar',function(){
    // Obtiene datos de la fila seleccionada
    var data = tbl_area.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_area.row(this).child.isShown()){
        var data = tbl_area.row(this).data();
    }
    // Abre el modal de edición y carga los datos
    $("#modal_editar").modal('show');
    document.getElementById('txt_area_editar').value=data.area_nombre;
    document.getElementById('txt_idarea').value=data.area_cod;
    document.getElementById('select_status').value=data.area_estado;
})

/*
    Abre el modal de registro con configuración para evitar cierre accidental
*/
function AbrirRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}

/*
    Registra una nueva área validando campos y mostrando feedback al usuario
*/
function Registrar_Area(){
    let area = document.getElementById('txt_area').value;
    // Validación de campo vacío
    if(area.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }
    
    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/area/controlador_registro_area.php",
        type:'POST',
        data:{
            a:area
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Registro exitoso
                Swal.fire("Mensaje de Confirmacion","Nuevo Area Registrado","success").then((value)=>{
                    document.getElementById('txt_area').value="";
                    tbl_area.ajax.reload();
                    $("#modal_registro").modal('hide');
                });
            }else{
                // Área ya existe
                Swal.fire("Mensaje de Advertencia","El area ingresada ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo el registro","error");            
        }
    })
}

/*
    Modifica un área existente validando campos y mostrando feedback
*/
function Modificar_Area(){
    let id   = document.getElementById('txt_idarea').value;
    let area = document.getElementById('txt_area_editar').value;
    let esta = document.getElementById('select_status').value;
    
    // Validación de campos
    if(area.length==0 || id.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }
    
    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/area/controlador_modificar_area.php",
        type:'POST',
        data:{
            id:id,
            are:area,
            esta:esta
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Modificación exitosa
                Swal.fire("Mensaje de Confirmacion","Datos Actualizados","success").then((value)=>{
                    tbl_area.ajax.reload();
                    $("#modal_editar").modal('hide');
                });
            }else{
                // Área ya existe
                Swal.fire("Mensaje de Advertencia","El area ingresada ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo la modificacion","error");            
        }
    })
}
