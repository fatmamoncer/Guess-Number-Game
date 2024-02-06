<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game History</title>
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

        th,
        td {
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
    <h1>Mysterious Number Game - Game History</h1>
    <?php
    $servername = "localhost";
    $username = "root"; 
    $password = "";     
    $dbname = "guess the number game";

    
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $gameId = $_GET['id'];

    $sqlGetTries = "SELECT id, try, DATE_FORMAT(date, '%Y-%m-%d %H:%i:%s') AS formatted_date FROM tries WHERE game = $gameId ORDER BY date";

    $result = $conn->query($sqlGetTries);

    if ($result) {
        $tries = [];
        while ($row = $result->fetch_assoc()) {
            $tries[] = $row;
        }

        $result->free();

        echo "<h2>Game History for Game ID: $gameId</h2>";
        echo "<table>";
        echo "<tr><th>Try Nb</th><th>Try</th><th>Date</th></tr>";
        $conter=0;
        foreach ($tries as $try) {
            $conter++;
            echo "<tr>";
            echo "<td>" . $conter . "</td>";
            echo "<td>" . $try['try'] . "</td>";
            echo "<td>" . $try['formatted_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Error: " . $sqlGetTries . "<br>" . $conn->error;
    }

    $conn->close();
    ?>
    <p><a href="history.php">Back</a></p>
</body>

</html>
