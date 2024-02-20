$(document).ready(function(){
    $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
});

// function agregarNuevoReporte() {

//     $.ajax({
//         type:"POST",
//         data:$('#frmNuevoReporte').serialize(),
//         url:"../procesos/reportesCliente/agregarNuevoReporte.php",
//         success:function(respuesta) {
//             respuesta = respuesta.trim();
//             if (respuesta == 1) {
//                 $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
//                 $('#frmNuevoReporte')[0].reset();
//                 Swal.fire(":D","Agregado con exito!","success");
//             } else {
//                 Swal.fire(":(","Error al agregar! " + respuesta, "error");
//             }
//         }
//     });

//     return false;
// }

function agregarNuevoReporte() {
    var formData = new FormData($('#frmNuevoReporte')[0]);
    $.ajax({
        type: "POST",
        data: formData,
        contentType: false, 
        processData: false, 
        url: "../procesos/reportesCliente/agregarNuevoReporte.php",
        success: function (respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
                $('#frmNuevoReporte')[0].reset();
                Swal.fire(":D", "Agregado con éxito!", "success");
            } else {
                Swal.fire(":(", "Error al agregar! " + respuesta, "error");
            }
        }
    });

    return false;
}

function calificarReporte() {
    $("#modalSatisfaction").modal('show');
    console.log("holaaaaaaaaa")

}

function agregarSolucionReporte() {
    var formData = new FormData($('#frmActualizarReporte')[0]);
    $.ajax({
        type: "POST",
        data: formData,
        contentType: false, 
        processData: false, 
        url:"../procesos/reportesCliente/actualizarSolucion.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
                $('#frmNuevoReporte')[0].reset();
                $("#modalActualizarReporte").modal('hide');
                Swal.fire({
                    title: ':D',
                    text: 'Actualizado con éxito!',
                    icon: 'success',
                    showConfirmButton: false  
                  });
                  setTimeout(() => {
                    Swal.close();
                  }, 1000);
            } else {
                Swal.fire(":(","Fallo!" + respuesta, "error");
            }
        }
    });

    return false;
}

function agregarSatisfaccion() {
    $.ajax({
        type:"POST",
        data:$('#frmCalificarSt').serialize(),
        url:"../procesos/reportesCliente/agregarSatisfaccion.php",
        success:function(respuesta) {
            respuesta = respuesta.trim();
            if (respuesta == 1) {
                Swal.fire(":D","Agregado con exito!", "success");
                $('#tablaReporteAdminLoad').load('reportesAdmin/tablaReportesAdmin.php');
            } else {
                Swal.fire(":(","Fallo!" + respuesta, "error");
            }
        }
    });
    return false;
}

function eliminarReporteCliente(idReporte) {
    Swal.fire({
        title: 'Estas seguro de eliminar este registro?',
        text: "Una vez eliminado no podra ser recuperado!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type:"POST",
                data:"idReporte=" + idReporte,
                url:"../procesos/reportesCliente/eliminarReporteCliente.php",
                success:function(respuesta) {
                    if (respuesta == 1) {
                        $('#tablaReporteClienteLoad').load('reportesCliente/tablaReporteCliente.php');
                        Swal.fire(":D","Eliminado con exito!","success");
                    } else {
                        Swal.fire(":(","Fallo al eliminar!" + respuesta, "error");
                    }
                }
            });
        }
    })
    return false;
}

function obtenerDatosReporte(idUsuario) {
    $.ajax({
        type: "POST",
        data: "idUsuario=" + idUsuario,
        url: "../procesos/usuarios/crud/obtenerDatosUsuario.php",
        success:function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);
            $('#idUsuario').val(respuesta['idUsuario']);
            $('#paternou').val(respuesta['paterno']);
            $('#maternou').val(respuesta['materno']);
            $('#nombreu').val(respuesta['nombrePersona']);
            $('#fechaNacimientou').val(respuesta['fechaNacimiento']);
            $('#sexou').val(respuesta['sexo']);
            $('#telefonou').val(respuesta['telefono']);
            $('#correou').val(respuesta['correo']);
            $('#usuariou').val(respuesta['nombreUsuario']);
            $('#idRolu').val(respuesta['idRol']);
            $('#ubicacionu').val(respuesta['ubicacion']);
        }
    });
}

function obtenerDatosSolucion(idReporte) {
    $.ajax({
        type:"POST",
        data:"idReporte=" + idReporte,
        url:"../procesos/reportesCliente/obtenerSolucionCliente.php",
        success:function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);
            $('#idReporte').val(respuesta['idReporte']);
            $('#idReporte2').val(respuesta['idReporte']);
            $('#solucion').val(respuesta['solucion']);
            $('#res_problema').val(respuesta['descripcion']);
            console.log(respuesta['foto_incidencia'] );
            if (respuesta['foto_incidencia'] === null) {
                $( "#imgPreview1" ).attr({
                    src: "../uploads/sin.jpg",
                });     
            } else {
                if (!/\.jpg$|\.png$/i.test(respuesta['foto_incidencia'])) {
                    $( "#imgPreview1" ).attr({
                        src: "../uploads/sin.jpg",
                    });
                } else {
                    $( "#imgPreview1" ).attr({
                        src: respuesta['foto_incidencia'],
                    });
                }
            }
            
            var idEquipo = respuesta['id_equipo'];
            $("#idEquipo option").each(function() {
                if ($(this).val() == idEquipo) {
                    $(this).prop("selected", true);
                }
            });
            var satisfaccion = respuesta['satisfac'];
            if(satisfaccion != null){
                $("#satisfecho").val(satisfaccion);
            }else{
                $("#satisfecho").val(0);

            }

            equipoId = respuesta['id_equipo'];
            $('#estatus').val(respuesta['estatus']);
        }
    });
}

function previewImage(event, querySelector){
    const input = event.target;
    $imgPreviewEdit = document.querySelector(querySelector);
    if(!input.files.length) return
    file = input.files[0];
    objectURL = URL.createObjectURL(file);
    $imgPreviewEdit.src = objectURL;
            
}

function previewImage2(event, querySelector){
    const input = event.target;
    $imgPreviewEdit = document.querySelector(querySelector);
    if(!input.files.length) return
    file = input.files[0];
    objectURL = URL.createObjectURL(file);
    $imgPreviewEdit.src = objectURL;
            
}

