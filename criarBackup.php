<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = 'sgcsDB';
$user = 'root';
$host = 'localhost';

$backupDir = dirname(__FILE__) . '/backups/';
$backupFile = $backupDir . 'DatabaseBackup_' . date('Y-m-d_H-i-s') . '.sql';

echo "<h3>Backing up database to `<code>{$backupFile}</code>`</h3>";

if (!file_exists($backupDir)) {
    if (!mkdir($backupDir, 0777, true)) {
        die('Failed to create backup directory.');
    }
}

// Change According to Operating System (need fix if available)
$mysqldumpPath = '/Applications/XAMPP/xamppfiles/bin/mysqldump';

exec("{$mysqldumpPath} --user={$user} --host={$host} {$database} --result-file={$backupFile} 2>&1", $output, $return_var);

if ($return_var === 0) {
    echo "<p>Backup completed successfully.</p>";

    $ligacao = mysqli_connect($host, $user) or die('Sem ligação');
    mysqli_select_db($ligacao, $database) or die('Sem tabela');

    $fileContent = file_get_contents($backupFile);
    if ($fileContent === false) {
        die('Failed to read backup file.');
    }

    $fileContentEscaped = mysqli_real_escape_string($ligacao, $fileContent);

    $createdAt = date('Y-m-d H:i:s');
    $sql = "INSERT INTO backups (filename, backup_date, file_content) VALUES ('" . basename($backupFile) . "', '$createdAt', '$fileContentEscaped')";

    if (mysqli_query($ligacao, $sql)) {
        $_SESSION['status'] = 'Backup criado com successo.';
    } else {
        $_SESSION['status'] = 'Error: ' . $sql . '<br>' . mysqli_error($ligacao);
    }

    mysqli_close($ligacao);
} else {
    echo "<p>Error creating backup:</p>";
    var_dump($output);
}

header("Location: settings.php");
?>t
