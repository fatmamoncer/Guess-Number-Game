<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 12px;
        }

        th {
            background-color: #f2f2f2;
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
    <h1>Mysterious Number Game</h1>
    <?php
    session_start();
    if (!isset($_SESSION["user_id"])) {
        header("Location: login.php");
        exit();
    } else {
        $id = $_SESSION["user_id"];
    }
    $servername = "localhost";
    $username = "root"; 
    $password = "";     
    $dbname = "guess the number game";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $history = [];
    $sqlGetHistory = "SELECT id,min,max,target,tries,win,DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') AS formatted_date FROM games WHERE playerId = $id ORDER BY date";

    $result = $conn->query($sqlGetHistory);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
        $result->free();
    } else {
        echo "Error: " . $sqlGetHistory . "<br>" . $conn->error;
    }

    echo "<h2>Game History</h2>";
    echo "<table>";
    echo "<tr><th>Id</th><th>Min</th><th>Max</th><th>Mysterious Number</th><th>Tries Number</th><th>Date</th><th>Win</th></tr>";
    foreach ($history as $attempt) {
        echo "<tr>";
        echo "<td>" . $attempt['id'] . "</td>";
        echo "<td>" . $attempt['min'] . "</td>";
        echo "<td>" . $attempt['max'] . "</td>";
        echo "<td>" . $attempt['target'] . "</td>";
        echo "<td>" . $attempt['tries'] . "</td>";
        echo "<td>" . $attempt['formatted_date'] . "</td>";
        if ($attempt['win'] == 1)  echo "<td> true </td>";
        else echo "<td> false </td>";
        echo "<td><a href='game_history.php?id=" . $attempt['id'] . "'>View History</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <p><a href="index.php">Back</a></p>
</body>

</html>
