<?php
// 設定資料庫連線
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// 建立連線
$conn = new mysqli($servername, $username, $password, $dbname);

// 檢查連線是否成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 新增資料
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// 刪除資料
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    
    $sql = "DELETE FROM users WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// 查詢資料
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP CRUD</title>
</head>
<body>

<h2>Add User</h2>
<form method="post">
    <label>Name:</label><br>
    <input type="text" name="name"><br>
    <label>Email:</label><br>
    <input type="text" name="email"><br>
    <input type="submit" name="add" value="Add User">
</form>

<h2>User List</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td><a href='?delete=".$row["id"]."'>Delete</a></td>";
            echo "</tr>";
        }
    } else {
        echo "0 results";
    }
    ?>
</table>

</body>
</html>

<?php
// 關閉連線
$conn->close();
?>
