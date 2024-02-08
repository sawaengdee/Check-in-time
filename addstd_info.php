<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
  <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no"/>
        <title>ประวัติ</title>
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css" />
        <link rel="stylesheet" href="assets/css/Navbar-Centered-Brand-Dark-icons.css" />
        <link rel="stylesheet" href="assets/css/styles.css" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css" rel="stylesheet">
        <style>
            body{
                background-color: #eee;
                display: flex;
                width: 100vw;
                height: 100vh;
                justify-content: center;
                align-items: center;
            }
            .from{
                width: 500px;
            }
        </style>
    </head>
    <body>
        <?php 
            include("connect.php");
            $sql = "SELECT * FROM esp8266 WHERE id = 1";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
                $serNum0 = $row['serNum0'];
                $serNum1 = $row['serNum1'];
                $serNum2 = $row['serNum2'];
                $serNum3 = $row['serNum3'];
                $serNum4 = $row['serNum4'];

            if(isset($_POST["ok"])){
                $rfid = trim($_POST['rfid']); //หมายเลข RFID
                $id = trim($_POST['id']); //หมายเลขรหัสนักศึกษา
                $ser_n = trim($_POST['ser_n']); //หมายเลขประชาชน
                $level = trim($_POST['level']); //ระดับชั้น
                $major = trim($_POST['major']); //สาขาวิชา
                $prename = trim($_POST['prename']); //คำนำหน้า
                $fname = trim($_POST['fname']); //ชื่อ
                $lname = trim($_POST['lname']); //นามสกุล
                $sql ="INSERT INTO student (rfid,id,ser_n,level,major,prename,fname,lname) VALUES ('$rfid' , '$id' , '$ser_n' , '$level' , '$major' , '$prename' , '$fname' , '$lname')";
                mysqli_multi_query($conn, $sql);
                header('Refresh: 0; url = stdinfo.php');
            }
        ?>
        <form method="post" action="addstd_info.php">
        <div class="from">
            <center><h1>เพิ่มข้อมูลนักเรียน</h1> </center> <br>
            <div class="input-group mb-1 border border-2">
                <span class="input-group-text" id="inputGroup-sizing-default">หมายเลขไอดี</span>
                <input name="rfid" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default " 
                value="<?php echo $serNum0 . "-" . $serNum1 . "-" . $serNum2 . "-" . $serNum3 . "-" . $serNum4 ?>" readonly>
            </div>
            <div class="input-group mb-1 border border-2">
                <span class="input-group-text" id="inputGroup-sizing-default">รหัสนักศึกษา</span>
                <input name="id" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-1 border border-2">
                <span class="input-group-text" id="inputGroup-sizing-default">หมายเลขประชาชน</span>
                <input name="ser_n" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>            
            <div class="input-group mb-1">
                <label class="input-group-text" for="inputGroupSelect01">ระดับชั้น</label>
                <select class="form-select" id="inputGroupSelect01" name="level">
                    <option selected>เลือก...</option>
                    <option value="1">ปวช.1</option>
                    <option value="2">ปวช.2</option>
                    <option value="3">ปวช.3</option>
                    <option value="4">ปวส.1</option>
                    <option value="5">ปวส.2</option>
                </select>
                <label class="input-group-text" for="inputGroupSelect01">สาขาวิชา</label>
                <select class="form-select" id="inputGroupSelect01" name="major">
                    <option selected>เลือก...</option>
                    <option value="1">ซอฟต์แวร์ระบบสมองกลฝังตัวฯ</option>
                    <option value="2">คอมพิวเตอร์ธุระกิจ</option>
                    <option value="3">นักพัฒนาซอฟต์แวร์</option>
                    <option value="4">ธุระกิจดิจิทัล</option>
                </select>
            </div>
            <div class="input-group mb-1">
                <label class="input-group-text" for="inputGroupSelect01">คำนำหน้า</label>
                <select class="form-select" id="inputGroupSelect01" name="prename">
                    <option selected>เลือก...</option>                    
                    <option value="3">นาย</option>
                    <option value="4">นางสาว</option>
                    <option value="1">ด.ช</option>
                    <option value="2">ด.ญ</option>

                </select>
            </div>

            <div class="input-group mb-1 border border-2">
                <span class="input-group-text" id="inputGroup-sizing-default">ชื่อ</span>
                <input name="fname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
            <div class="input-group mb-1 border border-2">
                <span class="input-group-text" id="inputGroup-sizing-default">สกุล</span>
                <input name="lname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
            </div>
                <center>
                    <button type="submit" class="btn btn-success" name="ok">ยืนยัน</button>
                    <a href="stdinfo.php" type="button" class="btn btn-danger">ยกเลิก</a>
                </center>
        </div>
        </form>
        
     
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
