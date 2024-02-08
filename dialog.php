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
    $id = $_GET['id'];
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
          window.location.href = 'dialog.php?remove=confrim-delete&id=" . $id . "';
        }else{
          window.location.href = 'dialog.php';
        }
      });";
  }
  echo "</script>";
  if (isset($_GET['remove']) && $_GET['remove'] == 'confrim-delete') {
    $id = $_GET['id'];
    $sql = "DELETE FROM history WHERE his_id = '$id'";
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
            window.location.href = 'dialog.php';
          }
        });
      </script>

  <?php
    }
  }

  ?>

  <div>
    <div style="text-align-last: end; margin-bottom: 10px;">
      <!-- <a href="check_rfid.php" type="button" class="btn btn-primary"  >เพิ่มข้อมูลนักเรียน</a> -->

    </div>
    <div class="table-responsive-sm">
      <table class="table table-hover table-bordered text-justify" style="height: 100px;">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="align-middle">หมายเลขไอดี</th>
            <th scope="col" class="align-middle"> ลงเวลา</th>
            <th scope="col" class="align-middle">วันที่</th>
            <th scope="col" class="align-middle">การดำเนินการ</th>
          </tr>
        </thead>
        <?php
        $sql = " SELECT * FROM  history ";
        $result =  mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
          // output data of each row
          while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <tbody>
              <tr>
                
                <td><?php echo $row["his_rfid"] ?></td>
                <td><?php echo $row["date_check"] ?></td>
                <td><?php echo $row["time_check"] ?></td>
                <td>
                    <a href="dialog.php?id=<?php echo $row["his_id"] ?>&remove=delete" type="button" class="btn btn-outline-danger" name="remove">ลบ</a>
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