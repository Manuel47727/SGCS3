<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<style>
    .button-style {
           border: 1px #0066ff solid;
           background-color: transparent;
           border-radius: 5px;
           outline: none;
           padding: 8px 20px;
           margin: 5px;
           cursor: pointer;
           text-decoration: none;
           color: #000;
           font-size: 16px;
           font-weight: bold;
           transition: all 0.3s ease;
        }

        .button-confirm-style {
            border: 1px #000 solid;
           background-color: transparent;
           border-radius: 5px;
           outline: none;
           padding: 8px 20px;
           margin-top: 1rem;
           cursor: pointer;
           text-decoration: none;
           color: #000;
           font-size: 16px;
           font-weight: bold;
           transition: all 0.3s ease;
        }

        .button-remove-style {
            border: 1px red solid;
           background-color: transparent;
           border-radius: 5px;
           outline: none;
           padding: 8px 20px;
            margin-top: 1rem;
            margin-bottom: 1rem;
           cursor: pointer;
           text-decoration: none;
           color: #000;
           font-size: 16px;
           font-weight: bold;
           transition: all 0.3s ease;
        }

        .button-confirm-style:hover {
            background-color: #0066ff;
            color: #fff;
            border-radius: 15px;
        }

        .card {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .button-style:hover {
            color: #0066ff;
        }
</style>
<body class="container" style = "margin-top: 5rem">
    <?php 
        session_start();
        if ($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
            header("Location: nopermission.php");
        }
    ?>
<img src="./img/sgcs_logo.png" alt="SGCS Logo" width = "150rem" style = "margin-right: 2rem;">


<a href="components.php" class="button-style">Components</a>

<a href="settings.php" class="button-style">Settings</a>

<?php 
    if ($_SESSION["usertype"] == 'admin') {
        echo '<a href="adminpage.php" class="button-style">Admin</a>';
    }
?>
<a href="login.php" class="button-style">Log Out</a>
    </nav>

    <?php
        if (isset($_SESSION['status'])) {
            echo '<div class="alert alert-info mt-4">' . $_SESSION['status'] . '</div>';
            unset($_SESSION['status']);
        }
    ?>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if(isset($_GET['comp_id'])) {
        $component_id = $_GET['comp_id'];

        echo '<div class="mt-5">
                <h4>Versoes</h4>
                <div class="card p-4">
                    <h4 class="mb-3">Criar Nova Versao</h4>
                    <form action="criarVersao.php?comp_id='. $component_id . '" method="POST" enctype="multipart/form-data">
                        <input type="text" name="versao" placeholder="Versão" class="mb-4 form-control" style = "max-width: 10rem;"> <br>
                        <label>Select File:</label><br>
                        <input type="file" name="file" class="mt-2 form-control" style = "max-width: 15rem;"> <br>
                        <button type="submit" class="button-confirm-style">Criar Nova Versao</button>
                    </form>
                </div>
            </div>';

        $servidor = 'localhost';
        $user = 'root';
        $ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
        mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

        $sql = "SELECT * FROM versao WHERE VER_COMP_ID = $component_id ORDER BY VER_DATA DESC";
        $result = $ligacao->query($sql);

        if ($result->num_rows > 0) {
            echo "<table style='border: 1px solid; border-collapse: separate; border-spacing: 50px 0; margin-bottom:3rem; text-align: center;margin-top:3rem;'>";
            echo "<tr><th>ID Versao</th><th>Criado</th><th>Download</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['VER_VERSAO'] . "</td>";
                echo "<td>" . $row['VER_DATA'] . "</td>";
                echo "<td><a href='downloadVersao.php?id=" . urlencode($row['VER_ID']) . "'>Download</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No versions found for this component.";
        }

        $ligacao->close();
    } else {
        echo "Component ID not provided.";
    }
    ?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>