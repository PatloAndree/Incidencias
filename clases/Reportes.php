<?php
    include "Conexion.php";
    
    class Reportes extends Conexion {
        
        // El original
        // public function agregarReporteCliente($datos) {
        //     $conexion = parent::conectar();
        //     $sql = "INSERT INTO t_reportes (id_usuario,
        //                                     id_equipo,
        //                                     descripcion_problema) 
        //             VALUES (?, ?, ?)";
        //     $query = $conexion->prepare($sql);
        //     $query->bind_param('iis', $datos['idUsuario'],
        //                                 $datos['idEquipo'],
        //                                 $datos['problema']);
        //     $respuesta = $query->execute();
        //     $query->close();
        //     return $respuesta;
        // }

        // El que hice
        public function agregarReporteCliente($datos) {
            $conexion = parent::conectar();
            $fotoIncidencia = isset($datos['foto_incidencia']) ? $datos['foto_incidencia'] : null;
            $sql = "INSERT INTO t_reportes (id_usuario, id_equipo, descripcion_problema, ruta_imagen) 
                    VALUES (?, ?, ?, ?)";
            $query = $conexion->prepare($sql);
        
            if ($fotoIncidencia) {
                $query->bind_param('iiss', $datos['idUsuario'], $datos['idEquipo'], $datos['problema'], $fotoIncidencia);
            } else {
                $query->bind_param('iis', $datos['idUsuario'], $datos['idEquipo'], $datos['problema']);
            }
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }
        
        public function eliminarReporteCliente($idReporte) {
            $conexion = parent::conectar();
            $sql = "DELETE FROM t_reportes WHERE id_reporte = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('i', $idReporte);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function obtenerSolucion($idReporte) {
            $conexion = parent::conectar();
            $sql = "SELECT solucion_problema, 
                            estatus,
                            ruta_imagen
                    FROM t_reportes 
                    WHERE id_reporte = '$idReporte'";
            $respuesta = mysqli_query($conexion, $sql);
            $reporte = mysqli_fetch_array($respuesta);

            $datos = array(
                "idReporte" => $idReporte,
                "estatus" => $reporte['estatus'],
                "solucion" => $reporte['solucion_problema'],
                "foto_incidencia" => $reporte['ruta_imagen'],

            );

            return $datos;
        }

        public function obtenerSolucionUsuario($idReporte) {
          
            $conexion = parent::conectar();
            $sql = "SELECT solucion_problema, 
                           descripcion_problema,
                           ruta_imagen,
                           id_equipo,
                            estatus,
                            calificacion,
                            id_reporte
                    FROM t_reportes 
                    WHERE id_reporte = '$idReporte'";
            $respuesta = mysqli_query($conexion, $sql);
            $reporte = mysqli_fetch_array($respuesta);

            $datos = array(
                "idReporte" => $reporte['id_reporte'],
                "estatus" => $reporte['estatus'],
                "solucion" => $reporte['solucion_problema'],
                "descripcion" => $reporte['descripcion_problema'],
                "foto_incidencia" => $reporte['ruta_imagen'],
                "id_equipo" => $reporte['id_equipo'],
                "satisfac" => $reporte['calificacion'],
                "solucion" => $reporte['solucion_problema'],
            );

            return $datos;
        }

        // El original
        public function actualizarSolucion($datos) {
            $conexion = parent::conectar();
            $sql = "UPDATE t_reportes 
                    SET id_usuario_tecnico = ?,
                        solucion_problema = ?,
                        estatus = ? 
                    WHERE id_reporte = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('isii', $datos['idUsuario'],
                                        $datos['solucion'],
                                        $datos['estatus'],
                                        $datos['idReporte']);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        public function agregarSatisfaccion($datos) {
            $conexion = parent::conectar();
            $sql = "UPDATE t_reportes 
                    SET calificacion = ?
                    WHERE id_reporte = ?";
            $query = $conexion->prepare($sql);
            $query->bind_param('ii', $datos['calificacion'], $datos['idReporte']);
            $respuesta = $query->execute();
            $query->close();
            return $respuesta;
        }

        // El que cambie
        public function actualizarSolucionCliente($datos) {
            $conexion = parent::conectar();
            
            $fotoIncidencia = isset($datos['foto_incidencia']) ? $datos['foto_incidencia'] : null;

            if ($fotoIncidencia) {
                $sql = "UPDATE t_reportes 
                SET id_usuario  = ?,
                    id_equipo   = ?,
                    descripcion_problema = ?,
                    ruta_imagen = ?
                WHERE id_reporte = ?";
                
            $query = $conexion->prepare($sql);

                $query->bind_param('isssi', $datos['idUsuario'],
                                            $datos['idEquipo'],
                                            $datos['problema'],
                                            $fotoIncidencia,
                                            $datos['idReporte']);

            $respuesta = $query->execute();
            $query->close();
            return $respuesta;

            } else {

                $sql2 = "UPDATE t_reportes 
                SET id_usuario  = ?,
                    id_equipo   = ?,
                    descripcion_problema = ?
                WHERE id_reporte = ?";
                
                $query2 = $conexion->prepare($sql2);

                $query2->bind_param('iisi', $datos['idUsuario'],
                                            $datos['idEquipo'],
                                            $datos['problema'],
                                            $datos['idReporte']);

                $respuesta2 = $query2->execute();
                $query2->close();
                return $respuesta2;
            }
            
            
        }
            
    }