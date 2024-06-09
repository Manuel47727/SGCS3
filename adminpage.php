<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

    </style>
<body class = "container" style = "margin-top: 5rem;">
    <?php 
        session_start();
        if($_SESSION['usertype'] != 'admin') {
            header("Location: nopermission.php");
        }

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $servidor = 'localhost';
        $user = 'root';
        $ligacao = mysqli_connect($servidor,$user) or die('Sem ligação');
        mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');
        
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

    <?php
        if (isset($_SESSION['status'])) {
            echo '<div class="alert alert-info mt-4">' . $_SESSION['status'] . '</div>';
            unset($_SESSION['status']);
        }
    ?>
    <div style = "display: grid; grid-gap: 10px;">
        <form action="insertUser.php" method="post" class = "mt-5 card p-4" style = "grid-column: 1; grid-row: 1;">
            <fieldset>
                <h2 style = "margin-bottom: 2rem;">Inserir Utilizador</h2>
                <label>Nome:</label>
                <input type="text" placeholder="Nome" name="username" class = "mt-2 form-control" style = "max-width: 15rem;"> <br>
                <label>Password:</label>
                <input type="password" placeholder="Password" name="password" class = "mt-2 form-control" style = "max-width: 15rem;"> <br>
                <label>Tipo:</label>
                <select name="type" class = "mt-2 form-control" style = "max-width: 15rem;">
                    <option value="developer">Developer</option>
                    <option value="admin">Administrator</option>
                </select> <br>
                <button type="submit" class = "button-confirm-style">Inserir User</button>
            </fieldset>
        </form>
        <br>
        <br>

    <form action="alterUser.php" method="post" class = "card p-4" style = "grid-column: 1; grid-row: 2;">
        <fieldset>
            <h2 style = "margin-bottom: 2rem;">Alterar Detalhes do Utilizador</h2>

            <label>Utilizador:</label> <br>
            <?php
                $users = getUsers($ligacao);

                if (!empty($users)) {
                    echo "<select name='userChange' class = 'form-control' style = 'max-width: 10rem;'>";
                    foreach ($users as $user) {
                        echo "<option value = '". $user['user_id'] . "'>" . $user['user_id'] . " - " . $user['user_name'] . "</option><br>";
                        echo "<br>";
                    }
                    echo "</select>";
                } else {
                    echo "No users found.";
                }
                echo "<br>"
            ?>
            
            <div style="display: flex; gap: .5rem; margin-top: 1.5rem; margin-bottom: 0.5rem">
                <p class="mb-0">Mudar Nome</p>
                <input type="checkbox" name="nameChange" id="nameChangeCheckbox" >
            </div>

            <div class="card px-4 py-2" id="nameChangeSection" style="display: none;">
                <label>Nome:</label><br>
                <input type="text" placeholder="Nome" name="username" class="mt-2 form-control" style = "max-width: 15rem;"><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Mudar Password</p>
                <input type="checkbox" name="passwordChange" id="passwordChangeCheckbox">
            </div>

            <div class="card px-4 py-2" id="passwordChangeSection" style="display: none;">
                <label>Password:</label><br>
                <input type="password" placeholder="Password" name="password" class="mt-2 form-control" style = "max-width: 15rem;" style="width: 10rem;"><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Mudar Tipo</p>
                <input type="checkbox" name="typeChange" id="typeChangeCheckbox">
            </div>

            <div class="card px-4 py-2" id="typeChangeSection" style="display: none;">
                <label>Tipo:</label><br>
                <select name="type" id="type" class="mt-2 form-control" style = "max-width: 15rem;">
                    <option value="developer">Developer</option>
                    <option value="admin">Administrator</option>
                </select><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Desativar:</p>
                <input type="checkbox" name="isDeactivated" value = "deactivated" id="typeChangeCheckbox">
            </div>

            <button type="submit" class = "button-confirm-style">Alterar Detalhes</button>
        </fieldset>
    </form>

    <br>
    <br>

    <div style = "grid-column: 2/3; grid-row: 1/3;" class = "card mt-5 p-4">
        <h2 style = "margin-bottom: 2rem;">Utilizadores</h2>
        <?php
                $users = getUsers($ligacao);

                if (!empty($users)) {
                    echo "<table style='border: 1px solid; border-collapse: separate; border-spacing: 50px 0; text-align: center;'>";
                    echo "<tr><th>ID</th><th>Nome</th><th>Tipo</th><th>estaDesativado</th></tr>";
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>" . $user['user_id'] . "</td>";
                        echo "<td>" . $user['user_name'] . "</td>";
                        echo "<td>" . $user['user_type'] . "</td>";
                        if ($user['user_isDeactivated'] == 1) {
                            echo "<td>Deactivated</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No users found.";
                }
                echo "<br>"
            ?>
    </div>

    <?php
        function getUsers($ligacao) {
            $consulta_user = "SELECT user_id, user_name, user_type, user_isDeactivated FROM users";
            $resultado_user = mysqli_query($ligacao, $consulta_user);
            $users = array();

            if ($resultado_user->num_rows > 0) {
                while ($row = $resultado_user->fetch_assoc()) {
                    $users[] = $row;
                }
            }
            return $users;
        }
    ?>
    </div>

</body>
    <script>
        const nameChangeCheckbox = document.getElementById('nameChangeCheckbox');
        const nameChangeSection = document.getElementById('nameChangeSection');
        const passwordChangeCheckbox = document.getElementById('passwordChangeCheckbox');
        const passwordChangeSection = document.getElementById('passwordChangeSection');
        const typeChangeCheckbox = document.getElementById('typeChangeCheckbox');
        const typeChangeSection = document.getElementById('typeChangeSection');

        nameChangeCheckbox.addEventListener('change', toggleSection);
        passwordChangeCheckbox.addEventListener('change', toggleSection);
        typeChangeCheckbox.addEventListener('change', toggleSection);

        function toggleSection() {
            switch (this) {
                case nameChangeCheckbox:
                    nameChangeSection.style.display = this.checked ? 'block' : 'none';
                    break;
                case passwordChangeCheckbox:
                    passwordChangeSection.style.display = this.checked ? 'block' : 'none';
                    break;
                case typeChangeCheckbox:
                    typeChangeSection.style.display = this.checked ? 'block' : 'none';
                    break;
            }
        }
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>