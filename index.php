<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Send Email</h1>
    <form action="send_email.php" method="post">
        <label for="recipient">Select Recipient:</label>
        <select name="recipient" id="recipient" required>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "root"; 
            $dbname = "email_system";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id, email FROM recipients";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['email'] . "</option>";
            }
            $conn->close();
            ?>
        </select>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required>

        <label for="body">Email Body:</label>
        <textarea name="body" id="body" rows="5" required></textarea>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
