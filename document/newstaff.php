<?php
session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");


// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะเพิ่ม
if ($_POST){
    //print_r($_POST);
    $sc = $_POST['sc'];
    $flname = $_POST['flname'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $is_admin= $_POST['is_admin'];

    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB

    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง actor
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql ="INSERT 
            INTO staff (stf_code, stf_name, username, passwd, is_admin) 
            VALUES (?, ?, ?, ?, ?);";       
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("sssss", $sc, $flname, $username, $password, $is_admin);
    $stmt->execute();

    // redirect ไปยัง actor.php
    header("location: staff.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>php db demo</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Add an staff</h1>
        <form action="newstaff.php" method="post">
            <div class="form-group">
                <label for="sc">รหัสพนักงาน</label>
                <input type="text" class="form-control" name="sc" id="sc">
            </div>
            <div class="form-group">
                <label for="flname">ชื่อ-นามสกุล</label>
                <input type="text" class="form-control" name="flname" id="flname">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <input type="radio"  name="is_admin" id="is_admin" value="y"> Admin
                <input type="radio"  name="is_admin" id="is_admin" value=""> User
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>