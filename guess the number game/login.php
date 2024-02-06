<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        
        /* CSS styles */
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
            width: calc(100% - 22px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button.btn {
            width: 93%;
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
        <form method="post" action="">
            <h2>Login</h2>
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn">Sign In</button>
            </div>
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
        <?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "guess the number game";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"]; 
            header("Location: index.php"); 
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "User not found.";
    }
}

$conn->close();
?>

    </div>
</body>
</html>

