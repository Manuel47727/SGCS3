<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
    header("Location: nopermission.php");
    exit;
}

if (!isset($_GET['id'])) {
    $_SESSION['status'] = 'No backup ID provided.';
    header("Location: settings.php");
    exit;
}

$backupId = $_GET['id'];
$database = 'sgcsDB';
$user = 'root';
$host = 'localhost';

// Change because of operating system (find fix)
$mysqlPath = '/Applications/XAMPP/xamppfiles/bin/mysql';

$ligacao = mysqli_connect($host, $user) or die('Sem ligação');
mysqli_select_db($ligacao, $database) or die('Sem tabela');

$sql = "SELECT file_content FROM backups WHERE id = '$backupId'";
$result = mysqli_query($ligacao, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $backupContent = $row['file_content'];

    $command = "{$mysqlPath} --user={$user} --host={$host} {$database}";
    $process = popen($command, 'w');
    fwrite($process, $backupContent);
    pclose($process);

    $_SESSION['status'] = 'Database restored successfully.';
} else {
    $_SESSION['status'] = 'Backup not found.';
}

mysqli_close($ligacao);

header("Location: settings.php");
exit;
?>
