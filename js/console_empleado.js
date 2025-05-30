var  tbl_empleado;
function Listar_Empleado(){
    tbl_empleado = $("#tabla_empleado").DataTable({
        "ordering":false,   
        "bLengthChange":true,
        "searching": { "regex": false },
        "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        "pageLength": 10,
        "destroy":true,
        "async": false ,
        "processing": true,
        "ajax":{
            "url":"../controller/empleado/controlador_listar_empleado.php",
            type:'POST'
        },
        "columns":[
            {"defaultContent":""},
            {"data":"emple_nrodocumento"},
            {"data":"em"},
            {"data":"emple_cel"},
            {"data":"emple_email"},
            {"data":"emple_status",
                render: function(data,type,row){
                        if(data=='ACTIVO'){
                        return '<span class="badge bg-success">ACTIVO</span>';
                        }else{
                        return '<span class="badge bg-danger">INACTIVO</span>';
                        }
                }   
            },
            {"defaultContent":"<button class='editar btn btn-primary'><i class='fa fa-edit'></i></button>"},
            
        ],
  
        "language":idioma_espanol,
        select: true
    });
    tbl_empleado.on('draw.td',function(){
      var PageInfo = $("#tabla_empleado").DataTable().page.info();
      tbl_empleado.column(0, {page: 'current'}).nodes().each(function(cell, i){
        cell.innerHTML = i + 1 + PageInfo.start;
      });
    });
}

$('#tabla_empleado').on('click','.editar',function(){
    var data = tbl_empleado.row($(this).parents('tr')).data();//En tamaño escritorio
    if(tbl_empleado.row(this).child.isShown()){
        var data = tbl_empleado.row(this).data();
    }//Permite llevar los datos cuando es tamaño celular y usas el responsive de datatable
    $("#modal_editar").modal('show');
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


function AbrirRegistro(){
    $("#modal_registro").modal({backdrop:'static',keyboard:false})
    $("#modal_registro").modal('show');
}

function Registrar_Empleado(){
    let nro = document.getElementById('txt_nro').value;
    let nom = document.getElementById('txt_nom').value;
    let apepa = document.getElementById('txt_apepa').value;
    let apema = document.getElementById('txt_apema').value;
    let fnac = document.getElementById('txt_fnac').value;
    let cel = document.getElementById('txt_cel').value;
    let dire = document.getElementById('txt_dire').value;
    let email = document.getElementById('txt_email').value;

    if(nro.length==0 || nom.length==0 || apepa.length==0 || apema.length==0 || fnac.length==0 || cel.length==0 || dire.length==0 || email.length==0){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

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
                Swal.fire("Mensaje de Confirmacion","Nuevo Empleado Registrado","success").then((value)=>{
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
                Swal.fire("Mensaje de Advertencia","El empleado ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            return Swal.fire("Mensaje de Error","No se completo el registro","error");            
        }
    })
}

function Modificar_Empleado(){
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
    if(id.length==0  || esta.length==0 || nro.length==0 || nom.length==0  || apepa.length==0  || apema.length==0  || fnac.length==0  || cel.length==0  || dire.length==0  || email.length==0 ){
        return Swal.fire("Mensaje de Advertencia","Tiene campos vacios","warning");
    }

    if(validar_email(email)){

    }else{
        return Swal.fire("Mensaje de Advertencia","El formato de email es incorrecto","warning");
    }
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
                Swal.fire("Mensaje de Confirmacion","Datos del Empleado Actualizados","success").then((value)=>{
                    tbl_empleado.ajax.reload();
                    $("#modal_editar").modal('hide');
                });
            }else{
                Swal.fire("Mensaje de Advertencia","El Nro documento ingresado ya se encuentra en la base de datos","warning");
            }
        }else{
            return Swal.fire("Mensaje de Error","No se completo el proceso","error");            
        }
    })
}

function validar_email(email) {
    let regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email) ? true : false;
}

