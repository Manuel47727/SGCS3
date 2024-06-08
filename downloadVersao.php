<?php
session_start();

if ($_SESSION['usertype'] != 'admin') {
    header("Location: nopermission.php");
    exit;
}

$servidor = 'localhost';
$user = 'root';
$database = 'sgcsDB';
$ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
mysqli_select_db($ligacao, $database) or die('Sem tabela');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT VER_FILE, VER_VERSAO FROM versao WHERE VER_ID = $id";
    $result = mysqli_query($ligacao, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $fileName = $row['VER_VERSAO'];
        $fileContent = $row['VER_FILE'];

        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $mimeType = mime_content_type($fileName);
        header("Content-Type: " . $mimeType);
        header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
        header("Content-Length: " . strlen($fileContent));

        echo $fileContent;
        exit;
    } else {
        echo "File not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($ligacao);
?>