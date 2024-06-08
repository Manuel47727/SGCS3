<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servidor = 'localhost';
$user = 'root';
$ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"]) && isset($_POST['versao']) && isset($_GET['comp_id'])) {
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_name = basename($_FILES["file"]["name"]);
    $component_id = $_GET['comp_id'];

    $versionNumber = $_POST['versao'];
    $createdAt = date('Y-m-d H:i:s');

    $file_content = file_get_contents($file_tmp);

    $inserir_versao = "INSERT INTO versao (VER_VERSAO, VER_DATA, VER_FILE, VER_COMP_ID) VALUES (?, ?, ?, ?)";

    $stmt = $ligacao->prepare($inserir_versao);
    if ($stmt) {
        $stmt->bind_param("sssi", $versionNumber, $createdAt, $file_content, $component_id);

        $stmt->execute()
        $stmt->close();
    }
}

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
?>
