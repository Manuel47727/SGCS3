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
            margin-top: .5rem;
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
<body class="container" style = "margin-top: 5rem;">
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
    
    <div class="card p-4 mb-3 mt-5" style="width:20rem;">
        <h4>Mudar Idioma</h4>
        <select name="theme" id="" class="form-control" style = "max-width: 15rem;">
            <option value="english">English</option>
            <option value="portuguese">Portuguese</option>
        </select> <br>
        <a href="changeLang.php" class = "button-confirm-style" style = "width: 7rem; text-align: center;">Mudar</a>
    </div>

    <div class="card p-4" style="width:20rem; margin-bottom: 3rem;">
        <h4>Mudar Tema</h4>
        <select name="theme" id="" class="form-control" style = "max-width: 15rem;">
            <option value="light">Light</option>
            <option value="dark">Dark</option>
        </select> <br>
        <a href="changeTheme.php" class = "button-confirm-style" style = "width: 7rem; text-align: center;">Mudar</a>
    </div>

    <?php
        if ($_SESSION["usertype"] == 'admin') {
            echo '<div class = "card p-4"><div class="mt-5">
            <h4>Backups</h4>
            <a href="criarBackup.php" type="button" class="button-confirm-style" style = "margin: 1rem 0rem;">Criar Backup</a>
            </div>';
            $servidor = 'localhost';
            $user = 'root';
            $ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
            mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

            $sql = "SELECT * FROM backups ORDER BY backup_date DESC";
            $result = $ligacao->query($sql);

            if ($result->num_rows > 0) {
                echo "<table style='border: 1px solid; border-collapse: separate; border-spacing: 50px 0; margin-bottom:3rem;'>";
                echo "<tr><th>Nome do Ficheiro</th><th>Criado</th><th>Download</th><th>Repor</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['filename'] . "</td>";
                    echo "<td>" . $row['backup_date'] . "</td>";
                    echo "<td><a href='download.php?id=" . urlencode($row['id']) . "'>Download</a></td>";
                    echo "<td><a href='recoverBackup.php?id=" . urlencode($row['id']) . "'>Repor</a></td>";
                    echo "</tr>";
                }
                echo "</table> </div>";
            } else {
                echo "No backups found.";
            }

            $ligacao->close();
        }
    ?>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>
