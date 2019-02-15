<!DOCTYPE HTML>
<html>
<head>

     <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
          
</head>
<body>
  
    <!-- container -->
    <div class="container">
   
        <div class="page-header">
            <h1>Create Student Record</h1>
        </div>
      
  <?php
if($_POST){
    // include database connection
    include 'config/database.php';
 
    try {
         
        // insert query
        $query = "INSERT INTO student SET roll=:roll, name=:name, father_name=:father_name, mother_name=:mother_name, address=:address, image=:image";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $roll=htmlspecialchars(strip_tags($_POST['roll']));
        $name=htmlspecialchars(strip_tags($_POST['name']));
        $father_name=htmlspecialchars(strip_tags($_POST['father_name']));
        $mother_name=htmlspecialchars(strip_tags($_POST['mother_name']));
        $address=htmlspecialchars(strip_tags($_POST['address']));
        $image=!empty($_FILES["image"]["name"]) ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
        : "";
        $image=htmlspecialchars(strip_tags($image));
        // bind the parameters
        $stmt->bindParam(':roll', $roll);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':father_name', $father_name);
        $stmt->bindParam(':mother_name', $mother_name);
        $stmt->bindParam(':address', $address);
        
         
        // Execute the query

        //////////////////////////////////////////////////////////////////////
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
                $file_upload_error_messages.="<div>Only JPG, JPEG, PNG, GIF files are allowed.</div>";            // make sure file does not exist
            
            // make sure submitted file is not too large, can't be larger than 1 MB
           if($_FILES['image']['size'] > (1024000)) {
                $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
            }

            // if $file_upload_error_messages is still empty
            if(empty($file_upload_error_messages)) {
            // it means there are no errors, so try to upload the file
                if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // it means photo was uploaded
                    echo "<div class='alert alert-danger'>";
                        echo "<div>Unable to upload photo.</div>";
                        echo "<div>Update the record to upload photo.</div>";
                    echo "</div>";
                }
            }
     
        }

        else {
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }
// if $file_upload_error_messages is NOT empty
    if($stmt->execute())
    {
        echo "<div class='alert alert-success'>Record saved.</div>";
    }

    else
        {
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
}
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>
 
<!-- html form here where the product information will be entered -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Registration Number</td>
            <td><input type='text' name='roll' class='form-control' /></td>
        </tr>
        <tr>
            <td>Name</td>
            <td><input type = 'text' name='name' class='form-control'/></td>
        </tr>
        <tr>
            <td>Father Name</td>
            <td><input type='text' name='father_name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Mother Name</td>
            <td><input type='text' name='mother_name' class='form-control' /></td>
        </tr>
        <tr>
            <td>Address</td>
            <td><input type='text' name='address' class='form-control' /></td>
        </tr>
        <tr>
            <td>Image</td>
            <td><input type='file' name='image' class='form-control' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' value='Save' class='btn btn-primary' />
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