<?php
$servername = "localhost";
$username = "root"; 
$password = "12345"; 
$dbname = "neil_rentillo_db"; 


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM neil_rentillo_form_data";
$result = $conn->query($sql);


$apiUrl = "https://cat-fact.herokuapp.com/facts/random?amount=1";
$apiResponse = file_get_contents($apiUrl);
$apiData = json_decode($apiResponse, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Database</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Database Records</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Text Box</th>
                    <th>Radio Button</th>
                    <th>Check Box</th>
                    <th>Image</th>
                </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . htmlspecialchars($row["textBox"]) . "</td>
                    <td>" . htmlspecialchars($row["radioButton"]) . "</td>
                    <td>" . htmlspecialchars($row["checkBox"]) . "</td>
                    <td>" . ($row["imagePath"] ? "<img src='" . htmlspecialchars($row["imagePath"]) . "' width='100'>" : 'No Image') . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "No data found.";
    }

    $conn->close();
    ?>

    <br>
    <button onclick="window.location.href='form_page.php';">Back to Form</button>

    <h1>Random Cat Fact</h1>

    <?php
    if (isset($apiData[0])) {
        echo "<table>
                <tr>
                    <th>Fact</th>
                </tr>
                <tr>
                    <td>" . htmlspecialchars($apiData[0]['text']) . "</td>
                </tr>
              </table>";
    } else {
        echo "Error retrieving cat fact.";
    }
    ?>
</body>
</html>