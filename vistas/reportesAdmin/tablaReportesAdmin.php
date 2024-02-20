
<?php
    session_start();
    include "../../clases/Conexion.php";
    $con = new Conexion();
    $conexion = $con->conectar();
    $idUsuario = $_SESSION['usuario']['id'];
    $contador = 1;
    $sql = "SELECT 
                reporte.id_reporte AS idReporte,
                reporte.id_usuario AS idUsuario,
                CONCAT(persona.paterno,
                        ' ',
                        persona.materno,
                        ' ',
                        persona.nombre) AS nombrePersona,
                equipo.id_equipo AS idEquipo,
                equipo.nombre AS nombreEquipo,
                reporte.descripcion_problema AS problema,
                reporte.estatus AS estatus,
                reporte.calificacion AS calificacion,
                reporte.solucion_problema AS solucion,
                reporte.fecha AS fecha
            FROM
                t_reportes AS reporte
                    INNER JOIN
                t_usuarios AS usuario ON reporte.id_usuario = usuario.id_usuario
                    INNER JOIN
                t_persona AS persona ON usuario.id_persona = persona.id_persona
                    INNER JOIN
                t_cat_equipo AS equipo ON reporte.id_equipo = equipo.id_equipo 
                ORDER BY reporte.fecha DESC";
                
    $respuesta = mysqli_query($conexion, $sql);
?>

<table class="table table-sm table-bordered dt-responsive nowrap" 
        style="width:100%" id="tablaReportesAdminDataTable">
    <thead>
        <th>#</th>
        <th>Usuario</th>
        <th>Dispositivo</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Solución</th>
        <th>Calificación</th>

        <th>Acción</th>
    </thead>
    <tbody>
    <?php while($mostrar = mysqli_fetch_array($respuesta)) {  ?>
        <tr>
            <td> <?php echo $contador++; ?> </td>
            <td><?php echo $mostrar['nombrePersona'];?></td>
            <td class="text-center"><?php echo $mostrar['nombreEquipo'];?></td>
            <td><?php echo $mostrar['fecha'];?></td>
            <td><?php echo $mostrar['problema'];?></td>
            <td class="text-center">
                <?php
                    $estatus = $mostrar['estatus'];
                    $cadenaEstatus = '<span class="badge badge-danger text-center">Abierto</span>';
                    if ($estatus == 0) {
                        $cadenaEstatus = '<span class="badge badge-success text-center">Cerrado</span>';
                    }
                    echo $cadenaEstatus;
                ?>
            </td>
            <td>
              
                <?php
                    $solucion = $mostrar['solucion'];
                    if (strlen($solucion) > 30) {
                        echo substr($solucion, 0, 30) . '...';
                    } else {
                        echo $solucion;
                    }
                ?>
                
            </td>
            <td class="text-center">
              <?php 
                $calificacion = $mostrar['calificacion'];
              if ($calificacion == 5) {
                    echo 'Muy satisfecho';
                } elseif ($calificacion == 4) {
                    echo 'Satisfecho';
                } elseif ($calificacion == 3) {
                    echo 'Regular';
                } elseif ($calificacion == 2) {
                    echo 'Insatisfecho';
                } elseif ($calificacion == 1) {
                    echo 'Muy insatisfecho';
                } else {
                    echo '----'; // Otra calificación no contemplada
                }
              ?>
            </td>
            <td class="text-center">
                <?php
                    if ($mostrar['solucion'] == "") {
                ?>
                    <?php
                    }
                    ?>
                    <button class="btn btn-primary btn-sm" 
                    onclick="obtenerDatosSolucion('<?php echo $mostrar['idReporte'];?>')"
                    data-toggle="modal" data-target="#modalAgregarSolucionReporte">
                    <li class="fas fa-edit" style="font-size: 12px;" ></li>
                    </button>
                    <button class="btn btn-danger btn-sm" 
                        onclick="eliminarReporteAdmin(<?php echo $mostrar['idReporte'] ?>)">
                        <i class="fas fa-trash" style="font-size: 12px;"></i>
                    </button>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function(){
        $('#tablaReportesAdminDataTable').DataTable({
            language : {
                url : "../public/datatable/es_es.json"
            },
            dom: 'Bfrtip',
            buttons : {
                buttons : [
                    {   
                        extend : 'copy', 
                        className : 'btn btn-outline-info', 
                        text : '<i class="far fa-copy"></i> Copiar' 
                    },
                    {   
                        extend : 'csv', 
                        className : 'btn btn-outline-primary', 
                        text : '<li class="fas fa-file-csv"></li> CSV' 
                    },
                    {   
                        extend : 'excel', 
                        className : 'btn btn-outline-success', 
                        text : '<i class="fas fa-file-excel"></i> XLS' 
                    },
                    {   
                        extend : 'pdf', 
                        className : 'btn btn-outline-danger', 
                        text : '<i class="fas fa-file-pdf"></i> PDF' 
                    },
                ],
                dom : {
                    button : {
                        className : 'btn'
                    }
                }
            },
           
        });
    })
</script>

