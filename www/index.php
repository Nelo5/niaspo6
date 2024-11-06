<?php

// Database credentials -  **IMPORTANT: Change these to your actual credentials**
$user = "root";
$pass = "root";
$dbname = "user_data"; // Name of the database

try {
    $dsn = "mysql:host=mysql;dbname=$dbname;charset=utf8";
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Enable exceptions for better error handling

    // Handle user input (using a simple form for demonstration)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $height = $_POST["height"];
        $weight = $_POST["weight"];

        // Prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO users (height, weight) VALUES (?, ?)");
        $stmt->execute([$height, $weight]);
        echo "Data inserted successfully!";
    }


    // Retrieve and display data
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h2>User Data:</h2>";
    if (!empty($users)) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Height (cm)</th><th>Weight (kg)</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['id'] . "</td>";
            echo "<td>" . $user['height'] . "</td>";
            echo "<td>" . $user['weight'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No users found.</p>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html>
<head>
<title>User Data Input</title>
</head>
<body>

<h1>Add User Data</h1>
<form method="post">
    Height (cm): <input type="number" step="0.01" name="height"><br>
    Weight (kg): <input type="number" step="0.01" name="weight"><br>
    <input type="submit" value="Submit">
</form>

</body>
</html>