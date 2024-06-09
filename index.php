<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>

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
    </style>
</head>
<body class = "container" style = "margin-top: 5rem">

    <?php 
        session_start();
        if($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
            header("Location: nopermission.php");
        }
    ?>

    <img src="./img/sgcs_logo.png" alt="SGCS Logo" width = "150rem" style = "margin-right: 2rem;">

    <a href="index.php" class="button-style">Home</a>

    <a href="components.php" class="button-style">Components</a>

    <a href="settings.php" class="button-style">Settings</a>

    <?php 
        if ($_SESSION["usertype"] == 'admin') {
            echo '<a href="adminpage.php" class="button-style">Admin</a>';
        }
    ?>
    <a href="login.php" class="button-style">Log Out</a>

    
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>
