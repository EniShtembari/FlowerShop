<?php
$host = "localhost"; // ose IP e serverit të bazës së të dhënave
$username = "root";  // emri i përdoruesit të bazës së të dhënave
$password = "";      // fjalëkalimi i përdoruesit të bazës së të dhënave
$dbname = "reviews"; // emri i bazës së të dhënave

// Krijo lidhjen me bazën e të dhënave
$conn = new mysqli($host, $username, $password, $dbname);

// Kontrollo nëse lidhja është e suksesshme
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Merr të dhënat nga formulari
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];
$user_name = $_POST['user_name'];

// Përgatit dhe ekzekuto SQL për të shtuar review-n në bazën e të dhënave
$sql = "INSERT INTO reviews (rating, review_text, user_name) VALUES ('$rating', '$review_text', '$user_name')";

if ($conn->query($sql) === TRUE) {
    echo "Review submitted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
