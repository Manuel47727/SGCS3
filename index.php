<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class = "container mt-3">

    <?php 
        session_start();
        if($_SESSION['usertype'] != 'admin' && $_SESSION['usertype'] != 'developer') {
            header("Location: nopermission.php");
        }
    ?>

    <h1>SGCS</h1>
    <a href="index.php" type = "button">
        <button>Home</button type = "button">
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

    
</body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html>
