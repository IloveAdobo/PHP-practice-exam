<?php
$servername = "localhost";
$username = "root"; 
$password = "12345"; 
$dbname = "neil_rentillo_db"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$textBox = $_POST['textBox'];
$radioButton = $_POST['radioButton'];
$checkBox = isset($_POST['checkBox']) ? implode(", ", $_POST['checkBox']) : '';


$imagePath = '';
if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
    $imageName = basename($_FILES['imageUpload']['name']);
    $targetDir = 'uploads/';
    $targetPath = $targetDir . $imageName;
    

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (move_uploaded_file($_FILES['imageUpload']['tmp_name'], $targetPath)) {
        $imagePath = $targetPath;
    } else {
        echo "Error uploading image.";
        exit();
    }
}


$sql = "INSERT INTO neil_rentillo_form_data (textBox, radioButton, checkBox, imagePath) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $textBox, $radioButton, $checkBox, $imagePath);

if ($stmt->execute()) {
    echo "Data successfully stored.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>