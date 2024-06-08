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
    $sql = "SELECT filename, file_content FROM backups WHERE id = $id";
    $result = mysqli_query($ligacao, $sql);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $filename = $row['filename'];
        $fileContent = $row['file_content'];

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filename));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($fileContent));
        echo $fileContent;
        exit;
    } else {
        echo "Backup not found.";
    }
} else {
    echo "Invalid request.";
}

mysqli_close($ligacao);

?>
