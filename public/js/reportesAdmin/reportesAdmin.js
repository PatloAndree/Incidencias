$(document).ready(function(){
    $('#tablaReporteAdminLoad').load('reportesAdmin/tablaReportesAdmin.php');
});

function eliminarReporteAdmin(idReporte) {
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

function obtenerDatosSolucion(idReporte) {
    $.ajax({
        type:"POST",
        data:"idReporte=" + idReporte,
        url:"../procesos/reportesAdmin/obtenerSolucion.php",
        success:function(respuesta) {
            respuesta = jQuery.parseJSON(respuesta);
            $('#idReporte').val(respuesta['idReporte']);
            $('#solucion').val(respuesta['solucion']);
            $('#estatus').val(respuesta['estatus']);
            $('#fotoPreview').val(respuesta['foto_incidencia']);


            if (respuesta['foto_incidencia'] === null) {
                $( "#fotoPreview" ).attr({
                    src: "../uploads/sin.jpg",
                });
            } else {
                if (!/\.jpg$|\.png$/i.test(respuesta['foto_incidencia'])) {
                    $( "#fotoPreview" ).attr({
                        src: "../uploads/sin.jpg",
                    });
                } else {
                    $( "#fotoPreview" ).attr({
                        src: respuesta['foto_incidencia'],
                    });
                }
            }
        }
    });
}

function agregarSolucionReporte() {
    $.ajax({
        type:"POST",
        data:$('#frmAgregarSolucionReporte').serialize(),
        url:"../procesos/reportesAdmin/actualizarSolucion.php",
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

function previewImage2(event, querySelector){
    const input = event.target;
    $imgPreviewEdit = document.querySelector(querySelector);
    if(!input.files.length) return
    file = input.files[0];
    objectURL = URL.createObjectURL(file);
    $imgPreviewEdit.src = objectURL;
            
}

