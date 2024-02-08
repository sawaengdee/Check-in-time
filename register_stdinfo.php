<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>ประวัติ</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css" />
    <link rel="stylesheet" href="assets/css/Navbar-Centered-Brand-Dark-icons.css" />
    <link rel="stylesheet" href="assets/css/styles.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once("connect.php");
    
    $serNum0 = $_GET["serNum0"];
    $serNum1 = $_GET["serNum1"];
    $serNum2 = $_GET["serNum2"];
    $serNum3 = $_GET["serNum3"];
    $serNum4 = $_GET["serNum4"];
    $sql = "UPDATE esp8266 SET serNum0 = '$serNum0' , serNum0 = '$serNum0' , serNum1 = '$serNum1' , serNum2 = '$serNum2' , serNum3 = '$serNum3' , serNum4 = '$serNum4' WHERE id=1";
    mysqli_query($conn, $sql);

    $rfid = $serNum0 . "-" . $serNum1 . "-" . $serNum2 . "-" . $serNum3 . "-" . $serNum4;

    date_default_timezone_set('asia/bangkok');
    $date = date("Y-m-d");
    $time = date('h:i:s');

    $sql = "SELECT * FROM history where date_check = '$date' and his_rfid = '$rfid'";
    $result =  mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO history (his_id, his_rfid, date_check, time_check) VALUES ('', '$rfid', '$date', '$time')";
        mysqli_query($conn, $sql);
    }



    ?>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>