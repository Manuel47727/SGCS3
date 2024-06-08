<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .RemoverDependecia {
            font-size:.5rem;
            border: 1px #FF7F7F solid;
            background-color: transparent;
        }
        .RemoverDependecia:hover {
            background-color: #FF7F7F;
            transition: 0.2s;
        }
    </style>
</head>
<body class = "container mb-5 mt-3">
    <?php 
        session_start();
        if($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
            header("Location: nopermission.php");
        }
    ?>
    <h1>SGCS</h1>
    <a href="index.php" type = "button" class = "buttons">
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
        
            <form action="criarComponente.php" method="post" enctype="multipart/form-data" class="mt-5 card p-4" style="grid-column: 1/4; grid-row: 1;">
                <fieldset>
                    <h2>Criar Componente</h2>
                    <label>Nome da Componente:</label>
                    <input type="text" placeholder="Name" name="componente_nome" class="mt-2"> <br>
                    <label>Description:</label><br>
                    <textarea class="mt-2 mb-2" name="description" rows="4" cols="50" style="max-height: 6rem;"></textarea> <br>
                    <label>Versão:</label><br>
                    <input type="text" placeholder="Versao" name="versao" class="mt-2 mb-2"> <br>
                    <label>Select File:</label><br>
                    <input type="file" name="file" class="mt-2 mb-2"> <br>
                    <button type="submit" class="mt-2">Criar Componente</button>
                </fieldset>
            </form>

    
            <form id = "criarDependicia" action="criarDependencia.php" method="post" class = "mt-5 card p-4" style = "grid-column: 4/10;  grid-row: 1;">
                <fieldset>
                    <h2>Definir Dependencia</h2>
                    <label>Componente:</label>
                    <input type="text" placeholder="ID" name="componente_filho" class = "mt-2 mb-2"> <br>
                    <label>Depende de</label><br>
                    <label>Componente:</label>
                    <input type="text" placeholder="ID" name="componente_pai" class = "mt-2"> <br>
                    <button type="submit" class = "mt-2">Definir Dependencia</button>
                </fieldset>
            </form>
    
    
            <div class = "card p-4" style = "grid-column: 1/10;  grid-row: 2;">
                <h3>Componentes</h3>
                <?php
    
                    error_reporting(E_ALL);
                    ini_set('display_errors', 1);
    
                    $servidor = 'localhost';
                    $user = 'root';
    
                    $ligacao = new mysqli($servidor, $user) or die('Sem Ligacao');
                    mysqli_select_db($ligacao,'sgcsDB') or die('Sem tabela');
    
    
                    $query = "SELECT c.COMP_ID, c.COMP_NOME, c.COMP_DESC, c.COMP_DATE, c.COMP_COMP_ID, c.COMP_user_id, u.user_name 
                            FROM componente c 
                            JOIN users u ON c.COMP_user_id = u.user_id";
    
                    $res = mysqli_query($ligacao, $query);
    
                    $arr = [];
                    while ($row = mysqli_fetch_assoc($res)) {
                        $arr[$row['COMP_ID']] = [
                            'COMP_NOME' => $row['COMP_NOME'],
                            'COMP_DESC' => $row['COMP_DESC'],
                            'COMP_DATE' => $row['COMP_DATE'],
                            'COMP_COMP_ID' => $row['COMP_COMP_ID'],
                            'COMP_user_id' => $row['COMP_user_id'],
                            'user_name' => $row['user_name']
                        ];
                    }
    
                    buildTreeView($arr, 0);
    
                    function buildTreeView($arr, $parent, $level = 0, $prelevel = -1) {
                        foreach ($arr as $id => $data) {
                            if ($parent == $data['COMP_COMP_ID']) {
                                if ($level > $prelevel) {
                                    echo "<ol>";
                                }
                                if ($level == $prelevel) {
                                    echo "</li>";
                                }
                                echo "<li class='mt-2 p-2 card'>
                                         <div style = 'display:flex'>
                                            <p style =  'font-weight: bold'>" . $id . " </p>
                                            <p> - Componente: " . $data['COMP_NOME'] . "</p>
                                            <div style = 'margin-left: auto;'>
                                                <p>" . $data['user_name']. " @ " .$data['COMP_DATE']."</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p> Descrição: ". $data['COMP_DESC']. "</p>
                                        </div>
                                        <div style = 'display: flex; gap: 1.5rem;'>
                                            <div>
                                                <div style='width:3rem' id = 'versoesButton'>
                                                    <a href='Versoes.php?comp_id=" . $id . "' class='Versoes'>
                                                        <button>Versoes</button>
                                                    </a>
                                                </div>
                                            </div>";
                                if ($data['COMP_COMP_ID'] > 0) {
                                    echo "<a href='removerDependencia.php?comp_id=" . $id . "' type='button' style='width:11rem'>
                                            <button class = 'RemoverDependeciaTEST'>Remover Dependencia</button>
                                          </a>";
                                }
                                echo "<div style = 'position:absolute; right: 1rem;'>
                                        <a href='removerComponente.php?comp_id=" . $id . "'>
                                            <button>Remover Componente</button>
                                        </a>
                                      </div>";
                                
                                if ($level > $prelevel) {
                                    $prelevel = $level;
                                }
                                $level++;
                                echo "</div>";
                                buildTreeView($arr, $id, $level, $prelevel);
                                $level--;
                            }
                        }
                        if ($level == $prelevel) {
                            echo "</li></ol>";
                        }
                    }
    
                    $ligacao->close();
                ?>

        </div>
    </div>

</body>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>
