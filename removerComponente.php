<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if (isset($_GET['comp_id'])) {
    $componentId = $_GET['comp_id'];

    $servidor = 'localhost';
    $user = 'root';
    $ligacao = new mysqli($servidor, $user) or die('Sem Ligacao');
    mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

    $queryVersao = "DELETE FROM versao WHERE VER_COMP_ID = ?";
    $stmtVersao = $ligacao->prepare($queryVersao);
    $stmtVersao->bind_param('i', $componentId);
    $stmtVersao->execute();

    $queryChildComponents = "DELETE FROM componente WHERE COMP_COMP_ID = ?";
    $stmtChildComponents = $ligacao->prepare($queryChildComponents);
    $stmtChildComponents->bind_param('i', $componentId);
    $stmtChildComponents->execute();

    $queryComponente = "DELETE FROM componente WHERE COMP_ID = ?";
    $stmtComponente = $ligacao->prepare($queryComponente);
    $stmtComponente->bind_param('i', $componentId);
    $stmtComponente->execute();

    $_SESSION['status'] = 'Componente removido com sucesso.';

    $ligacao->close();
}

header("Location: components.php");
exit;
?>
