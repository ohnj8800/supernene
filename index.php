<?php
// 禁止缓存
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

// 连接数据库
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "your_database_name";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 插入数据
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $description = $_POST['description'];

    $sql = "INSERT INTO user_info (name, email, description) VALUES ('$name', '$email', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "新增成功!";
    } else {
        echo "錯誤: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>蘇聖元 自我介紹網站</title>
    <link rel="stylesheet" href="index.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>蘇聖元 自我介紹網站</h1>
    </header>

    <!-- MySQL 数据插入表单 -->
    <div class="container">
        <h2>新增使用者資料</h2>
        <form action="" method="post">
            <label for="name">名稱:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="description">簡介:</label>
            <textarea id="description" name="description" required></textarea><br>

            <input type="submit" value="新增資料">
        </form>
    </div>

    <!-- 查询数据库并显示结果 -->
    <div class="container">
        <h2>使用者列表</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名稱</th>
                    <th>Email</th>
                    <th>簡介</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 从数据库中查询数据并显示
                $sql = "SELECT id, name, email, description FROM user_info";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['description']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>無資料</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        蘇聖元 自我介紹網站
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>

<?php
// 关闭数据库连接
$conn->close();
?>
