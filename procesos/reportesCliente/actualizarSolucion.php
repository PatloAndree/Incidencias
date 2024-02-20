<?php
    
    session_start();
    // $datos = array(
    //     'idReporte' => $_POST['idReporte'],
    //     'solucion' => $_POST['solucion'],
    //     'estatus' => $_POST['estatus'],
    //     'idUsuario' => $_SESSION['usuario']['id']
    // );
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUsuario = $_SESSION['usuario']['id'];
    
        if (isset($_POST['idEquipo'], $_POST['res_problema'])) {
            // Process other form fields
            $idEquipo = $_POST['idEquipo'];
            $problema = $_POST['res_problema'];
            $idReporte = $_POST['idReporte'];

            $file_tmp = $_FILES['foto_incidencia']['tmp_name'];
            $file_name = $_FILES['foto_incidencia']['name'];
            $target_dir = "../../uploads/";
            $target_file = $target_dir . $file_name;
            $target_file_cleaned = substr($target_file, 3);
            if (move_uploaded_file($file_tmp, $target_file)  && !empty($_FILES['foto_incidencia'])) {
                $datos = array(
                    'idEquipo' => $idEquipo,
                    'problema' => $problema,
                    'foto_incidencia' => $target_file_cleaned,
                    'idReporte'=> $idReporte,
                    'idUsuario' => $idUsuario
                );
    
                include "../../clases/Reportes.php";
    
                $Reportes = new Reportes();
    
                echo $Reportes->actualizarSolucionCliente($datos);
            } else {
                // Error uploading file
                $datos = array(
                    'idEquipo' => $idEquipo,
                    'problema' => $problema,
                    'foto_incidencia' => null,
                    'idReporte'=> $idReporte,
                    'idUsuario' => $idUsuario
                );
    
                include "../../clases/Reportes.php";
    
                $Reportes = new Reportes();
    
                echo $Reportes->actualizarSolucionCliente($datos);
            }
        } else {
            // Required fields not set
            echo "Archivos perdidos.";
        }
    }

    // include "../../clases/Reportes.php";
    // $Reportes = new Reportes();
    // echo $Reportes->actualizarSolucionCliente($datos);