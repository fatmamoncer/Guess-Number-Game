<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
if (isset($_GET["logout"])) {
    $_SESSION = array();
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guess the Number Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .options {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .options a {
            text-decoration: none;
            color: #4CAF50;
            font-size: 18px;
            padding: 10px;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .options a:hover {
            background-color: #4CAF50;
            color: #fff;
        }

        .user-info {
            margin-top: 20px;
        }

        .user-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .logout-btn {
            background-color: #d9534f;
            color: #fff;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome <?php echo $_SESSION["username"]; ?> to the Guess the Number Game</h1>
        <div class="options">
            <a href="game/new_game.php">New Game</a>
            <a href="history.php">History</a>
        </div>
        <div class="user-info">
            <form method="post" action="logout.php">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
