/*
    Proceso completo de autenticación de usuarios
        - Valida campos obligatorios
        - Verifica credenciales contra backend
        - Maneja estados de usuario (activo/inactivo)
        - Crea sesión y redirecciona
        - Incluye:
            - Validación frontend
            - Doble llamada AJAX (validación + creación de sesión)
            - Feedback visual con SweetAlert
            - Recarga la página al finalizar
*/
function Iniciar_Sesion(){
    recuerdame(); 
    let usu = document.getElementById('txt_usuario').value;
    let con = document.getElementById('txt_contra').value;
    if(usu.length==0 || con.length==0){
        return Swal.fire({
            icon: 'warning',
            title: 'Mensaje de Advertencia',
            text: 'Llene los campos de la sesion',
            heightAuto:false
        });
    } 

    $.ajax({
        url:'controller/usuario/controlador_iniciar_sesion.php',
        type:'POST',
        data:{
            u:usu,
            c:con
        }
    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            if(data[0][7]=="INACTIVO"){
                return Swal.fire({
                    icon: 'warning',
                    title: 'Mensaje de Advertencia',
                    text: 'El usuario '+usu+' se encuentra inactivo',
                    heightAuto:false
                });
            }
            $.ajax({
                url:'controller/usuario/controlador_crear_sesion.php',
                type:'POST',
                data:{
                    idusuario:data[0][0],
                    usuario:data[0][1],
                    rol:data[0][9]
                }
            }).done(function(r){
                let timerInterval
                Swal.fire({
                  title: 'Bienvenido al sistema!',
                  html: 'Serás redireccionado en <b></b> milisegundos.',
                  timer: 2000,
                  timerProgressBar: true,
                  heightAuto:false,
                  didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                      b.textContent = Swal.getTimerLeft()
                    }, 100)
                  },
                  willClose: () => {
                    clearInterval(timerInterval)
                  }
                }).then((result) => {
                  /* Read more about handling dismissals below */
                  if (result.dismiss === Swal.DismissReason.timer) {
                    location.reload();
                  }
                })
            })
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Mensaje de Advertencia',
                text: 'Usuario o contraseña incorrecta',
                heightAuto:false
            });
        }
    })
}

/*
    Guarda credenciales en localStorage si:
        - Checkbox "Recuérdame" está activado
        - Ambos campos (usuario y contraseña) tienen valores
    Sino, limpia el almacenamiento
*/
function recuerdame(){
    if(rmcheck.checked &&  usuarioInput.value!="" && passInput.value !=""){
        localStorage.usuario   = usuarioInput.value;
        localStorage.pass      = passInput.value;
        localStorage.checkbox  = rmcheck.value;      
    }else{
        localStorage.usuario   = "";
        localStorage.pass      = "";
        localStorage.checkbox  = "";     
    }
}

var tbl_usuario;

/*
    Configura DataTable para listar usuarios:
        - Carga datos via AJAX desde controlador PHP
        - Personaliza columnas (estado con badges, botones de acción)
        - Numeración automática de filas
*/
function Listar_Usuario(){
    tbl_usuario = $("#tabla_usuario").DataTable({
        "ordering":false,   
        "bLengthChange":true,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "processing": true,
        "ajax":{
            "url":"../controller/usuario/controlador_listar_usuario.php",
            type:'POST'
        },
        "columns":[
            {"defaultContent":""},
            {"data":"usu_usuario"},
            {"data":"area_nombre"},
            {"data":"usu_rol"},
            {"data":"nempleado"},
            {"data":"usu_status",
                render: function(data,type,row){
                        if(data=='ACTIVO'){
                        return '<span class="badge bg-success">ACTIVO</span>';
                        }else{
                        return '<span class="badge bg-danger">INACTIVO</span>';
                        }
                }   
            },
            {"data":"usu_status",
                render: function(data,type,row){
                        if(data=='ACTIVO'){
                        return "<button class='editar btn btn-primary btn-sm'><i class='fa fa-edit'></i></button>&nbsp;<button class='contra btn btn-warning btn-sm'><i class='fas fa-key'></i></button>&nbsp;<button class='btn btn-success btn-sm' disabled><i class='fa fa-check-circle'></i></button>&nbsp;<button class='desactivar btn btn-danger btn-sm'><i class='fa fa-times-circle'></i></button>";
                        }else{
                            return "<button class='editar btn btn-primary btn-sm'><i class='fa fa-edit'></i></button>&nbsp;<button class='contra btn btn-warning btn-sm'><i class='fas fa-key'></i></button>&nbsp;<button class='activar btn btn-success btn-sm'><i class='fa fa-check-circle'></i></button>&nbsp;<button class='btn btn-danger btn-sm'disabled><i class='fa fa-times-circle'></i></button>";
                        }
                }   
            }
            
        ],
  
        "language":idioma_espanol,
        select: true
    });
    tbl_usuario.on('draw.td',function(){
      var PageInfo = $("#tabla_usuario").DataTable().page.info();
      tbl_usuario.column(0, {page: 'current'}).nodes().each(function(cell, i){
        cell.innerHTML = i + 1 + PageInfo.start;
      });
    });
}

