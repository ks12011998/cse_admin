<!DOCTYPE HTML>
<html>
<head>
    <title>Read One Record</title>
 
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
 
</head>
<body>
 
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Read Student Record</h1>
        </div>
         
        <!-- PHP read one record will be here -->
        <?php 
       $roll=isset($_GET['roll']) ? $_GET['roll'] : die('ERROR: Record ID not found.');
       include 'config/database.php';
       try{
       $query="SELECT roll ,name, father_name, mother_name, address, image FROM student WHERE roll= ? LIMIT 0,1";
       $stmt=$con->prepare($query);
       $stmt->bindParam(1,$roll);
       $stmt->execute();
       $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // values to fill up our form
    $roll = $row['roll'];
    $name = $row['name'];
    $father_name = $row['father_name'];
    $mother_name = $row['mother_name'];
    $address = $row['address'];
    $image = $row['image'];
    }
    catch(PDOException $exception)

    {
      die('ERROR:' .$exception->getMessage());
    }
        ?>
        <table class='table table-hover table-responsive table-bordered'>
    <tr>
        <td>Roll</td>
        <td><?php echo htmlspecialchars($roll, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Name</td>
        <td><?php echo htmlspecialchars($name, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Father Name</td>
        <td><?php echo htmlspecialchars($father_name, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Mother Name</td>
        <td><?php echo htmlspecialchars($mother_name, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><?php echo htmlspecialchars($address, ENT_QUOTES);  ?></td>
    </tr>
    <tr>
        <td>Image</td>
        <td><img class = "img-thumbnail" width = "400" height = "400" src = "<?php echo htmlspecialchars($image, ENT_QUOTES);  ?>"></td>
    </tr>
    <tr>
        <td></td>
        <td>
            <a href='index.php' class='btn btn-danger'>Back</a>
        </td>
    </tr>
</table>
 
    </div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
</body>
<style type="text/css">
.container
{
    background: rgb(240,248,255);

}
body
{
    background: rgb(250,235,215);
}
</style>
</html>