<?php
    session_start();
    if(!isset($_SESSION['loggedin']))
    {
        header("location:createAcc.php");
        exit;
    }
?>
<?php
$insert=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="bmsit123@";
$dbname="users7676";

$conn=mysqli_connect($servername,$username,$password,$dbname);

if(!$conn)
{
    die("Connection failed".$mysqli_connect_error());
}
$email=$_SESSION['email'];
// echo var_dump($email);
$table_name=$_SESSION['userName'];
$sql = "SHOW TABLES LIKE '$table_name'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 0){

    $sql="CREATE TABLE `users7676`.`$table_name` (`sno` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(20) NOT NULL , `description` VARCHAR(100) NOT NULL , `complitionDate` DATE NOT NULL , `date` TIMESTAMP NOT NULL , PRIMARY KEY (`sno`)) ENGINE = InnoDB";
    $result=mysqli_query($conn, $sql);

    if(!$result){
        echo "table creation failed";
    }

}


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['update']))
    {
        $titleEdit=$_POST["titleEdit"];
        $descriptionEdit=$_POST["descriptionEdit"];
        $hiddenSNO=$_POST["hiddenSno"];
        // echo var_dump($_POST["hiddenSno"]);
        $date=$_POST["complitionDate"];
        $pattern = "/(https?:\/\/[^\s]+)/";
        $replacement = '<a href="$1">$1</a>';

        $descriptionEdit = preg_replace($pattern, $replacement, $descriptionEdit);

        $sql="UPDATE `$table_name` SET `title` = '$titleEdit', `description` = '$descriptionEdit', `complitionDate` = '$date' WHERE `$table_name`.`sno` = $hiddenSNO";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $update=true;
        }
        else{
            echo "Update failed".mysqli_error($conn);
        }
    }
    if(isset($_POST['delete']))
    {
        $hiddenSNO=$_POST["snoDeleted"];
        
        $sql="DELETE FROM `$table_name` WHERE `$table_name`.`sno` = '$hiddenSNO'";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $delete=true;
        }
        else{
            echo "Sorry failed to delete".mysqli_error($conn);
        }
    }
    if(isset($_POST['submit']))
    {
        $title=$_POST["title"];
        $description=$_POST["description"];
        $date=$_POST["complitionDate"];
        $pattern = "/(https?:\/\/[^\s]+)/";
        $replacement = '<a href="$1">$1</a>';

        $description = preg_replace($pattern, $replacement, $description);

        $sql="INSERT INTO `$table_name` ( `title`, `description`, `complitionDate`) VALUES ('$title', '$description', '$date');";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $insert=true;
        }
        else{
            echo "Insertion failed".mysqli_error($conn);
        }
    }
    if(isset($_POST['logout']))
    {
        session_destroy();
        $conn->close();
        header("location:createAcc.php");
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

        <link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
    
        <title>i-Notes</title>
        <style>
            .navbar-brand img{
                border-radius:20px;
                height:50px;
                width:80px;
            }
            body{
                background-image:url('images/bg6.jpg');

            }
            *{
                color:white;
            }
        </style>
    
    </head>
    <body>

        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
        Launch demo modal
        </button> -->

        <!--edit Modal -->
        <div class="modal fade text-dark " id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/crud/index.php" method="post">
                    <input type="hidden" name="hiddenSno" id="hiddenSno">
                    <div class="form-group ">
                        <label for="title">Edit Title</label>
                        <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="description">Edit Note Description</label>
                        <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                    <label for="Complition Date">Complition Date</label>
                    <input type="date" class="form-control" id="complitionDate" name="complitionDate" aria-describedby="emailHelp">
                </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary bg-success">Save Changes</button>
                    </div>
                    </div>
                </form>
            </div>
            
        </div>
        </div>

        <!-- delete modal  -->

        <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel" >Delete this Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/crud/index.php" method="post">
                    <input type="hidden" name="snoDeleted" id="snoDeleted">
                    <h6>Are you sure. You want to delete the note.</h6>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" name="delete" class="btn btn-primary bg-success">Yes</button>
                    </div>
                    </div>
                </form>
            </div>
            
        </div>
        </div>


        <!-- logout modal  -->
        
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Logouts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/crud/index.php" method="post">
                    
                    <h6>Are you sure. You want to Logout.</h6>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                        <button type="submit" name="logout" class="btn btn-primary bg-success">Yes</button>
                    </div>
                    </div>
                </form>
            </div>
            
        </div>
        </div>


        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href="index.php">
                <img src="images/lmg.jpg"  class="d-inline-block align-top" alt="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><h5>Welcome to I-Notes -<?php echo strtoupper($_SESSION['userName'])."!";?></h5> <span class="sr-only">(current)</span></a>
                </li>
            
                </ul>
            </div>
            <div class="form-inline">
                
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" onclick="$('#logoutModal').modal('toggle')">Logout</button>
            </div>
        </nav>

        <?php
            if($insert)
            {
                echo "<div class='alert alert-success alert-dismissible fade show text-dark' role='alert'>";
                    echo "<strong>Success!</strong> Your Note was added successfully";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                    echo "</button>";
               echo " </div>";
                 // echo "<script>window.location='index.php'</script>";
            }
            if($update)
            {
                echo "<div class='alert alert-success alert-dismissible fade show text-dark' role='alert'>";
                    echo "<strong>Success!</strong> Your Note was updated successfully";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                    echo "</button>";
               echo " </div>";
                 // echo "<script>window.location='index.php'</script>";
            }
            if($delete)
            {
                echo "<div class='alert alert-success alert-dismissible fade show text-dark' role='alert'>";
                    echo "<strong>Success!</strong> Your Note was deleted successfully";
                    echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'>";
                        echo "<span aria-hidden='true'>&times;</span>";
                    echo "</button>";
               echo " </div>";
                 // echo "<script>window.location='index.php'</script>";
            }
        ?>

        <div class="container my-4">
            <h2>Add a Note</h2>
            <form action="/crud/index.php" method="post">
                <div class="form-group">
                    <label for="title">Note Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                </div>
                <div class="form-group">
                    <label for="description">Note Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label for="Complition Date">Complition Date</label>
                    <input type="date" class="form-control" id="complitionDate" name="complitionDate" aria-describedby="emailHelp">
                </div>
                <button type="submit" name="submit" class="btn btn-primary bg-success">Submit</button>
            </form>
        </div>
        
        <div class="container">
            <table class="table table-dark" id="myTable">
                <thead>
                    <tr>
                    <th scope="col">S.no</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                        $sql="SELECT * FROM `$table_name`";
                        $result=mysqli_query($conn,$sql);
                        $sno=0;
                        $noRows=mysqli_num_rows($result);
                        if($noRows>0)
                        {
                            while($row=mysqli_fetch_assoc($result))
                            {
                                $sno=$sno+1;
                                echo "<tr>";
                                    echo "<th scope='row'>".$sno."</th>";
                                    echo "<td>".$row['title']."</td>";
                                    echo "<td>".$row['description']."</td>";
                                    echo "<td>".$row['complitionDate']."</td>";
                                    echo "<td><button class='edit btn btn-small btn-primary mr-4 bg-success' id='".$row['sno']."'onclick='edits(this.id)' >Edit </button><button class='delete btn btn-small btn-primary bg-success' id='d".$row['sno']."'onclick='deletes(this.id)' >Delete </button></td>";
                                echo "</tr>";
                                
                            }
                        }
                    ?>

                </tbody>
            </table>    
        </div>
        
        <!-- email sending -->
        <?php
            // Import PHPMailer library
            require 'PHPMailer/PHPMailer.php';
            require 'phpmailer/SMTP.php';
            require 'phpmailer/Exception.php';

            // get the completion date from database
            $sql="SELECT * FROM `$table_name`";
            $result=mysqli_query($conn,$sql);
            $noRows=mysqli_num_rows($result);
            if($noRows>0)
            {
                while($row=mysqli_fetch_assoc($result))
                {
                    $date=$row['complitionDate'];
                    $date1=date_create($date);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date1,$date2);
                    $diff=$diff->format("%R%a");
                    if($diff==0)
                    {
                        $body=$row['description'];
                        // Create a new PHPMailer object
                        
                        $mail = new PHPMailer\PHPMailer\PHPMailer();

                        // Set mail parameters
                        $mail->isSMTP(); 
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'iNotes144114@gmail.com';
                        $mail->Password = 'memwclziylvopedj';
                        $mail->SMTPSecure = 'tls';
                        $mail->Port = 587;

                        // Set recipient, subject, and body of the email
                        $mail->setFrom('localhost', 'I-Notes');
                        $mail->addAddress($email, $table_name);
                        $mail->Subject = 'Last day of completing the task';
                        $mail->Body = $body;
                        // Send the email
                        $mail->send();
                    }
                }
            }
        ?>

        <div class="container my-4"> <hr></div>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
        <script>
            let table = new DataTable('#myTable');
        </script>
        <script>
            
            function edits(id)
            {
                var tr=document.getElementById(id).parentNode.parentNode;
                var title=tr.getElementsByTagName("td")[0].innerText;
                var description=tr.getElementsByTagName("td")[1].innerText;
                titleEdit.value=title;
                hiddenSno.value=document.getElementById(id).id;
                descriptionEdit.value=description;
                console.log(tr,title,description,hiddenSno);
                $('#editModal').modal('toggle');

            }
            function deletes(id)
            {
                var tr=document.getElementById(id).parentNode;
                snoDeleted.value=document.getElementById(id).id.substr(1,);
             console.log(snoDeleted);
                $('#deleteModal').modal('toggle');

            }
        
        </script>
  </body>
</html>