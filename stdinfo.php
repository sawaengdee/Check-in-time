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
          window.location.href = 'stdinfo.php?remove=confrim-delete&rfid=" . $rfid . "';
        }else{
          window.location.href = 'stdinfo.php';
        }
      });";
  }
  echo "</script>";
  if (isset($_GET['remove']) && $_GET['remove'] == 'confrim-delete') {
    $rfid = $_GET['rfid'];
    $sql = "DELETE FROM student WHERE rfid = '$rfid'";
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
            window.location.href = 'stdinfo.php';
          }
        });
      </script>

  <?php
    } else {
    }
  }

  if (isset($_POST['savenaja'])) {
    $rfid = $_POST['rfid'];
    $level = $_POST['level'];
    $major = $_POST['major'];
    $prename = $_POST['prename'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $sql = "UPDATE student 
    SET level = '$level' , major = '$major' , prename = '$prename' , fname = '$fname' , lname = '$lname' 
    WHERE rfid='$rfid'";
    mysqli_query($conn, $sql);
    // echo json_encode($_POST);
    header('Refresh: 0; url = stdinfo.php');
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
                " src="assets/img/person.png" /></span><span><?php echo $row["fname"] . " " . $row["lname"]; ?></span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-5">
        <span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navcol-5">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="stdinfo.php">ข้อมูลนักเรียน</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="result.php">ผลการบันทึก</a></li>
          <li class="nav-item">
            <a class="nav-link " href="homepage.php">ข้อมูลติดต่อ</a>
          </li>
        </ul>
        <a class="btn btn-primary ms-md-2" role="button" href="homepage.php?exit=1">ออกจากระบบ</a>
      </div>
    </div>
  </nav>

  <div style="margin-top: 100px">
    <div style="text-align-last: end; margin-bottom: 10px;">
      <a href="check_rfid.php" type="button" class="btn btn-primary">เพิ่มข้อมูลนักเรียน</a>

    </div>
    <div class="table-responsive-sm">
      <table class="table table-hover table-bordered text-justify" style="height: 100px;">
        <thead class="table-primary">
          <tr>
            <th scope="col" class="align-middle">หมายเลขไอดี</th>
            <th scope="col" class="align-middle">รหัสนักศึกษา</th>
            <th scope="col" class="align-middle">ระดับชั้น</th>
            <th scope="col" class="align-middle">สาขาวิชา</th>
            <th scope="col" class="align-middle">คำนำหน้า</th>
            <th scope="col" class="align-middle">ชื่อ</th>
            <th scope="col" class="align-middle">สกุล</th>
            <th scope="col" class="align-middle">การดำเนินการ</th>
          </tr>
        </thead>
        <?php
        $sql = "SELECT * FROM student";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
        ?>
            <tbody>
              <tr>
                <td><?php echo $row["rfid"] ?></td>
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
                    echo "ด.ช";
                  }
                  if ($row['prename'] == 2) {
                    echo "ด.ญ";
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
                <td>
                  <button type="button" class="btn btn-outline-warning" name="edit" data-bs-toggle="modal" data-bs-target="#editform<?php echo $row["rfid"] ?>">แก้ไข</button>
                  <a href="stdinfo.php?rfid=<?php echo $row["rfid"] ?>&remove=delete" type="button" class="btn btn-outline-danger" name="remove">ลบ</a>
                </td>
              </tr>
              <!-- modal form -->

              <div class="modal fade" id="editform<?php echo $row["rfid"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post" action="stdinfo.php">
                      <div class="modal-body">
                        <div class="from">
                          <center>
                            <h1>แก้ไขข้อมูล</h1>
                          </center> <br>
                          <div class="input-group mb-1 border border-2">
                            <span class="input-group-text">หมายเลขไอดี</span>
                            <input name="rfid" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default " value="<?php echo $row['rfid'] ?>" readonly>
                          </div>
                          <div class="input-group mb-1 border border-2">
                            <span class="input-group-text">รหัสนักศึกษา</span>
                            <input name="id" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['id'] ?>" readonly>
                          </div>
                          <div class="input-group mb-1 border border-2">
                            <span class="input-group-text">หมายเลขประชาชน</span>
                            <input name="ser_n" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['ser_n'] ?>" readonly>
                          </div>
                          <div class="input-group mb-1">
                            <label class="input-group-text" for="inputGroupSelect01">ระดับชั้น</label>
                            <select class="form-select" id="inputGroupSelect01" name="level">
                              <option disabled>เลือก...</option>
                              <option value="1" <?php $row['level'] == 1 ? 'selected' : null ?>>ปวช.1</option>
                              <option value="2" <?php $row['level'] == 2 ? 'selected' : null ?>>ปวช.2</option>
                              <option value="3" <?php $row['level'] == 3 ? 'selected' : null ?>>ปวช.3</option>
                              <option value="4" <?php $row['level'] == 4 ? 'selected' : null ?>>ปวส.1</option>
                              <option value="5" <?php $row['level'] == 5 ? 'selected' : null ?>>ปวส.2</option>
                            </select>
                            <label class="input-group-text" for="inputGroupSelect01">สาขาวิชา</label>
                            <select class="form-select" id="inputGroupSelect01" name="major" value="<?php echo $row['major'] ?>">
                              <option disabled>เลือก...</option>
                              <option value="1" <?php $row['major'] == 1 ? 'selected' : null ?>>ซอฟต์แวร์ระบบสมองกลฝังตัวฯ</option>
                              <option value="2" <?php $row['major'] == 2 ? 'selected' : null ?>>คอมพิวเตอร์ธุระกิจ</option>
                              <option value="3" <?php $row['major'] == 3 ? 'selected' : null ?>>นักพัฒนาซอฟต์แวร์</option>
                              <option value="4" <?php $row['major'] == 4 ? 'selected' : null ?>>ธุระกิจดิจิทัล</option>
                            </select>
                          </div>
                          <div class="input-group mb-1">
                            <label class="input-group-text" for="inputGroupSelect01">คำนำหน้า</label>
                            <select class="form-select" id="inputGroupSelect01" name="prename">
                              <option disabled>เลือก...</option>
                              <option value="3" <?php $row['prename'] == 3 ? 'selected' : null ?>>นาย</option>
                              <option value="4" <?php $row['prename'] == 4 ? 'selected' : null ?>>นางสาว</option>
                              <option value="1" <?php $row['prename'] == 1 ? 'selected' : null ?>>ด.ช</option>
                              <option value="2" <?php $row['prename'] == 2 ? 'selected' : null ?>>ด.ญ</option>
                            </select>
                          </div>

                          <div class="input-group mb-1 border border-2">
                            <span class="input-group-text">ชื่อ</span>
                            <input name="fname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['fname'] ?>">
                          </div>
                          <div class="input-group mb-1 border border-2">
                            <span class="input-group-text">สกุล</span>
                            <input name="lname" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" value="<?php echo $row['lname'] ?>">
                          </div>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="submitFF" class="btn btn-primary" name="savenaja">บันทึก</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

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