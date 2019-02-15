<!DOCTYPE HTML>
<html>
<head>
    <title>Update a Record</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
</head>
<body>
 
    <!-- container -->
    <div class="container">
  
        <div class="page-header">
            <h1>Update Student Record</h1>
        </div>
     
        <!-- PHP read record by ID will be here -->
    <?php

      $roll=isset($_GET['roll']) ? $_GET['roll'] : die('ERROR: Record ID not found.');

      include 'config/database.php';

      $query="SELECT roll, name, father_name, mother_name, address, image FROM student WHERE roll = ? LIMIT 0,1";
      $stmt=$con->prepare($query);
      $stmt->bindParam(1,$roll);

      $stmt->execute();

      $row=$stmt->fetch(PDO::FETCH_ASSOC);
      $roll = $row['roll'];
      $name = $row['name'];
      $father_name=$row['father_name'];
      $mother_name=$row['mother_name'];
      $address = $row['address'];
      $image = $row['image'];

 
    // check if form was submitted
    if($_POST) {

        // write update query
        // in this case, it seemed like we have so many fields to pass and 
        // it is better to label them and not use question marks

        if(!unlink($image)) {
            header("Location: index.php?action=delete_failed");
        }

        $query = "UPDATE student SET name=:name, father_name=:father_name, mother_name=:mother_name, address=:address, image=:image WHERE roll=:roll";

        // prepare query for excecution
        $stmt = $con->prepare($query);

        // posted values
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $father_name = htmlspecialchars(strip_tags($_POST['father_name']));
        $mother_name=htmlspecialchars(strip_tags($_POST['mother_name']));
        $address=htmlspecialchars(strip_tags($_POST['address']));
        $image=!empty($_FILES["image"]["name"]) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
        : "";
        // bind the parameters
        $stmt->bindParam(':roll', $roll);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':father_name', $father_name);
        $stmt->bindParam(':mother_name', $mother_name);
        $stmt->bindParam(':address', $address);
        
        if($image)
        {
        // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/";
            $target_file = $target_directory . $image;
            $stmt->bindParam(':image', $target_file);

            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
            $file_upload_error_messages = "";

            $allowed_file_types=array("jpg", "jpeg", "png", "gif");
            if(!in_array($file_type, $allowed_file_types))
                $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";
            
            // make sure file does not exist
            
            // make sure submitted file is not too large, can't be larger than 1 MB
           if($_FILES['image']['size'] > (1024000)){
                $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
            }

            // if $file_upload_error_messages is still empty
            if(empty($file_upload_error_messages)){
            // it means there are no errors, so try to upload the file
                if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // it means photo was uploaded
                }
                else {
                    echo "<div class='alert alert-danger'>";
                        echo "<div>Unable to upload photo.</div>";
                        echo "<div>Update the record to upload photo.</div>";
                    echo "</div>";
                }
            }
     

        else {
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }
        // Execute the query
        if($stmt->execute()){

            echo "<div class='alert alert-success'>Record was updated.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
        }
         
        }  
    }
?>


            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?roll={$roll}");?>" enctype="multipart/form-data" method="post">
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Father Name</td>
            <td><input type = "text" name='father_name' class='form-control' value ="<?php echo htmlspecialchars($father_name, ENT_QUOTES);  ?>" /></td>
        </tr>
        <tr>
            <td>Mother Name</td>
            <td><input type='text' name='mother_name' value="<?php echo htmlspecialchars($mother_name, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type='text' name='address' value="<?php echo htmlspecialchars($address, ENT_QUOTES);  ?>" class='form-control' /></td>
        </tr>
        <tr>
            <td>Image</td>
            <td><input type='file' name='image' value = "<?php echo ($image); ?>" class='form-control' /></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save Changes' class='btn btn-primary' />
                <a href='index.php' class='btn btn-danger'>Back</a>
            </td>
        </tr>
    </table>
</form>  

         
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