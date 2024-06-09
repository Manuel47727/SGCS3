<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servidor = 'localhost';
$user = 'root';
$ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file_tmp = $_FILES["file"]["tmp_name"];
    $file_name = basename($_FILES["file"]["name"]);

    $inserir_componente = "INSERT INTO componente(COMP_NOME, COMP_DESC, COMP_DATE, COMP_user_id) VALUES('" . $_POST['componente_nome'] . "','" . $_POST['description'] . "','" . date('Y/m/d H:i:s') . "','" . $_SESSION["userid"] . "')";

    if ($ligacao->query($inserir_componente) === TRUE) {
        $_SESSION['status'] = 'Componente Adicionada';

        $componente_id = $ligacao->insert_id;

        $versionNumber = $_POST['versao'];
        $createdAt = date('Y-m-d H:i:s');

        $file_content = file_get_contents($file_tmp, FILE_BINARY);

        $inserir_versao = "INSERT INTO versao (VER_VERSAO, VER_DATA, VER_FILE, VER_COMP_ID) VALUES (?, ?, ?, ?)";

        $stmt = $ligacao->prepare($inserir_versao);
        if ($stmt) {
            $null = null;
            $stmt->bind_param("ssbs", $versionNumber, $createdAt, $null, $componente_id);


            $stmt->send_long_data(2, $file_content);

            $stmt->execute();
            $stmt->close();
        }

        } else {
            $_SESSION['status'] = "Error: " . $inserir_comp->error;
        }
    }

header("Location: components.php");
?>