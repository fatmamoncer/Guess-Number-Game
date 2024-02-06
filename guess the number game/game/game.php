<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mysterious Number Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #f3f3f3;
        }
        .container {
            width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"] {
            padding: 8px;
            font-size: 16px;
            width: 100%;
            margin-bottom: 20px;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mysterious Number Game</h1>
        <?php
        session_start();

        

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['restart'])) {
    header("Location: new_game.php");
    exit(); 
}


$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "guess the number game";

$conn = new mysqli($servername, $username, $password, $dbname);


        $gameData = $_SESSION["game_data"];

        $id = $gameData["id"];
        $mysteriousNumber = $gameData["target"];
        if(!isset($_SESSION['gameId'])){
            $_SESSION['gameId'] = $gameData["id"];
        }else if($_SESSION['gameId'] !== $gameData["id"]){
            $_SESSION['gameId'] = $gameData["id"];
            $_SESSION['tries'] = 0;
            $_SESSION['triesList'] = [];
        }
        if (!isset($_SESSION['tries'])) {
            $_SESSION['tries'] = $gameData["tries"];
            $_SESSION['triesList'] = [];
        }
        if (!isset($_SESSION['triesList'])) {
            $_SESSION['triesList'] = [];
        }
        $finished = $gameData["finished"];
        $win = $gameData["win"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['guess'])) {
                $userGuess = $_POST['guess']; 
                $_SESSION['tries'] = $_SESSION["tries"]+1;
                $try = $_POST['guess'];
                $date = date("Y-m-d H:i:s");
                $sqlInsertTry = "INSERT INTO tries (try, date, game)
                          VALUES ('$try', '$date', '$id')";
        if ($conn->query($sqlInsertTry) === TRUE) {
            $_SESSION['triesList'][]=[
                "try" => $try,
                "date" => $date,
            ];

        } else {
            echo "Error: " . $sqlInsertGame . "<br>" . $conn->error;
        }
                if ($userGuess == $mysteriousNumber) {
                    echo "<p class='message'>Congratulations! You guessed the mysterious number: $mysteriousNumber</p>";
                    $win = 1;
                    $finished = 1;
                    $tries = $_SESSION["tries"];
                    $sql = "UPDATE games SET finished = '$finished',tries = '$tries',win = '$win' WHERE id = $id";

                    if ($conn->query($sql) === TRUE) {
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                        <input type="hidden" name="restart" value="true">
                        <button type="submit" name="play_again">Play Again</button>
                    </form>
                <?php
                } elseif ($userGuess < $mysteriousNumber) {
                    echo "<p class='message'>Try again! The mysterious number is higher.</p>";
                } else {
                    echo "<p class='message'>Try again! The mysterious number is lower.</p>";
                }
            }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="guess">Enter your guess:</label>
            <input type="number" id="guess" name="guess" required>
            <button type="submit" name="submit">Guess</button>
        </form>
    </div>
    <?php
if (isset($_SESSION['triesList'])) {
    $conter = 0;
    echo "<h2>Game History</h2>";
    echo "<table>";
    echo "<tr><th>Try Nb</th><th>Try</th><th>Date</th></tr>";
    foreach ($_SESSION['triesList'] as $tryData) {
        $conter++;
        echo "<tr>";
        echo "<td>" . $conter . "</td>";
        echo "<td>" . $tryData['try'] . "</td>";
        echo "<td>" . $tryData['date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>
</body>
</html>
