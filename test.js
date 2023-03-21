<script>
        edits=document.getElementByClassName("edit");
        Array.from(edits).foreach((element)=>{
            element.addEventListener("click",(e)=>{
            console.log("edit",e);
        })
    })

<?php

$insert=false;
$servername="localhost";
$username="root";
$password="bmsit123@";
$dbname="notes";

$conn=mysqli_connect($servername,$username,$password,$dbname);

if(!$conn)
{
    die("Connection failed".$mysqli_connect_error());
}


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['submit']))
    {
        $title=$_POST["title"];
        $description=$_POST["description"];

        $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title','$description')";
        $result = mysqli_query($conn,$sql);
        if($result)
        {
            $insert=true;
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CRUD</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" href="//cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script
        src="https://code.jquery.com/jquery-3.6.3.js"
        integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
        crossorigin="anonymous">
</script>
 <script src="//cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<style>
    .navbar-brand img{
        border-radius:20px;
        height:50px;
        width:80px;
    }
</style>

</head>

<body>
        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
        </div>

<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
        <img src="images/logo.png" alt="Logo" class="d-inline-block align-text-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="#">Contact Us</a>
            </li>
        </ul>
        </div>
    </div>
</nav>

<!-- showing whether the entry was inserted successfully -->

<?php
    if($insert)
    {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
            echo "<strong>Success!</strong> Your note was added";
            echo "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>";
        echo "</div>";
        // echo "<script>window.location='index.php'</script>";
    }
?>

<!-- INPUT OF DATA BOX -->
<div class="container my-4">
    <h2>Add a Note</h2>
    <form action="/crud/index.php" method="post">
        <div class="form-group my-2">
            <label for="title">Note Title</label>
            <input type="text" name="title" id="title" class="form-control my-2" aria-describedly="emailHelp">
        </div>

        <div class="form-group my-3">
            <label for="title">Note Description</label>
            <textarea name="description" id="description" class="form-control my-2" rows="3"></textarea>
        </div>
        <button type="submit" name='submit' class="btn btn-primary">Add Note</button>
    </form>
</div>


<div class="container">
    
    <table class="table table-dark" id="myTable">
        <thead>
            <tr>
            <th scope="col">S.no</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>

             <?php
                $sql="SELECT * FROM `notes`";
                $result=mysqli_query($conn,$sql);
                $sno=0;
                while($row=mysqli_fetch_assoc($result))
                {
                    $sno=$sno+1;
                    echo "<tr>";
                        echo "<th scope='row'>".$sno."</th>";
                        echo "<td>".$row['title']."</td>";
                        echo "<td>".$row['description']."</td>";
                        echo "<td><button class='edit btn btn-small btn-primary' >Edit </button></td>";
                    echo "</tr>";
                    
                }
            ?>

        </tbody>
    </table>


</div>

<div class="container my-4"> <hr></div>



        <!-- javascript code -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<script>
    let table = new DataTable('#myTable');
</script>

</body>
</html>