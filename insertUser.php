<?php
    session_start();
    
    function getUserId($ligacao,$username){
        $consulta_user = "SELECT user_id FROM users WHERE user_name = '" . $username ."'";
        $resultado_user = mysqli_query($ligacao,$consulta_user);
        if($resultado_user->num_rows > 0){
            $row = $resultado_user->fetch_assoc();
            return $row["user_id"];
        } else {
            return -1;
        }
    }


    $servidor = 'localhost';
        $user = 'root';
        $ligacao = mysqli_connect($servidor,$user) or die('Sem ligação');
        mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');
        
        $un_id = getUserId($ligacao, $_POST['username']);
        
        if($un_id != -1){
            echo "User ja existente";
        } else {

            $inserir_user = "INSERT INTO users(user_name, user_password, user_type, user_isDeactivated) VALUES('".$_POST['username']."','".md5($_POST['password'])."','".$_POST['type']."','".'0'."')";
            if ($ligacao->query($inserir_user) === TRUE) {
                $_SESSION['status'] = 'Utilizador Inserido com sucesso';
            } else {
                $_SESSION['status'] = "Error: " . $inserir_user->error;
            }
        }

        header("Location: adminpage.php");

?>