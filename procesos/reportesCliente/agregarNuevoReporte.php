<?php
    session_start();
    $idUsuario = $_SESSION['usuario']['id'];
    // $datos = array(
    //     'idEquipo' => $_POST['idEquipo'],
    //     'problema' => $_POST['problema'],
    //     'foto_incidencia'=>$_FILES['foto_incidencia'],
    //     'idUsuario' => $idUsuario
    // );

    // include "../../clases/Reportes.php";

    // $Reportes = new Reportes();

    // echo $Reportes->agregarReporteCliente($datos);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $idUsuario = $_SESSION['usuario']['id'];
    
        if (isset($_POST['idEquipo'], $_POST['problema']) && !empty($_FILES['foto_incidencia'])) {
            // Process other form fields
            $idEquipo = $_POST['idEquipo'];
            $problema = $_POST['problema'];
            $file_tmp = $_FILES['foto_incidencia']['tmp_name'];
            $file_name = $_FILES['foto_incidencia']['name'];
            $target_dir = "../../uploads/";
            $target_file = $target_dir . $file_name;
            $target_file_cleaned = substr($target_file, 3);
            if (move_uploaded_file($file_tmp, $target_file)) {
                $datos = array(
                    'idEquipo' => $idEquipo,
                    'problema' => $problema,
                    'foto_incidencia' => $target_file_cleaned,
                    'idUsuario' => $idUsuario
                );
    
                include "../../clases/Reportes.php";
    
                $Reportes = new Reportes();
    
                echo $Reportes->agregarReporteCliente($datos);
            } else {
                // Error uploading file
                $datos = array(
                    'idEquipo' => $idEquipo,
                    'problema' => $problema,
                    'foto_incidencia' => $target_file,
                    'idUsuario' => $idUsuario
                );
    
                include "../../clases/Reportes.php";
    
                $Reportes = new Reportes();
    
                echo $Reportes->agregarReporteCliente($datos);
            }
        } else {
            // Required fields not set
            echo "Missing required fields.";
        }
    }

    ?>



    