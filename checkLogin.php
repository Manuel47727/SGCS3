<?php

    function getUserPassword($ligacao,$username){
        $consulta_user = "SELECT user_password FROM users WHERE user_name = '" . $username ."'";
        $resultado_user = mysqli_query($ligacao,$consulta_user);
        if($resultado_user->num_rows > 0){
            $row = $resultado_user->fetch_assoc();
            return $row["user_password"];
        } else {
            return -1;
        }
    }

    function getUserType($ligacao, $username) {
        $consulta_user = "SELECT user_type FROM users WHERE user_name = '" . $username ."'";
        $resultado_user = mysqli_query($ligacao,$consulta_user);
        if($resultado_user->num_rows > 0){
            $row = $resultado_user->fetch_assoc();
            return $row["user_type"];
        } else {
            return -1;
        }
    }

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

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    $servidor = 'localhost';
    $user = 'root';
    $ligacao = mysqli_connect($servidor,$user) or die('Sem ligação');
    mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');
    
    $user_password = getUserPassword($ligacao, $_POST['username']);
    
    if($user_password == md5($_POST['password'])){
        $_SESSION["usertype"] = getUserType($ligacao, $_POST['username']);
        $_SESSION["userid"] = getUserId($ligacao, $_POST['username']);
        header("Location: components.php");
    } else {

        $_SESSION['status'] = "Username or Password are incorrect";
        header("Location: login.php");
    }



?>