/* Abre modal de edición y precarga datos del usuario seleccionado */
$('#tabla_usuario').on('click','.editar',function(){
    var data = tbl_usuario.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_usuario.row(this).child.isShown()){
        var data = tbl_usuario.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    $("#modal_editar").modal('show');
    document.getElementById('txt_idusuario').value=data.usu_id;
    $("#select_empleado_editar").select2().val(data.empleado_id).trigger('change.select2');
    $("#select_area_editar").select2().val(data.area_id).trigger('change.select2');
    $("#select_rol_editar").select2().val(data.usu_rol).trigger('change.select2');
    
})

/* Abre modal para cambiar contraseña del usuario seleccionado */
$('#tabla_usuario').on('click','.contra',function(){
    var data = tbl_usuario.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_usuario.row(this).child.isShown()){
        var data = tbl_usuario.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    $("#modal_contra").modal('show');
    document.getElementById('txt_idusuario_contra').value=data.usu_id;
   
})

/* Muestra confirmación para desactivar usuario (cambia estado a INACTIVO) */
$('#tabla_usuario').on('click','.desactivar',function(){
    var data = tbl_usuario.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_usuario.row(this).child.isShown()){
        var data = tbl_usuario.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    Swal.fire({
        title: 'Desea desactivar al usuario '+data.usu_usuario+'?',
        text: "Una vez desactivado el usuario no tendra acceso al sistema!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Confirmar"
      }).then((result) => {
        if (result.isConfirmed) {
            Modificar_Status_Usuario(parseInt(data.usu_id),'INACTIVO',data.usu_usuario);
          
        }
    });
    
})

/* Muestra confirmación para activar usuario (cambia estado a ACTIVO) */
$('#tabla_usuario').on('click','.activar',function(){
    var data = tbl_usuario.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_usuario.row(this).child.isShown()){
        var data = tbl_usuario.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    Swal.fire({
        title: 'Desea activar al usuario '+data.usu_usuario+'?',
        text: "Una vez activado el usuario tendra acceso al sistema!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Confirmar"
      }).then((result) => {
        if (result.isConfirmed) {
            Modificar_Status_Usuario(parseInt(data.usu_id),'ACTIVO',data.usu_usuario);
          
        }
    });
    
})

/* 
    Abre modal de registro de usuario con configuración especial:
        - backdrop:static -> Evita que se cierre al hacer clic fuera del modal
        - keyboard:false -> Deshabilita el cierre con tecla ESC
    Prepara el formulario para nuevo registro
*/
function AbrirRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}

