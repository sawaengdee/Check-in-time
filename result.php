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

  <style>
    th,
    td {
      text-align: center;
    }

    img {
      width: 25px;
      height: 25px;
    }
  </style>
</head>

<body>
  <?php
  include("connect.php");

  session_start();
  include("checksession.php");
  $id = $_SESSION['tech_id'];
  if (isset($_GET['exit']) == 1) {
    session_destroy();
    header('Refresh: 0; url = index.php');
  } else {
    $sql = "SELECT fname, lname FROM teacher WHERE tech_id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      $row = mysqli_fetch_assoc($result);
    }
  }
  if (isset($_GET['remove']) && $_GET['remove'] == 'delete') {
    $rfid = $_GET['rfid'];
    echo "<script>";
    echo "Swal.fire({
        title: 'ลบข้อมูล',
        text: 'ต้องการลบข้อมูลใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่,ลบข้อมูลออก',
        cancelButtonText: 'ยกเลิก,การลบข้อมูล'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'result.php?remove=confrim-delete&rfid=" . $rfid . "';
        }else{
          window.location.href = 'result.php';
        }
      });";
  }
  echo "</script>";
  if (isset($_GET['remove']) && $_GET['remove'] == 'confrim-delete') {
    $rfid = $_GET['rfid'];
    $sql = "DELETE FROM history WHERE his_rfid = '$rfid'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
  ?>
      <script>
        Swal.fire({
          icon: "success",
          title: "ลบข้อมูลเสร็จสิ้น",
          showConfirmButton: false,
          timer: 5000
        }).then((result) => {
          if (result.isDismissed) {
            window.location.href = 'result.php';
          }
        });
      </script>

  <?php
    }
  }

  ?>
  <nav class="navbar navbar-expand-md bg-dark py-3" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon" style="height: 85px; width: 85px"><img style="
                  height: 100%;
                  width: 100%;
                  max-height: none;
                  max-width: none;
                  border-radius: auto;
                " src="assets/img/person.png" /></span><span><?php echo $row["fname"] . $row["lname"]; ?></span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
        <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navcol-5">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="stdinfo.php">ข้อมูลนักเรียน</a>
          </li>
          <li class="nav-item"><a class="nav-link active" href="result.php">ผลการบันทึก</a></li>
          <li class="nav-item">
            <a class="nav-link" href="homepage.php">ข้อมูลติดต่อ</a>
          </li>
        </ul>
        <a class="btn btn-primary ms-md-2" role="button" href="homepage.php?exit=1">ออกจากระบบ</a>
      </div>
    </div>
  </nav>

  <div style="margin-top: 140px">
    <div style="text-align-last: end; margin-bottom: 10px;">
      <!-- <a href="check_rfid.php" type="button" class="btn btn-primary"  >เพิ่มข้อมูลนักเรียน</a> -->

    </div>
    <div class="table-responsive-sm">
      <table class="table table-hover table-bordered text-justify" style="height: 100px;">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="align-middle">รหัสนักศึกษา</th>
            <th scope="col" class="align-middle">ระดับชั้น</th>
            <th scope="col" class="align-middle">สาขาวิชา</th>
            <th scope="col" class="align-middle">คำนำหน้า</th>
            <th scope="col" class="align-middle">ชื่อ</th>
            <th scope="col" class="align-middle">สกุล</th>
            <th scope="col" class="align-middle"> ลงเวลา</th>
            <th scope="col" class="align-middle">วันที่</th>
            <th scope="col" class="align-middle">การดำเนินการ</th>
          </tr>
        </thead>
        <?php
        $sql = " SELECT * FROM student INNER JOIN history ON student.rfid = history.his_rfid";
        $result =  mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tbody>
              <tr>
                <td><?php echo $row["id"] ?></td>
                <td>
                  <?php if ($row['level'] == 1) {
                    echo "ปวช.1";
                  }
                  if ($row['level'] == 2) {
                    echo "ปวช.2";
                  }
                  if ($row['level'] == 3) {
                    echo "ปวช.3";
                  }
                  if ($row['level'] == 4) {
                    echo "ปวส.1";
                  }
                  if ($row['level'] == 5) {
                    echo "ปวส.2";
                  }
                  ?>
                </td>
                <td>
                  <?php if ($row['major'] == 1) {
                    echo "ซอฟต์แวร์ระบบสมองกลฝังตัวฯ";
                  }
                  if ($row['major'] == 2) {
                    echo "คอมพิวเตอร์ธุระกิจ";
                  }
                  if ($row['major'] == 3) {
                    echo "นักพัฒนาซอฟต์แวร์";
                  }
                  if ($row['major'] == 4) {
                    echo "ธุระกิจดิจิทัล";
                  }
                  ?>
                </td>
                <td>
                  <?php if ($row['prename'] == 1) {
                    echo "ด.ญ";
                  }
                  if ($row['prename'] == 2) {
                    echo "ด.ช";
                  }
                  if ($row['prename'] == 3) {
                    echo "นาย";
                  }
                  if ($row['prename'] == 4) {
                    echo "นางสาว";
                  }
                  ?>
                </td>
                <td><?php echo $row["fname"] ?></td>
                <td><?php echo $row["lname"] ?></td>
                <td><?php echo $row["time_check"] ?></td>
                <td><?php echo $row["date_check"] ?></td>
                <td>
                    <a href="result.php?rfid=<?php echo $row["rfid"] ?>&remove=delete" type="button" class="btn btn-outline-danger" name="remove">ลบ</a>
                </td>
              </tr>
          <?php }
        } ?>
            </tbody>
      </table>
    </div>
  </div>
  <div style="text-align-last: end; margin-bottom: 10px;">
    <!-- <button type="button" class="btn btn-outline-success"><img src="img/excel.png" style="height: 25px; width: 25px;"> พิมพ์ข้อมูล</button> -->
  </div>
  </div>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>