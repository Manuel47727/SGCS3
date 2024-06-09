<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
    <style>
        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            gap: 2rem;
        }

        .button-confirm-style {
            border: 1px #0066ff solid;
           background-color: transparent;
           border-radius: 5px;
           outline: none;
           padding: 4px 20px;
           margin-top:1rem;
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
</head>
<body>
    <?php
        session_start();
        unset($_SESSION['usertype']);   
    ?>
    <div class="center-container">
            <img src="./img/sgcs_logo.png" alt="SGCS Logo" width = "500rem">
            <h1 style="">Log-In</h1>
            <?php    
                if (isset($_SESSION['status'])) {
                    echo '<div class="alert alert-danger mt-4">' . $_SESSION['status'] . '</div>';
                    unset($_SESSION['status']);
                }
            ?>
            <form action="checkLogin.php" method="post" class="card p-4" style="width: 20rem; margin-top: -2rem;">
                <fieldset>
                    <label for="username">Username</label> <br>
                    <input type="text" id="username" name="username" placeholder="Username" class = "form-control" style = "max-width: 15rem;"> <br>
                    <label for="password">Password</label> <br>
                    <input type="password" id="password" name="password" placeholder="Password" class=" form-control" style = "max-width: 15rem;"> <br>
                    <button type="submit" class="button-confirm-style">Log-In</button>
                </fieldset>
            </form>
            
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
