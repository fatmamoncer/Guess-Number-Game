<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "guess the number game";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $minValue = $_POST["min_value"];
    $maxValue = $_POST["max_value"];

    if (!is_numeric($minValue) || !is_numeric($maxValue) || $minValue >= $maxValue) {
        $errorMessage = "Invalid input values. Please enter a valid range.";
    } else {
        $targetNumber = rand($minValue, $maxValue);
        $tries = 0;
        $userGuess = null;
        $lastInsertedId = null;
        
        $userId = $_SESSION["user_id"];
        $date = date("Y-m-d H:i:s");
        $finished = 0;
        $win = 0;
        $tries = 0;

        $sqlInsertGame = "INSERT INTO games (min, max, target, tries, playerId, date, finished, win)
                          VALUES ('$minValue', '$maxValue', '$targetNumber', '$tries', '$userId', '$date', '$finished', '$win')";
        if ($conn->query($sqlInsertGame) === TRUE) {
            $_SESSION["game_data"] = [
                "id" => $conn->insert_id,
                "min" => $minValue,
                "max" => $maxValue,
                "target" => $targetNumber,
                "tries" => $tries,
                "playerId" => $userId,
                "date" => $date,
                "finished" => $finished,
                "win" => $win,
            ];
            header("Location: game.php");
            exit();

        } else {
            echo "Error: " . $sqlInsertGame . "<br>" . $conn->error;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Game</title>
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
    width: 300px;
    background-color: #fff;
    padding: 30px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
}

.input-group {
    margin-bottom: 20px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    display: block;
}

button.btn {
    width: 100%;
    padding: 12px 0;
    background-color: #4CAF50;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

button.btn:hover {
    background-color: #45a049;
    transition: background-color 0.3s ease;
}

p {
    text-align: center;
    margin-top: 10px;
    font-size: 14px;
    color: #555;
}

a {
    color: #4CAF50;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>New Game</h1>
        <form method="post" action="">
            <label for="min_value">Min Value:</label>
            <input type="text" name="min_value" required>
            <br>
            <label for="max_value">Max Value:</label>
            <input type="text" name="max_value" required>
            <br>
            <button type="submit">Start Game</button>
        </form>
        <?php if (isset($errorMessage)): ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php endif; ?>

        <?php if (isset($successMessage)): ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <?php if (isset($targetNumber)): ?>
            <div class="game-content">
                <p>Target Number: <?php echo $targetNumber; ?></p>
                <p>Tries: <?php echo $tries; ?></p>
            </div>
        <?php endif; ?>

        <a href="../index.php" class="back-btn">Back to Main Page</a>
    </div>
</body>
</html>
