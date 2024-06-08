<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class = "container mt-3">
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
    <h1>SGCS</h1>
    <a href="index.php" type = "button">
        <button>Home</button>
    </a>
    <a href="components.php" type = "button">
        <button>Components</button>
    </a>
    <a href="settings.php" type = "button">
        <button>Settings</button>
    </a>
    <?php 
        
        if ($_SESSION["usertype"] == 'admin') {
            echo '<a href="adminpage.php" type = "button">
                    <button>Admin</button>
                  </a>';
        }
    ?>
    <a href="login.php" type = "button">
        <button>Log Out</button>
    </a>

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
                <label>Name:</label>
                <input type="text" placeholder="Name" name="username" class = "mt-2"> <br>
                <label>Password:</label>
                <input type="password" placeholder="Password" name="password" class = "mt-2"> <br>
                <label>Type:</label>
                <select name="type" class = "mt-2">
                    <option value="developer">Developer</option>
                    <option value="admin">Administrator</option>
                </select> <br>
                <button type="submit" class = "mt-4">Insert User</button>
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
                    echo "<select name='userChange'>";
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
                <p class="mb-0">Change Name</p>
                <input type="checkbox" name="nameChange" id="nameChangeCheckbox">
            </div>

            <div class="card px-4 py-2" id="nameChangeSection" style="display: none;">
                <label>Nome:</label><br>
                <input type="text" placeholder="Name" name="username" class="mt-2" style="width: 10rem;"><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Change Password</p>
                <input type="checkbox" name="passwordChange" id="passwordChangeCheckbox">
            </div>

            <div class="card px-4 py-2" id="passwordChangeSection" style="display: none;">
                <label>Password:</label><br>
                <input type="password" placeholder="Password" name="password" class="mt-2" style="width: 10rem;"><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Change Type</p>
                <input type="checkbox" name="typeChange" id="typeChangeCheckbox">
            </div>

            <div class="card px-4 py-2" id="typeChangeSection" style="display: none;">
                <label>Type:</label><br>
                <select name="type" id="type" class="mt-2" style="width: 10rem;">
                    <option value="developer">Developer</option>
                    <option value="admin">Administrator</option>
                </select><br>
            </div>

            <div style="display: flex; gap: .5rem; margin-top: 1rem; margin-bottom: 0.5rem">
                <p class="mb-0">Deactivate:</p>
                <input type="checkbox" name="isDeactivated" value = "deactivated" id="typeChangeCheckbox">
            </div>

            <button type="submit" class = "mt-4">Alterar Detalhes</button>
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
                    echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>isDeactivated</th></tr>";
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