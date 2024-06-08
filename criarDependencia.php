<?php
    session_start();


    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $servidor = 'localhost';
    $user = 'root';
    $ligacao = mysqli_connect($servidor,$user) or die('Sem ligação');
    mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');

    $inserir_comp = ("UPDATE componente SET COMP_COMP_ID = '".$_POST['componente_pai']."' WHERE COMP_ID = '".$_POST['componente_filho']."'");

    if ($ligacao->query($inserir_comp) === TRUE) {
        $_SESSION['status'] = 'Dependecia Definida';
    } else {
        $_SESSION['status'] = "Error: " . $inserir_comp->error;
    }

    header("Location: components.php");
?>