/* 
    Proceso completo de registro de usuario:
        1. Valida que todos los campos obligatorios estén llenos
        2. Envia datos al servidor via AJAX (POST)
        3. Maneja 3 tipos de respuestas:
            - Éxito (1): Muestra confirmación, limpia formulario y recarga tabla
            - Usuario duplicado: Muestra advertencia específica
            - Error general: Muestra mensaje de fallo en registro
        4. Recarga la tabla de usuarios después de registro exitoso
*/
function Registrar_Usuario(){
    let usu = document.getElementById('txt_usu').value;
    let con = document.getElementById('txt_con').value;
    let ide = document.getElementById('select_empleado').value;
    let ida = document.getElementById('select_area').value;
    let rol = document.getElementById('select_rol').value;

    if(usu.length==0|| con.length==0|| ide.length==0|| ida.length==0|| rol.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    $.ajax({
        "url":"../controller/usuario/controlador_registro_usuario.php",
        type:'POST',
        data:{
            usu:usu,
            con:con,
            ide:ide,
            ida:ida,
            rol:rol
        }
    }).done(function(resp){
        if(resp>0){
            if(resp==1){
                Swal.fire("Mensaje de Confirmacion","Nuevo Usuario Registrado","success").then((value)=>{
                   document.getElementById('txt_usu').value="";
                   document.getElementById('txt_con').value="";
                   document.getElementById('select_empleado').value="";
                   document.getElementById('select_area').value="";
                   document.getElementById('select_rol').value="";
                    tbl_usuario.ajax.reload();
                    $("#modal_registro").modal('hide');
                });
            }else{
                Swal.fire("Mensaje de Advertencia","El usuario ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            return Swal.fire("Mensaje de Error","No se completo el registro","error");            
        }
    })
}

/*
    Actualiza los datos básicos de un usuario:
        - Valida campos obligatorios (ID, empleado, área, rol)
        - Envía cambios al servidor via AJAX
        - Muestra confirmación/error y recarga la tabla
        - Cierra el modal de edición al completarse
*/
function Modificar_Usuario(){
    let id = document.getElementById('txt_idusuario').value;
    let ide = document.getElementById('select_empleado_editar').value;
    let ida = document.getElementById('select_area_editar').value;
    let rol = document.getElementById('select_rol_editar').value;

    if(id.length==0|| ide.length==0|| ida.length==0|| rol.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    $.ajax({
        "url":"../controller/usuario/controlador_modificar_usuario.php",
        type:'POST',
        data:{
            id:id,
            ide:ide,
            ida:ida,
            rol:rol
        }
    }).done(function(resp){
        if(resp>0){
                Swal.fire("Mensaje de Confirmacion","Datos del usuario actualizados","success").then((value)=>{
                    tbl_usuario.ajax.reload();
                    $("#modal_editar").modal('hide');
                });
        }else{
            return Swal.fire("Mensaje de Error","No se completo la actualización","error");            
        }
    })
}

/*
    Cambia la contraseña de un usuario:
        - Valida ID y nueva contraseña
        - Envía datos al servidor via AJAX
        - Muestra confirmación/error y recarga tabla
        - Cierra el modal de contraseña al completarse
*/
function Modificar_Usuario_Contra(){
    let id = document.getElementById('txt_idusuario_contra').value;
    let con = document.getElementById('txt_contra_nueva').value;
    if(id.length==0|| con.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    $.ajax({
        "url":"../controller/usuario/controlador_modificar_usuario_contra.php",
        type:'POST',
        data:{
            id:id,
            con:con
        }
    }).done(function(resp){
        if(resp>0){
                Swal.fire("Mensaje de Confirmacion","Contraseña del usuario actualizada","success").then((value)=>{
                    tbl_usuario.ajax.reload();
                    $("#modal_contra").modal('hide');
                });
        }else{
            return Swal.fire("Mensaje de Error","No se completo la actualización","error");            
        }
    })
}

/*
    Cambia el estado (ACTIVO/INACTIVO) de un usuario:
        - Recibe ID, nuevo estado y nombre de usuario
        - Ajusta el texto de confirmación según el estado
        - Envía cambio al servidor via AJAX
        - Muestra confirmación con nombre de usuario
        - Recarga tabla después de actualizar
*/
function Modificar_Status_Usuario(id,status,user){
    let esta = status;
    if(esta=="INACTIVO"){
        esta="Desactivo";


    }
    $.ajax({
        "url":"../controller/usuario/controlador_modificar_usuario_status.php",
        type:'POST',
        data:{
            id:id,
            status:status
        }
    }).done(function(resp){
        if(resp>0){
                Swal.fire("Mensaje de Confirmacion","Se "+esta+" Con Exito El Usuario "+user,"success").then((value)=>{
                    tbl_usuario.ajax.reload();
                });
        }else{
            return Swal.fire("Mensaje de Error","No se completo la actualización","error");            
        }
    })
}

/*
    Carga lista de empleados para selects:
        - Obtiene datos via AJAX (ID y nombre)
        - Genera options para selects de registro y edición
        - Maneja caso cuando no hay empleados disponibles
*/
function Cargar_Select_Empleado(){
    $.ajax({
        "url":"../controller/usuario/controlador_cargar_select_empleado.php",
        type:'POST',
    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            let cadena = "";
            for (let i = 0; i < data.length; i++) {
                cadena+="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>";    
            }
            document.getElementById('select_empleado').innerHTML=cadena;
            document.getElementById('select_empleado_editar').innerHTML=cadena;
            

        }else{
            cadena+="<option value=''>No hay empleados disponibles</option>";
            document.getElementById('select_empleado').innerHTML=cadena;
            document.getElementById('select_empleado_editar').innerHTML=cadena;

        }

    })
}

/*
    Carga lista de áreas para selects:
        - Obtiene datos via AJAX (ID y nombre)
        - Genera options para selects de registro y edición
        - Maneja caso cuando no hay áreas disponibles
*/
function Cargar_Select_Area(){
    $.ajax({
        "url":"../controller/usuario/controlador_cargar_select_area.php",
        type:'POST',
    }).done(function(resp){
        let data = JSON.parse(resp);
        if(data.length>0){
            let cadena = "";
            for (let i = 0; i < data.length; i++) {
                cadena+="<option value='"+data[i][0]+"'>"+data[i][1]+"</option>";    
            }
            document.getElementById('select_area').innerHTML=cadena;
            document.getElementById('select_area_editar').innerHTML=cadena;


        }else{
            cadena+="<option value=''>No hay empleados disponibles</option>";
            document.getElementById('select_area').innerHTML=cadena;
            document.getElementById('select_area_editar').innerHTML=cadena;

        }

    })
}

////seguimiento tramite/

/*
    Consulta el seguimiento de un trámite:
        1. Valida que número de trámite y DNI no estén vacíos
        2. Realiza primera consulta AJAX para obtener datos básicos del trámite:
            - Muestra sección de resultados si hay datos
            - Actualiza título con número de trámite y nombre de solicitante
        3. Realiza segunda consulta AJAX para obtener el detalle completo:
            - Construye línea de tiempo interactiva con cada movimiento
            - Muestra: área origen/destino, estado, fecha y observaciones
        4. Maneja caso cuando no se encuentran resultados
        5. Oculta sección de resultados si la consulta no devuelve datos
*/
function Traer_Datos_Seguimiento(){
    let numero = document.getElementById('txt_numero').value;
    let dni    = document.getElementById('txt_dni').value;
    if(numero.length==0|| dni.length==0){
        return Swal.fire('Mensaje de Advertencia','Llene los campos vacios','warning');
    }
    $.ajax({
        "url":"../controller/usuario/controlador_traer_seguimiento.php",
        type:'POST',
        data:{
            numero:numero,
            dni:dni
        }
    }).done(function(resp){
        let data = JSON.parse(resp);
        var cadena="";
        if(data.length>0){
            document.getElementById("div_buscador").style.display = "block";
            document.getElementById("lbl_titulo").innerHTML="<b>Seguimiento del trámite "+ data[0][0] +" - "+data [0][2]+"</b>";
            cadena +='<div class="timeline">'+
            '<div class="time-label">'+
                '<span class="bg-red">'+data[0][3]+'</span>'+
            '</div>';
            /// AJAX PARA EL DETALLE DEL SEGUIMIENTO///
            $.ajax({
                "url":"../controller/usuario/controlador_traer_seguimiento_detalle.php",
                type:'POST',
                data:{
                    codigo:data[0][0]       
                }
            }).done(function(resp){
                let datadetalle = JSON.parse(resp);
                if(datadetalle.length>0){
                    for (let i = 0; i < datadetalle.length; i++) {
                        cadena+='<div>'+
                        '<i class="fas fa-envelope bg-blue"></i>'+
                        '<div class="timeline-item">'+
                        '<span class="time"><i class="fas fa-clock"></i>'+datadetalle[i][4]+'</span>'+
                        //'<h3 class="timeline-header">Documento derivado al área de '+datadetalle[i][2]+' - </b>Estado: '+datadetalle[i][5]+'</b></h3>'+
                        '<h3 class="timeline-header">'+datadetalle[i][2]+' derivo el trámite a '+datadetalle[i][3]+' - </b>Estado: '+datadetalle[i][6]+'</b></h3>'+
                        '<div class="timeline-body">'+datadetalle[i][5]+''+ 
                        '</div>'+
                        '</div>'+
                    '</div>'; 
                    }
                    cadena+='</div>';
                    document.getElementById("div_seguimiento").innerHTML=cadena;
                    
                }
        
            })
            /// 

        }else{
            document.getElementById("div_buscador").style.display = "none";
        }

    })
}