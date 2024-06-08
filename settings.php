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
        if (isset($_SESSION['status'])) {
            echo '<div class="alert alert-info mt-4">' . $_SESSION['status'] . '</div>';
            unset($_SESSION['status']);
        }
    ?>
    
    <div class="card p-4 mb-3" style="width:20rem;">
        <h4>Change Language</h4>
        <select name="theme" id="" class="mb-2" style="width:10rem;">
            <option value="english">English</option>
            <option value="portuguese">Portuguese</option>
        </select> <br>
        <a href="changeTheme.php" type="button">
                <button>Change</button>
        </a>
    </div>

    <div class="card p-4" style="width:20rem;">
        <h4>Change Theme</h4>
        <select name="theme" id="" class="mb-2" style="width:10rem;">
            <option value="light">Light</option>
            <option value="dark">Dark</option>
        </select> <br>
        <a href="changeTheme.php" type="button">
                <button>Change</button>
        </a>
    </div>

    <?php
        if ($_SESSION["usertype"] == 'admin') {
            echo '<div class="mt-5">
            <h4>Backups</h4>
            <a href="criarBackup.php" type="button" class="mb-3">
                <button>Criar Backup</button>
            </a>
            </div>';
            $servidor = 'localhost';
            $user = 'root';
            $ligacao = mysqli_connect($servidor, $user) or die('Sem ligação');
            mysqli_select_db($ligacao, 'sgcsDB') or die('Sem tabela');

            $sql = "SELECT * FROM backups ORDER BY backup_date DESC";
            $result = $ligacao->query($sql);

            if ($result->num_rows > 0) {
                echo "<table style='border: 1px solid; border-collapse: separate; border-spacing: 50px 0; margin-bottom:3rem;'>";
                echo "<tr><th>Filename</th><th>Created At</th><th>Download</th><th>Recover</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['filename'] . "</td>";
                    echo "<td>" . $row['backup_date'] . "</td>";
                    echo "<td><a href='download.php?id=" . urlencode($row['id']) . "'>Download</a></td>";
                    echo "<td><a href='recoverBackup.php?id=" . urlencode($row['id']) . "'>Recover</a></td>";
                    echo "</tr>";
                }
                echo "</table>";
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
