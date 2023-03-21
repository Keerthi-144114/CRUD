<?php

    $existAcc=false;
    $createAcc=false;
    $wrongMatch=false;
    if($_SERVER['REQUEST_METHOD']=='POST')
    {
        
        if(isset($_POST['createNewAcc']))
        {
            require "_db_connect.php";
            $userName=$_POST['userName'];
            $password=$_POST['password'];
            $cpassword=$_POST['cpassword'];

            $sql="SELECT * FROM `users` WHERE userName='$userName'";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo "fail";
            }
            $rows=mysqli_num_rows($result);
            if($rows>0)
            {
                $existAcc=true;
            }
            else{
                if($password==$cpassword){
                    $sql="INSERT INTO `users` ( `userName`, `password`) VALUES ('$userName', '$password')";
                    $result=mysqli_query($conn,$sql);
                    if($result)
                    {
                        $createAcc=true;
                    }
                
                }
                else{
                        $wrongMatch=true;
                }
            }
        }
        if(isset($_POST['login']))
        {
            if($conn)
                    {
                        $conn->close();
                    }
            header("location:login.php");
        }
    }

    

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>CRUD</title>
    <style>
        .container h1{
            text-align:center;
        }
        body{
                background-image:url('images/bg6.jpg');

            }
        .container form{
            margin-left: 352px;margin-right: -98px;
        }
    </style>
  </head>
  <body>

    <?php
         if($existAcc)
         {
             echo "<div class='alert alert-danger alert-dismissible fade show text-dark' role='alert'>";
                 echo "<strong>Account creation failed!</strong> User name already exists!";
                 echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                     echo "<span aria-hidden='true'>&times;</span>";
                 echo "</button>";
            echo " </div>";
              // echo "<script>window.location='index.php'</script>";
         }
         if($createAcc)
         {
             echo "<div class='alert alert-success alert-dismissible fade show text-dark' role='alert'>";
                 echo "<strong>Success!</strong> Your account has been crated successfully.";
                 echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                     echo "<span aria-hidden='true'>&times;</span>";
                 echo "</button>";
            echo " </div>";
              // echo "<script>window.location='index.php'</script>";
         }
         if($wrongMatch)
         {
             echo "<div class='alert alert-danger alert-dismissible fade show text-dark' role='alert'>";
                 echo "<strong>Account creation failed!</strong> Passwords don't match";
                 echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                     echo "<span aria-hidden='true'>&times;</span>";
                 echo "</button>";
            echo " </div>";
              // echo "<script>window.location='index.php'</script>";
         }
    ?>
    
    <div class="container my-5 text-black text-white">
        <h1><strong>Welcome to CRUD!</strong></h1>
        <form action="/crud/createAcc.php" method="post">
            <div class="form-group my-4 col-md-6">
                <label for="userName">User Name</label>
                <input type="text" class="form-control" maxlength="20" id="userName" name="userName" aria-describedby="emailHelp">
               
            </div>
            <div class="form-group my-4 col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" maxlength="12" id="password" name="password">
            </div>
            <div class="form-group my-4 col-md-6">
                <label for="cpassword">Confirm Password</label>
                <input type="password" class="form-control" maxlength="12" id="cpassword" name="cpassword">
            </div>
            
            <div class="form-group mx-3">
            <button type="submit" class="btn btn-primary bg-success" name="createNewAcc">Create Account</button>
            <button type="submit" class="btn btn-primary bg-success mr-4" name="login">Login</button>
            
            </div>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>