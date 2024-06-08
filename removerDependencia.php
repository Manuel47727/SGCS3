<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $servidor = 'localhost';
    $user = 'root';
    $ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
    mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

    if (isset($_GET['comp_id'])) {
        $comp_id = $_GET['comp_id'];
        $inserir_comp = "UPDATE componente SET COMP_COMP_ID = NULL WHERE COMP_ID = '$comp_id'";

        if ($ligacao->query($inserir_comp) === TRUE) {
            $_SESSION['status'] = 'Dependecia Removida';
        } else {
            $_SESSION['status'] = "Error: " . $inserir_comp->error;
        }
    } else {
        $_SESSION['status'] = "Error: Component ID not provided";
    }

    header("Location: components.php");
?>
