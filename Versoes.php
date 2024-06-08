<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class="container mt-3">
    <?php 
        session_start();
        if ($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
            header("Location: nopermission.php");
        }
    ?>
    <h1>SGCS</h1>
    <nav class="mb-5">
        <a href="index.php" type="button">
            <button>Home</button>
        </a>
        <a href="components.php" type="button">
            <button>Components</button>
        </a>
        <a href="settings.php" type="button">
            <button>Settings</button>
        </a>
        <?php 
            if ($_SESSION["usertype"] == 'admin') {
                echo '<a href="adminpage.php" type="button">
                        <button>Admin</button>
                    </a>';
            }
        ?>
        <a href="login.php" type="button">
            <button>Log Out</button>
        </a>
    </nav>

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
                        <input type="text" name="versao" placeholder="Versão" class="mb-4" style="width: 10rem;"> <br>
                        <label>Select File:</label><br>
                        <input type="file" name="file" class="mt-2 mb-4"> <br>
                        <button type="submit" class="mb-3">Criar Nova Versao</button>
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
            echo "<table style='border: 1px solid; border-collapse: separate; border-spacing: 50px 0; margin-bottom:3rem; margin-top:3rem;'>";
            echo "<tr><th>ID Versao</th><th>Created At</th><th>Download</th></tr>";
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