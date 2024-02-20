
<!-- Modal -->
<form id="frmActualizarReporte" method="POST" onsubmit="return agregarSolucionReporte()" enctype="multipart/form-data">
    <div class="modal fade" id="modalActualizarReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                        <label for="idEquipo">Mis dispositivos</label>

                        <?php
                            $idUsuario = $_SESSION['usuario']['id'];
                            $sql = "SELECT 
                                        asignacion.id_asignacion as idAsignacion,
                                        equipo.id_equipo as idEquipo,
                                        equipo.nombre as nombreEquipo
                                    FROM
                                        t_asignacion AS asignacion
                                            INNER JOIN
                                        t_cat_equipo AS equipo ON asignacion.id_equipo = equipo.id_equipo
                                    WHERE
                                        asignacion.id_persona = (SELECT 
                                                                    id_persona
                                                                FROM
                                                                    t_usuarios
                                                                WHERE
                                                                    id_usuario = '$idUsuario')";
                            $respuesta = mysqli_query($conexion, $sql);
                        ?>
                        <input type="text" class="d-none" name="idReporte" id="idReporte">

                        <select name="idEquipo" id="idEquipo" class="form-control" required>
                            <option value="">Selecciona un dispositivo</option>
                            <?php while($mostrar = mysqli_fetch_array($respuesta)) { ?>
                                    <option value="<?php echo $mostrar['idEquipo']?>"> <?php echo $mostrar['nombreEquipo']; ?></option>
                            <?php }?>
                        </select>

                        <label for="dad">Describe tu problema</label>
                        <textarea name="res_problema" id="res_problema" class="form-control" required></textarea>

                       
                        <div class="col-span-12 col-span-12">
                            <label class="form-label" for="categoria_producto">Imagen</label>
                            
                            <input type="file" class="form-control"  id="foto_incidencia" name="foto_incidencia"   onchange="previewImage2(event, '#imgPreview1')">
                        </div>

                        <div class="col-span-12 mt-2" id="foto_bd">
                            <img id="imgPreview1" name="imgPreview1"   style="max-width:150px;border-radius:15px" > 
                        </div>

                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary">Actualizar</button>
                
                </div>
            </div>
        </div>
    </div>
</form>