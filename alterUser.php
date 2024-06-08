<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $servidor = 'localhost';
    $user = 'root';
    $ligacao = mysqli_connect($servidor,$user) or die('Sem ligação');
    mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');

    
    if ($_POST['userChange'] == -1) {
        echo "User não Existe";
    } else {

        $inserir_user = "UPDATE users SET ";

        if (isset($_POST['nameChange']) && isset($_POST['username'])) {
            $inserir_user .= "user_name = '" . $_POST['username'] . "', ";
        }

        if (isset($_POST['passwordChange']) && isset($_POST['password'])) {
            $inserir_user .= "user_password = '" . md5($_POST['password']) . "', ";
        }

        if (isset($_POST['typeChange']) && isset($_POST['type'])) {
            $inserir_user .= "user_type = '" . $_POST['type'] . "', ";
        }

        if (isset($_POST['isDeactivated'])) {
            $inserir_user .= "user_isDeactivated = '1', ";
        } else {
            $inserir_user .= "user_isDeactivated = '0', ";
        }

        $inserir_user = rtrim($inserir_user, ", ");

        $inserir_user .= " WHERE user_id = '" . $_POST['userChange'] . "'";

        if ($ligacao->query($inserir_user) === TRUE) {
            $_SESSION['status'] = 'User Details Successfully Altered';
        } else {
            $_SESSION['status'] = "Error: " . $inserir_user->error;
        }
    }

    header("Location: adminpage.php");

?>