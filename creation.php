<?php
 
 error_reporting(0);
 session_start();
 $invalid_name=false;
 ?>
 
 <?php
if($_SESSION['loggedin']){
} else {
  header("Location: login.php");
  exit();
}
?>

 <?php
    if (isset($_POST['logout'])){
      header("Location: login.php");
      session_unset();
      session_destroy();
    }
?>
<?php 
$dbhost= "localhost";
$dbuser= "root";
$dbpass= "";
  $dbname= "office_automation";
  $mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
  if($mysqli->connect_errno){
      echo "Error Occured" . $mysqli->connect_error;
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['submit'])){
      // echo "ok";
      // update the record
    $next_hop = $_POST["next_hop"]; 
    $remarks = $_POST["remarks"];
    $sql= "SELECT `name` FROM `login` WHERE `name`= '$next_hop'";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    if($row>0){

        $file_description = $_POST["file_description"];
        // $name = $_POST["name"];
        $date_of_creation = $_POST["date_of_creation"];
        $timestamp = strtotime($date_of_creation);
        $date_of_creation = date("d-m-Y", $timestamp);

        $date_of_receive = $_POST["date_of_creation"];
        $timestamp = strtotime($date_of_receive);
        $date_of_receive = date("d-m-Y", $timestamp);

        $date_of_release = $date_of_creation;
        $username= $_SESSION['username'];
        $sql= "SELECT `name`, `department`, `designation` FROM `login` WHERE `username`= '$username'";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);
        $name= $row["name"];
        $department= $row["department"];
        $designation= $row["designation"];
        if($next_hop==NULL){
          $forwarder_ender=3;
        } else {
            $forwarder_ender=2;
        }
        $sql2= "SELECT * FROM `file_details` WHERE `creator` = 'creator' ORDER BY sl_no DESC LIMIT 100";
        $result1 = mysqli_query($mysqli, $sql2);
        $row = mysqli_fetch_assoc($result1);
        $last_si_no= $row["sl_no"];
        $last_si_no= $last_si_no+1;

        $sql2= "SELECT * FROM `file_details` ORDER BY sno DESC LIMIT 1";
        $result1 = mysqli_query($mysqli, $sql2);
        $row = mysqli_fetch_assoc($result1);
        if($row<1){
          $last_sl_no= 1;
        } else {
          $last_sl_no= $row["sno"];   
        }
        $name_of_creator = $name;
        $next_hop_from_2 = $name;
        $next_hop_to_2 = $next_hop;
        $date_of_receive_2 = $date_of_receive; 
        $date_of_release_2 = $date_of_release;
        $remarks_2 = $remarks;
        $status= "Forwarded";
        $creator="creator";
        $current_status="Created";
        $si_no= $last_sl_no+1;
        $file_no= "NITTTRK/".$department."/2021-22/".$last_si_no;
        $sql = "INSERT INTO `file_details`(`sl_no`, `file_no`, `file_description`, `name`, `department`, `designation`, `name_of_creator`, `next_hop`, `date_of_creation`,`date_of_receive`, `date_of_release`, `status`, `forwarder_ender`, `creator`, `remarks`,
         `current_status_1`, `current_status_2`, `next_hop_from_2`, `next_hop_to_2`, `date_of_receive_2`, `date_of_release_2`, `remarks_2`) 
        VALUES ('$last_si_no', '$file_no', '$file_description', '$name','$department', '$designation', '$name_of_creator', '$next_hop', '$date_of_creation','$date_of_receive', '$date_of_release', '$status', '$forwarder_ender', '$creator', '$remarks', 
        '$current_status', '$current_status', '$next_hop_from_2', '$next_hop_to_2', '$date_of_receive_2', '$date_of_release_2', '$remarks_2')";
        $result = mysqli_query($mysqli, $sql);
        if($result){ 
            $insert= true;
            // echo "okay";
          } else {
            echo " not ok";
        }

      } else {
        $invalid_name=true;
      }
    
    }
  }
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['delete'])){
    $dbhost= "localhost";
    $dbuser= "root";
    $dbpass= "";
    $dbname= "office_automation";
    $mysqli =mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    $sl_no="SELECT 'sl_no' FROM 'file_details' WHERE 'sl_no'>'0'";
    if (!empty($sl_no)) {
  
      $sql="DELETE FROM file_details WHERE sl_no=(SELECT MAX(sl_no) FROM file_details)";
      $result= mysqli_query($mysqli,$sql);
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/style.css">
  <!-- Bootstrap CSS -->


  <!-- form1 previous build forms css source bootstrap -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <!-- features  css -->

  <!-- head -->

  <!-- Bootstrap core CSS -->
  <link href="/docs/5.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Favicons -->
  <link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
  <link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
  <link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
  <link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
  <meta name="theme-color" content="#7952b3">

  <!-- fontawesome -->
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">


  <!-- Custom styles for this template -->
  <link href="features.css" rel="stylesheet">


  <title>FTS-NITTTR KOLKATA</title>
</head>

<body>

  <!-- navigation bar testing okay! -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark pt-3 pb-3">
    <img src="/fts-nitttr-kolkata/images/logo.jpg" height="55px" width="55px" alt="">
    <div class="container-fluid">
      <h1>
        <a class="navbar-brand" href="">OFFICE AUTOMATION SYSTEM</a>
      </h1>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          <!-- <a class="nav-link" href="login.php">Home</a> -->
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link active" aria-current="page" href="creation.php">Creation</a>
          <!-- <a class="nav-link" href="login.php">Admin</a> -->
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
          <a class="nav-link active" href="Pending.php">Pending</a>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <!-- <a class="nav-link active" aria-current="page" href="#">Home</a> -->
          <a class="nav-link active" href="tracking.php">Tracking</a>
        </div>
      </div>

      <form class="d-flex" form action="creation.php" method="POST">
        <input type="submit" class="btn btn-danger" name="logout" value="Logout">
      </form>
  </nav>






  <!-- Webpage Sidebar (Dashboard ) -->
  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
      </div>
      <h1><a href="" class="logo"></a></h1>
      <ul class="list-unstyled components mb-5">
        <li class="active">
          <a href="index.php"><span class="fa fa-home mr-3"></span> Homepage</a>
        </li>
        <li>
          <a href="Creation.php"><span class="fa fa-user mr-3"></span> Creation</a>
        </li>
        <li>
          <a href="Pending.php"><span class="fa fa-shopping-cart mr-3"></span> Pending</a>
        </li>
        <li>
          <a href="Tracking.php"><span class="fa fa-paper-plane mr-3"></span>Tracking</a>
        </li>
      </ul>
    </nav>

    <!-- Page Content  -->
   
    <div class="container my-4 "><br>

    <?php
  if($invalid_name){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Invalid Next Hop. PLease try again</strong> .
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>×</span>
      </button>
    </div>";
  }
  ?>


    <br><center><h1>Creation</h1></center><hr> <br>
<form action="/fts-nitttr-kolkata/creation.php" method="POST">
    <div class="form-group">
      <label for="File Description" class="form-label">File Description </label>
      <textarea class="form-control" id="file_description" name="file_description" rows="3"  autofocus=""></textarea>
    </div>
<!-- 
    <div class="form-group" >
      <label for="Name of File Creator" class="form-label">Name of File Creator</label>
      <input type="text" class="form-control" id="accession_no" name= "name" aria-describedby="emailHelp">
    </div> -->

    <div class="form-group">
      <label for="Next Hop" class="form-label">Next Hop</label>
      <input type="text" class="form-control" id="next_hop" name= "next_hop">
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1" class="form-label">Date of Creation of File</label>
      <input type="date" class="form-control" id="date_of_creation" name= "date_of_creation">
    </div>

    <div class="form-group">
      <label for="Remarks" class="form-label">Remarks</label>
      <input type="text" class="form-control" id="remarks" name= "remarks">
    </div>

  <div class="mb-3">
  </div>
  <div class="submit_reset" style="margin-top: 30px;">
      <button type="submit" class="btn btn-primary btn-lg" name="submit" >Submit</button>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <button type="reset" class="btn btn-primary btn-lg"value="Reset">Cancel</button>
  </div>

<div class="heading">
      <h2>List of Created Files</h2>
 
 <div class="container my-4">

<table class="table" assign="center" id="myTable">
  <thead class="table-dark">
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">File No.</th>
      <th scope="col">File Description</th>
      <th scope="col">Name of File Creator</th>
      <th scope="col">Next Hop (From)</th>
      <th scope="col">Next Hop (To)</th>
      <th scope="col">Date of Creation</th>
      <th scope="col">Date of Receive</th>
      <th scope="col">Date of Release</th>
      <th scope="col">Current Status</th>
      <th scope="col">Remarks</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $name_who_logged=$_SESSION['name_who_logged'];
    $sql = "SELECT * FROM `file_details` WHERE `creator`= 'creator' && `name` = '$name_who_logged'";
    $result = mysqli_query($mysqli, $sql);
    $sno = 0;
    while($row = mysqli_fetch_assoc($result)){
      $sno = $sno + 1;
      echo "<tr>
      <th scope='row'>". $sno . "</th>
      <td>".$row["file_no"]."</td>
      <td>".$row["file_description"]."</td>
      <td>".$row["name"]."</td>
      <td>".$row["next_hop_from_2"]."</td>
      <td>".$row["next_hop_to_2"]."</td>
      <td>".$row["date_of_creation"]."</td>
      <td>".$row["date_of_receive_2"]."</td>
      <td>".$row["date_of_release_2"]."</td>
      <td>".$row["current_status_2"]."</td>
      <td>".$row["remarks_2"]."</td>
      </tr>";
    } 
    ?>
  </tbody>
</table>
<div align="center">
 <button type="delete" onclick="delete" class="btn btn-primary btn-lg" name="delete" >Delete</button>
 </div>
</div>

  
  </div>
  </div>
  
  </div>



  <!-- footer -->
  <footer class="bg-dark text-center text-white" style="background-color: rgba(8, 2, 94, 0.2);">
    <!-- Grid container -->
    <div class="container p-4 pb-0" >
      <!-- Section: Social media -->
      <section class="mb-4">
        <!-- Facebook -->
        <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/NITTTR.Kolkata/"
          role="button"><i class="fab fa-facebook-f"></i></a>

        <!-- Twitter -->
        <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/nitttr_kolkata" role="button"><i
            class="fab fa-twitter"></i></a>

        <!-- YouTube -->
        <a class="btn btn-outline-light btn-floating m-1"
          href="https://www.youtube.com/channel/UCBIhZiRV7b9fzWdDLUlW3yg" role="button"><i
            class="fab fa-youtube"></i></a>



        <!-- Linkedin -->
        <a class="btn btn-outline-light btn-floating m-1" href="https://www.linkedin.com/in/nitttr-kolkata-520769211/"
          role="button"><i class="fab fa-linkedin-in"></i></a>

      </section>
      <!-- Section: Social media -->
    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(8, 2, 94, 0.2); height: 70px;
width: 100%;">
      Website Designed at NITTTR, Kolkata and All Rights Reserved
      <a class="text-white" href="www.nitttrkol.ac.in"> </a>
    </div>
    <!-- Copyright -->
  </footer>






  <span class="border border-dark"></span>
  <!-- javascript source of sidebar -->
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>


  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  </script>

  <script src="/docs/5.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
<!-- kscks -->


</body>

</html>