<?php
 
 error_reporting(0);
 session_start();
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

  if(isset($_POST['submit']))
  {
    if(isset($_POST['check'])){
        $checked_array=$_POST['check'];
        
        $next_hop = $_POST["next_hop"];
        $current_status = $_POST["current_status"]; 
        $remarks = $_POST["remarks"]; 

        $sql= "SELECT `name` FROM `login` WHERE `name`= '$next_hop'";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);
    
        $name= $_SESSION['name_who_logged'];
        // $next_hop=$_POST["next_hop"];
        $date_of_receive = $_POST["date_of_receive"];
        $timestamp = strtotime($date_of_receive);
        $date_of_receive = date("d-m-Y", $timestamp);

        $date_of_release=$_POST["date_of_release"];
        $timestamp = strtotime($date_of_release);
        $date_of_release = date("d-m-Y", $timestamp);

        if($next_hop==NULL){
            $forwarder_ender=3;
            $status= "Completed";
        } else {
            $forwarder_ender=2;
            $status= "Forwarded";
        }
         
          
          
        foreach ($_POST['check'] as  $value) {

            $file_no=$value;
          
            $sql2= "SELECT * FROM `file_details` WHERE `file_no` = '$file_no' && `creator` = 'creator'";
            $result1 = mysqli_query($mysqli, $sql2);
            $row = mysqli_fetch_assoc($result1);
            
            $department= $row["department"];
            $designation= $row["designation"];
            $file_description= $row["file_description"];
            $date_of_creation=$row["date_of_creation"];

            $name_of_creator = $row["name_of_creator"];
            $next_hop_from_2 = $name;
            $next_hop_to_2 = $next_hop;
            $date_of_receive_2 = $date_of_receive; 
            $date_of_release_2 = $date_of_release;
            $remarks_2 = $remarks;

            if(!($current_status == "Choose")){
                $sql1 = "UPDATE `file_details` SET `current_status_2` = '$current_status' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `next_hop_from_2` = '$next_hop_from_2' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `next_hop_to_2` = '$next_hop_to_2' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `date_of_receive_2` = '$date_of_receive_2' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `date_of_release_2` = '$date_of_release_2' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `remarks_2` = '$remarks_2' WHERE `file_no` = '$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
            } else {
                $current_status == "";
            }

            if($next_hop == "Choose"){
                $next_hop= "";
            } 
            $sql = "INSERT INTO `file_details`(`file_no`, `file_description`, `name`, `department`, `designation`, `name_of_creator`, `next_hop`, `date_of_creation`, `date_of_receive`, `date_of_release`,  `status`, `forwarder_ender`, `current_status_1`, `current_status_2`, `remarks`,
            `next_hop_from_2`, `next_hop_to_2`, `date_of_receive_2`, `date_of_release_2`, `remarks_2`) 
            VALUES ('$file_no', '$file_description', '$name','$department', '$designation', '$name_of_creator', '$next_hop', '$date_of_creation','$date_of_receive', '$date_of_release', '$status', '$forwarder_ender', '$current_status', '$current_status', '$remarks',
            '$next_hop_from_2', '$next_hop_to_2', '$date_of_receive_2', '$date_of_release_2', '$remarks_2')";
            $result = mysqli_query($mysqli, $sql);
          if($result){ 
              $insert= true;
            //   echo "okay";
            } else {
              echo " not ok";
           }
        //    $names=$_SESSION['name_who_logged'];
           if($next_hop==NULL){
                $sql1 = "UPDATE `file_details` SET `file_status` = 1 WHERE `name` = '$name' && `file_no`='$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
                $sql1 = "UPDATE `file_details` SET `file_status` = 1 WHERE `next_hop` = '$name' && `file_no`='$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
           } else {
                $sql1 = "UPDATE `file_details` SET `file_status` = 1 WHERE `next_hop` = '$name' && `file_no`='$file_no'";
                $result3 = mysqli_query($mysqli, $sql1);
           }

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
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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

            <form class="d-flex" form action="login.php" method="POST">
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
            <br>
            <center>
                <h1>Pending</h1>
            </center>
            <hr> <br>

            <div class="container my-4">
                <form action="/fts-nitttr-kolkata/Pending.php" method="POST">
                    <table class="table" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col" style="width: 115.972px;">File No.</th>
                                <th scope="col">File Description</th>
                                <th scope="col" style="width: 113.556px;">Name of File Creator</th>
                                <th scope="col" style="width: 113.556px;">Date of Creation</th>
                                <th scope="col" >Next Hop</th>
                                <th scope="col" style="width: 417.556px;">Date of Receive</th>
                                <th scope="col" style="width: 417.556px;">Date of Release</th>
                                <th scope="col" style="width: 121.972px;">Current Status</th>
                                <th scope="col" style="width: 115.972px;">Remarks</th>
                                <th scope="col">☑</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php
                                $name_who_logged=$_SESSION['name_who_logged'];
                                $sql = "SELECT * FROM `file_details` WHERE `next_hop` = '$name_who_logged' && `forwarder_ender` = 2  && `file_status` = 0";
                                $result = mysqli_query($mysqli, $sql);
                                $sno = 0;
                                while($row = mysqli_fetch_assoc($result)){ 
                                $sno = $sno + 1;
                                echo "<tr>
                                <th scope='row'>". $sno . "</th>
                                <td>".$row["file_no"]."</td>
                                <td>".$row["file_description"]."</td>
                                ";
                        ?>
<?php                       echo "<td>".$name_who_logged."</td>";
?>
<?php                       echo "<td>".$row["date_of_creation"]."</td>";
?>
                            <td>
                            <div class="input-group mb-3" name="next_hop">
                                    <select class="custom-select" style=" margin-top: 20%; width: 121.972px;" name="next_hop" >
                                    <option selected >Choose</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </td>
                          

            
                            <td>
                                <div class="container my-4">
                                    <div class="form-check">
                                        <div class="form-check-input" name="date_of_receive">
                                            <input type="date" id="date_of_receive" name="date_of_receive" style="width: 130px;">
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="container my-4">
                                    <div class="form-check">
                                        <div class="form-check-input" name="date_of_release">
                                            <input type="date" id="date_of_release" name="date_of_release" style="width: 130px;">
                                        </div>
                                    </div>
                                </div>
                            </td>


                            <td>
                                <div class="input-group mb-3" style="width: 121.972px;" name="current_status" >
                                    <select class="custom-select"  style="margin-top: 20%; width: 121.972px;"  name="current_status" id="current_status">
                                        <option selected>Choose</option>
                                        <option value="Forwarded">Forwarded</option>
                                        <option value="Approved">Approved</option>
                                        <option value="Modify">Modify</option>
                                        <option value="Cancelled">Cancelled</option>
                                        <option value="Closed">Closed</option>
                                    </select>
                                </div>
                            </td>

                            <td>
                                <div class="remarks" name="remarks" style="margin-top: 30%;">
                                    <input type="remarks" name="remarks" style="width: 60px;" placeholder="Remarks">
                                </div>
                            </td>

                            <td>
                                <div class="container my-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="check[]"
                                            value="<?php echo $row["file_no"];?>">

                                    </div>
                                </div>
                            </td>


                    

                            </tr>
                            <?php }  ?>

                        </tbody>
                    </table>

                    <div class="container my-4">
                        <center>
                            <div>
                                <input type="submit" class="btn btn-primary btn-lg" name="submit" value="Enter" />
                            </div>
                        </center>
                    </div>

                    <hr><br>
      <h2>List of Previous Files</h2>
 
 <div class="container">
 <br>
    <table class="table" id="myTables">
        <thead class="table-dark">
            <tr>
                <th scope="col">S.No</th>
                <th scope="col" style="width: 115.972px;">File No.</th>
                <th scope="col">File Description</th>
                <th scope="col" style="width: 83.556px;">Name of File Creator</th>
                <th scope="col" style="width: 83.556px;">Next Hop (From)</th>
                <th scope="col" style="width: 83.556px;">Next Hop (To)</th>
                <th scope="col">Date of Creation</th>
                <th scope="col">Date of Receive</th>
                <th scope="col">Date of Release</th>
                <th scope="col">Current Status</th>
                <th scope="col">Remarks</th>
            </tr>
        </thead>
                   
    <tbody>
       <?php
       
         $sql = "SELECT * FROM `file_details` WHERE `name` = '$name_who_logged' && `forwarder_ender` = 2 || `forwarder_ender` = 3 ORDER BY `sno` DESC LIMIT 100 ";
         $result = mysqli_query($mysqli, $sql);
         $sno = 0;
         while($row = mysqli_fetch_assoc($result)){
           
            $sno = $sno + 1;
            echo "<tr>
            <th scope='row'>". $sno . "</th>
            <td>".$row["file_no"]."</td>
            <td>".$row["file_description"]."</td>
            <td>".$row["name_of_creator"]."</td>
            <td>".$row["next_hop_from_2"]."</td>
            <td>".$row["next_hop_to_2"]."</td>
            <td>".$row["date_of_creation"]."</td>
            <td>".$row["date_of_receive_2"]."</td>
            <td>".$row["date_of_release_2"]."</td>
            <td>".$row["current_status_2"]."</td>
            <td>".$row["remarks_2"]."</td>
          ";
         } 

        ?>
     </tbody>
   </table>
            </div>

            </form>
         </div>
        </div>
    </div>






    <!-- footer -->
    <footer class="bg-dark text-center text-white" style="background-color: rgba(8, 2, 94, 0.2);">
        <!-- Grid container -->
        <div class="container p-4 pb-0">
            <!-- Section: Social media -->
            <section class="mb-4">
                <!-- Facebook -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/NITTTR.Kolkata/"
                    role="button"><i class="fab fa-facebook-f"></i></a>

                <!-- Twitter -->
                <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/nitttr_kolkata"
                    role="button"><i class="fab fa-twitter"></i></a>

                <!-- YouTube -->
                <a class="btn btn-outline-light btn-floating m-1"
                    href="https://www.youtube.com/channel/UCBIhZiRV7b9fzWdDLUlW3yg" role="button"><i
                        class="fab fa-youtube"></i></a>



                <!-- Linkedin -->
                <a class="btn btn-outline-light btn-floating m-1"
                    href="https://www.linkedin.com/in/nitttr-kolkata-520769211/" role="button"><i
                        class="fab fa-linkedin-in"></i></a>

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
        $(document).ready( function () {
          $('#myTables').DataTable();
    } );
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



</body>

</html>