var  tbl_empleado; // Variable global para almacenar la instancia de DataTable

/*
    Configura e inicializa la tabla de empleados usando DataTables
    Realiza una petición AJAX al servidor para obtener los datos
    y los muestra en una tabla con funcionalidades de paginación, búsqueda y ordenamiento
*/
function Listar_Empleado(){
    tbl_empleado = $("#tabla_empleado").DataTable({
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
            "url":"../controller/empleado/controlador_listar_empleado.php",
            type:'POST'
        },
        // Definición de columnas
        "columns":[
            {"defaultContent":""},
            {"data":"emple_nrodocumento"},
            {"data":"em"},
            {"data":"emple_cel"},
            {"data":"emple_email"},
            // Columna de estado con formato condicional
            {"data":"emple_status",
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
    tbl_empleado.on('draw.td',function(){
      var PageInfo = $("#tabla_empleado").DataTable().page.info();
      tbl_empleado.column(0, {page: 'current'}).nodes().each(function(cell, i){
        cell.innerHTML = i + 1 + PageInfo.start;
      });
    });
}

/*
    Maneja el evento click en el botón editar de la tabla
    Obtiene los datos del empleado seleccionado y los carga en el formulario de edición
*/
$('#tabla_empleado').on('click','.editar',function(){
    // Obtiene datos de la fila
    var data = tbl_empleado.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_empleado.row(this).child.isShown()){
        var data = tbl_empleado.row(this).data();
    }
    // Abre modal y carga datos
    $("#modal_editar").modal('show');
    // Asigna valores a los campos del formulario
    document.getElementById('txt_idempleado').value=data.empleado_id;
    document.getElementById('txt_nro_editar').value=data.emple_nrodocumento;
    document.getElementById('txt_nom_editar').value=data.emple_nombre;
    document.getElementById('txt_apepa_editar').value=data.emple_apepat;
    document.getElementById('txt_apema_editar').value=data.emple_apemat;
    document.getElementById('txt_fnac_editar').value=data.emple_fechanacimiento;
    document.getElementById('txt_cel_editar').value=data.emple_cel;
    document.getElementById('txt_dire_editar').value=data.emple_direccion;
    document.getElementById('txt_email_editar').value=data.emple_email;
    document.getElementById('select_status').value=data.emple_status;
})

/*
    Abre el modal de registro con configuración para evitar cierre accidental
*/
function AbrirRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}

/*
    Valida y envía los datos para registrar un nuevo empleado
    Muestra feedback al usuario sobre el resultado de la operación
*/
function Registrar_Empleado(){
    // Obtiene valores de los campos
    let nro = document.getElementById('txt_nro').value;
    let nom = document.getElementById('txt_nom').value;
    let apepa = document.getElementById('txt_apepa').value;
    let apema = document.getElementById('txt_apema').value;
    let fnac = document.getElementById('txt_fnac').value;
    let cel = document.getElementById('txt_cel').value;
    let dire = document.getElementById('txt_dire').value;
    let email = document.getElementById('txt_email').value;

    // Validación de campos obligatorios
    if(nro.length==0 || nom.length==0 || apepa.length==0 || apema.length==0 || fnac.length==0 || cel.length==0 || dire.length==0 || email.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/empleado/controlador_registro_empleado.php",
        type:'POST',
        data:{
            nro: nro,
            nom: nom,
            apepa: apepa,
            apema: apema,
            fnac: fnac,
            cel: cel,
            dire: dire,
            email: email
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Registro exitoso
                Swal.fire("Mensaje de Confirmacion","Nuevo Empleado Registrado","success").then((value)=>{
                    // Limpia el formulario
                    document.getElementById('txt_nro').value="";
                    document.getElementById('txt_nom').value="";
                    document.getElementById('txt_apepa').value="";
                    document.getElementById('txt_apema').value="";
                    document.getElementById('txt_fnac').value="";
                    document.getElementById('txt_cel').value="";
                    document.getElementById('txt_dire').value="";
                    document.getElementById('txt_email').value="";
                    tbl_empleado.ajax.reload();
                    $("#modal_registro").modal('hide');
                });
            }else{
                // Empleado ya existe
                Swal.fire("Mensaje de Advertencia","El empleado ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo el registro","error");            
        }
    })
}

/*
    Valida y envía los datos para actualizar un empleado existente
    Muestra feedback al usuario sobre el resultado de la operación
*/
function Modificar_Empleado(){
    // Obtiene valores de los campos
    let id    = document.getElementById('txt_idempleado').value;
    let nro   = document.getElementById('txt_nro_editar').value;
    let nom   = document.getElementById('txt_nom_editar').value;
    let apepa = document.getElementById('txt_apepa_editar').value;
    let apema = document.getElementById('txt_apema_editar').value;
    let fnac  = document.getElementById('txt_fnac_editar').value;
    let cel = document.getElementById('txt_cel_editar').value;
    let dire  = document.getElementById('txt_dire_editar').value;
    let email = document.getElementById('txt_email_editar').value;
    let esta  = document.getElementById('select_status').value;

    // Validación de campos obligatorios
    if(id.length==0  || esta.length==0 || nro.length==0 || nom.length==0  || apepa.length==0  || apema.length==0  || fnac.length==0  || cel.length==0  || dire.length==0  || email.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    // Validación de formato de email
    if(validar_email(email)){
    }else{
        return Swal.fire("Mensaje de Advertencia","El formato de email es incorrecto","warning");
    }
    // Envío de datos al servidor
    $.ajax({
        "url":"../controller/empleado/controlador_modificar_empleado.php",
        type:'POST',
        data:{
            id:id,
            nro:nro,
            nom:nom,
            apepa:apepa,
            apema:apema,
            fnac:fnac,
            cel:cel,
            dire:dire,
            email:email,
            esta:esta
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                // Actualización exitosa
                Swal.fire("Mensaje de Confirmacion","Datos del Empleado Actualizados","success").then((value)=>{
                    tbl_empleado.ajax.reload();
                    $("#modal_editar").modal('hide');
                });
            }else{
                // Número de documento ya existe
                Swal.fire("Mensaje de Advertencia","El Nro documento ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            // Error en el servidor
            return Swal.fire("Mensaje de Error","No se completo el proceso","error");            
        }
    })
}

/*
    Valida el formato de un email usando expresiones regulares
    @param {string} email - Email a validar
    @return {boolean} - True si el formato es válido, False si no
*/
function validar_email(email) {
    let regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}