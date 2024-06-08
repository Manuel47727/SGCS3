<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>
<body class = "container mt-3">
    <?php
        session_start();
        unset($_SESSION['usertype']);   
    ?>
    <div style = "display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <h1>Log-In</h1>
        <form action="checkLogin.php" method = "post" class = "card p-4" style = "width: 20rem;">
            <fieldset>
                <label for="">Username</label> <br>
                <input type="text" name = "username" placeholder= "Username"> <br>
                <label for="" class = "mt-2">Password</label> <br>
                <input type="password" name = "password" placeholder= "Password" class = "mb-2"> <br>
                <button class = "mt-2">Log-In</button>
        <?php    
            if (isset($_SESSION['status'])) {
                echo '<div class="alert alert-danger mt-4">' . $_SESSION['status'] . '</div>';
                unset($_SESSION['status']);
            }
    
        ?>
    
            </fieldset>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>