<?php
session_start();
if(!isset($_SESSION['loggined'])){
    header('Location: login.php');
}
require_once("dbconfig.php");

// ตรวจสอบว่ามีการ post มาจากฟอร์ม ถึงจะเพิ่ม
if ($_POST){
    //print_r($_POST);
    $dnum = $_POST['dnum'];
    $dtitle = $_POST['dtitle'];
    $dsd = $_POST['dsd'];
    $dtd = $_POST['dtd'];
    $ds = $_POST['ds'];
    $dfn = $_FILES["dfn"]["name"];

    // insert a record by prepare and bind
    // The argument may be one of four types:
    //  i - integer
    //  d - double
    //  s - string
    //  b - BLOB

    // ในส่วนของ INTO ให้กำหนดให้ตรงกับชื่อคอลัมน์ในตาราง documents
    // ต้องแน่ใจว่าคำสั่ง INSERT ทำงานใด้ถูกต้อง - ให้ทดสอบก่อน
    $sql ="INSERT  
            INTO documents (doc_num, doc_title, doc_start_date, doc_to_date, doc_status, doc_file_name) 
            VALUES (?, ?, ? , ?, ?, ?);";       
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssss", $dnum, $dtitle, $dsd, $dtd,  $ds, $dfn);
    $stmt->execute();

    //uploadpart
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["dfn"]["name"]);
    $fileType="pdf";
    $realname="a.pdf";
    if (move_uploaded_file($_FILES["dfn"]["tmp_name"], $target_file)) {
      //echo "The file ". htmlspecialchars( basename( $_FILES["dfn"]["name"])). " has been uploaded.";
    } else {
      //echo "Sorry, there was an error uploading your file.";
    }
    //

    // redirect ไปยัง documents.php
    header("location: documents.php");
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
    <script>
        function checkdocnum() {
        var doc_num = document.getElementById("dnum").value;
        //document.getElementById("disp").innerHTML = doc_num;
        var xhttp = new XMLHttpRequest();
        console.log("hello");
        xhttp.onreadystatechange = function(){
            if (this.readyState == 4 && this.status ==200 ) {
                //document.getElementById("disp").innerHTML = this.responseText;
                if (this.responseText != ""){
                    document.getElementById("submit").disabled = true;
                    document.getElementById("disp").innerHTML = "<a href='addstafftodocument.php?id=" + 
                    this.responseText + "'>จัดการกรรมการ</a>";
                }else{
                    document.getElementById("submit").disabled = false;
                    document.getElementById("disp").innerHTML = "";
                }
            }
        };
        //console.log("hello");
        xhttp.open("GET", "check_docnum.php?doc_num=" + doc_num, true);
        //console.log("hello");
        xhttp.send();
        }
    </script>
</head>

<body>
    <div class="container">
        <h1>Add an documents</h1>
        <form action="newdocuments.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
                <label for="dnum">เลขที่คำสั่ง</label>
                <input type="text" class="form-control" name="dnum" id="dnum"  onkeyup="checkdocnum()">
                <div id = "disp"></div>
            </div>
            <div class="form-group">
                <label for="dtitle">ชื่อคำสั่ง</label>
                <input type="text" class="form-control" name="dtitle" id="dtitle">
            </div>
            <div class="form-group">
                <label for="dsd">วันที่เริ่มต้นคำสั่ง</label>
                <input type="date" class="form-control" name="dsd" id="dsd">
            </div>
            <div class="form-group">
                <label for="dtd">วันที่สิ้นสุด</label>
                <input type="date" class="form-control" name="dtd" id="dtd">
            </div>
            <div class="form-group">
                <label for="ds">สถานะ</label>
                <input type="radio"  name="ds" id="ds" value="Active"> Active
                <input type="radio"  name="ds" id="ds" value="Expire"> Expire
            </div>
            <div class="form-group">
                <label for="dfn">ชื่อไฟล์เอกสาร</label>
                <input type="file" class="form-group" name="dfn" id="dfn">
            </div>
            <button type="submit" id="submit" class="btn btn-success">Save</button>
        </form>
</body>

</html>