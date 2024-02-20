<?php
    
    session_start();
    $datos = array(
        'idReporte' => $_POST['idReporte2'],
        'calificacion' => $_POST['satisfaction']
    );

    include "../../clases/Reportes.php";
    $Reportes = new Reportes();
    echo $Reportes->agregarSatisfaccion($datos);