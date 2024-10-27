<?php
// 防止缓存
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

// 连接数据库
include "../inc/dbinfo.inc"; // 请确保 dbinfo.inc 包含你的数据库配置
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$database = mysqli_select_db($connection, DB_DATABASE);

// 确保 EMPLOYEES 表存在
VerifyEmployeesTable($connection, DB_DATABASE);

// 检查是否有新的数据提交
$employee_name = htmlentities($_POST['NAME']);
$employee_address = htmlentities($_POST['ADDRESS']);
if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
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

    <!-- MySQL 数据输入表单 -->
    <div class="container">
        <h2>輸入員工資料</h2>
        <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
            <div class="form-group">
                <label for="name">姓名：</label>
                <input type="text" name="NAME" class="form-control" maxlength="45" required>
            </div>
            <div class="form-group">
                <label for="address">地址：</label>
                <input type="text" name="ADDRESS" class="form-control" maxlength="90" required>
            </div>
            <button type="submit" class="btn btn-primary">新增資料</button>
        </form>
    </div>

    <!-- 数据库数据展示 -->
    <div class="container mt-4">
        <h2>員工列表</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>地址</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");
                while($query_data = mysqli_fetch_row($result)) {
                    echo "<tr><td>$query_data[0]</td><td>$query_data[1]</td><td>$query_data[2]</td></tr>";
                }
                mysqli_free_result($result);
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
// 添加员工到数据库
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);
   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a')";
   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

// 确认表是否存在，如果不存在则创建
function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName)) {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";
     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
}

// 检查表是否存在
function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);
  $checktable = mysqli_query($connection, "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");
  if(mysqli_num_rows($checktable) > 0) return true;
  return false;
}

// 关闭数据库连接
mysqli_close($connection);
?>
