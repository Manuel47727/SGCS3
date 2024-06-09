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

        .button-confirm-style:hover {
            background-color: #0066ff;
            color: #fff;
            border-radius: 15px;
        }

        .button-remove-style {
            border: 1px red solid;
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

        .button-remove-style:hover {
            background-color: red;
            color: #fff;
            border-radius: 15px;
        }

        .button-style:hover {
            color: #0066ff;
        }
        
        .card {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }
    </style>
</head>
<body class = "container mb-5" style = "margin-top: 5rem">
    <?php 
        session_start();
        if($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
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
                    <input type="text" placeholder="Nome" name="componente_nome" class="mt-2 form-control" style = "max-width: 15rem;"> <br>
                    <label>Descrição:</label><br>
                    <textarea class="mt-2 mb-2 form-control" style = "max-width: 25rem; max-height: 6rem;" name="description" rows="4" cols="50"></textarea> <br>
                    <label>Versão:</label><br>
                    <input type="text" placeholder="Versão" name="versao" class="mt-2  form-control" style = "width: 5rem;"> <br>
                    <label>Selecionar Ficheiro:</label><br>
                    <input type="file" name="file" class="mt-2 mb-2 form-control" style = "max-width: 15rem;"> <br>
                    <button type="submit" class="button-confirm-style">Criar Componente</button>
                </fieldset>
            </form>

    
            <form id = "criarDependicia" action="criarDependencia.php" method="post" class = "mt-5 card p-4" style = "grid-column: 4/10;  grid-row: 1;">
                <fieldset>
                    <h2>Definir Dependencia</h2>
                    <label>Componente:</label>
                    <input type="text" placeholder="ID" name="componente_filho" class = "mt-2 mb-2 form-control" style = "width: 5rem;">
                    <label>Depende de</label><br>
                    <label>Componente:</label>
                    <input type="text" placeholder="ID" name="componente_pai" class = "mt-2 form-control" style = "width: 5rem;"> <br>
                    <button type="submit" class="button-confirm-style">Definir Dependencia</button>
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
                                        <div style = 'display: flex; gap: 1.5rem; margin:1rem 0rem;'>
                                            <div>
                                                    <a href='Versoes.php?comp_id=" . $id . "' class='button-confirm-style'>Versões</a>
                                            </div>";
                                if ($data['COMP_COMP_ID'] > 0) {
                                    echo "<div>
                                            <a href='removerDependencia.php?comp_id=" . $id . "' class = 'button-remove-style'>Remover Dependencia</a>
                                        </div>";
                                }
                                echo "<div style = 'position:absolute; right: 1rem;'>
                                        <a href='removerComponente.php?comp_id=" . $id . "'  class='button-remove-style'>Remover Componente</a>
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
