<?php
require 'vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "email_system";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_id = $_POST['recipient']; // Get recipient ID from the form
    $subject = $_POST['subject'];
    $body = $_POST['body'];

    $sql = "SELECT email FROM recipients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipient_id);
    $stmt->execute();
    $stmt->bind_result($recipient_email);
    $stmt->fetch();
    $stmt->close();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'gauriagr92@gmail.com'; 
        $mail->Password = 'wfoo rgtd icbt kfcf';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('gauriagr92@gmail.com', 'Mailer'); 
        $mail->addAddress($recipient_email); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Send email
        $mail->send();
        echo "Email sent successfully to $recipient_email!";
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>
