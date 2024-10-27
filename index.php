<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

// MySQL 数据库连接信息
include "../inc/dbinfo.inc"; // 请确保此文件中包含正确的数据库连接信息

// 建立与数据库的连接
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (mysqli_connect_errno()) {
    echo "连接到 MySQL 失败: " . mysqli_connect_error();
}

// 选择数据库
$database = mysqli_select_db($connection, DB_DATABASE);

// 验证 EMPLOYEES 表是否存在
VerifyEmployeesTable($connection, DB_DATABASE);

// 如果表单填写了数据，添加数据到 EMPLOYEES 表
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

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include('menu.php'); ?>
                <div class="jumbotron">
                    <p>
                        <?php include("get-index-meta-data.php"); ?>
                        <hr />
                        <?php include('get-cpu-load.php'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <img src="IMG_6477.gif" class="profile-pic">
        <div class="description">
            <h2>個人簡介</h2>
            <p>
                我是資工三甲28號蘇聖元，平時喜歡玩遊戲和看動漫化或輕小說，最近玩很瘋的遊戲是Dark And Darker。
            </p>
            <p>
                Email: 11111128@gm.nttu.edu.tw
            </p>
        </div>
    </div>

    <div class="container">
        <div class="description">
            <h2>這是未來要抽的腳色</h2>
            <img src="kisakilobby.jpg" class="profile-pickisaki">
        </div>
        <img src="senseipr.png" class="profile-picn">
        <img src="kisakiface.png" class="profile-picn">
    </div>

    <div class="container">
        <div class="description">
            <h2>推薦> 浮雲(feat. isui)-nao</h2>
            <video width="560" height="315" controls>
                <source src="cloud.mp4" type="video/mp4">
            </video>
        </div>
    </div>

    <div class="container">
        <div class="description">
            <h2>這我</h2>
            <img src="po.jpg" class="profile-pic">
            <h2>這我</h2>
            <img src="usakifuck.png" class="profile-pic">
        </div>
        <img src="kokonagood.gif" class="profile-picKOKO">
    </div>

    <div class="container">
        <div class="description">
            <h2>這我</h2>
            <img src="me.jpg" class="profile-picself">
        </div>
        <audio controls>
            <source src="selfintro.m4a" type="audio/mpeg">
        </audio>
    </div>

    <!-- 移到页面底部的资料输入功能和数据显示 -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>資料輸入</h2>
                <!-- Input form -->
                <form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="POST">
                    <table border="0">
                        <tr>
                            <td>姓名</td>
                            <td>地址</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="NAME" maxlength="45" size="30" />
                            </td>
                            <td>
                                <input type="text" name="ADDRESS" maxlength="90" size="60" />
                            </td>
                            <td>
                                <input type="submit" value="新增資料" />
                            </td>
                        </tr>
                    </table>
                </form>

                <!-- 顯示資料表 -->
                <table border="1" cellpadding="2" cellspacing="2">
                    <tr>
                        <td>ID</td>
                        <td>姓名</td>
                        <td>地址</td>
                    </tr>

                    <?php
                    $result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");
                    while($query_data = mysqli_fetch_row($result)) {
                        echo "<tr>";
                        echo "<td>", $query_data[0], "</td>",
                             "<td>", $query_data[1], "</td>",
                             "<td>", $query_data[2], "</td>";
                        echo "</tr>";
                    }
                    ?>

                </table>

                <?php
                // 清理
                mysqli_free_result($result);
                mysqli_close($connection);
                ?>
            </div>
        </div>
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
/* 添加员工到表中 */
function AddEmployee($connection, $name, $address) {
    $n = mysqli_real_escape_string($connection, $name);
    $a = mysqli_real_escape_string($connection, $address);
    $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";
    if(!mysqli_query($connection, $query)) echo("<p>添加员工数据时出错。</p>");
}

/* 检查表是否存在，并创建表 */
function VerifyEmployeesTable($connection, $dbName) {
    if(!TableExists("EMPLOYEES", $connection, $dbName)) {
        $query = "CREATE TABLE EMPLOYEES (
            ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            NAME VARCHAR(45),
            ADDRESS VARCHAR(90)
        )";

        if(!mysqli_query($connection, $query)) echo("<p>创建表时出错。</p>");
    }
}

/* 检查表的存在性 */
function TableExists($tableName, $connection, $dbName) {
    $t = mysqli_real_escape_string($connection, $tableName);
    $d = mysqli_real_escape_string($connection, $dbName);
    $checktable = mysqli_query($connection,
        "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

    if(mysqli_num_rows($checktable) > 0) return true;
    return false;
}
?>
