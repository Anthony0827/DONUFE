<?php

$conn = new mysqli("localhost", "ud82yedebgzxn", "5f8efvpfqx28", "db9rbhnww73bde");

if (isset($_POST['data'])) {

    $data = json_decode(base64_decode($_POST['data']),true);
    extract($data,true);
    //var_dump($data,$_POST);
    //var_dump( "test",$idcandidato, $tipoRegistro, $tipoFlujo, $titulo, $texto);
    $stmt = $conn->prepare("INSERT INTO productividad(id, idcandidato, registro, flujo, fechabacklog, titulo, mensaje) VALUES (UUID(), ?, ?, ?, CURRENT_TIMESTAMP(), ?, ?)");
    $stmt->bind_param('issss', $idcandidato, $tipoRegistro, $tipoFlujo, $titulo, $texto);
    $stmt->execute();

    if ($stmt->affected_rows > 0)
        echo "CREADO";
    else
        echo "ERROR";   
}

 else if (isset($_POST['mover'])) {
    
    $sql = "";
    extract($_POST['mover'],true);

    if  ($flujo == 'BACKLOG')
        $sql ="UPDATE productividad SET FLUJO=?, fechabacklog=CURRENT_TIMESTAMP() WHERE id=? ";

    else if  ($flujo == 'PLANIFICADA')
        $sql ="UPDATE productividad SET FLUJO=?, fechaplanificada=CURRENT_TIMESTAMP() WHERE id=?";

    else if  ($flujo == 'EN_PROGRESO')
        $sql ="UPDATE productividad SET FLUJO=?, fechaprogreso=CURRENT_TIMESTAMP() WHERE id=?";

    else if  ($flujo == 'BLOQUEO')
        $sql ="UPDATE productividad SET FLUJO=?, fechabloqueo=CURRENT_TIMESTAMP() WHERE id=?";

    else if  ($flujo == 'TERMINADA')
        $sql ="UPDATE productividad SET FLUJO=?, fechaterminada=CURRENT_TIMESTAMP() WHERE id=?";

    $stmt = $conn->prepare($sql);
    var_dump($sql);
    $stmt->bind_param('ss',$flujo,$id);
    $stmt->execute();

    if ($stmt->affected_rows > 0)
        echo "ACTUALIZADO";
    else
        echo "ERROR";
}
else if (isset($_GET['data'])) {
    $data = json_decode(base64_decode($_GET['data']),true);
    extract($data);
    $datos = null;

    if ($tipo == "TODOS") {
        $stmt = $conn->prepare("SELECT * FROM productividad WHERE idcandidato = ? ORDER BY flujo");
        $stmt->bind_param('i',$idcandidato);
    }
    else {
        $stmt = $conn->prepare("SELECT * FROM productividad WHERE idcandidato = ? AND flujo = ?");
        $stmt->bind_param('is',$idcandidato,$tipo);
    }
    $stmt->execute();
   
    $datos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($datos);
}
else if (isset($_GET['tablero'])) {
    $data = json_decode(base64_decode($_GET['tablero']),true);
    extract($data);
    
    $stmt = $conn->prepare("SELECT * FROM productividad WHERE idcandidato = ?");// ORDER BY fecha asc");
    $stmt->bind_param('i',$idcandidato);
    $stmt->execute();
    $datos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode($datos);
}
?>