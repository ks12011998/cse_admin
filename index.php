<!DOCTYPE HTML>
<html>
<head>
    <title>CSE ADMIN</title>
     
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
         
    <!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>
 
</head>
<body>

    <!-- container -->
    <div class="container">
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
<form action="/hms/accommodations" method="GET"> 
  <div class="row">
    <div class="col-xs-6 col-md-4">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Search roll" id="myInput" onkeyup="myFunction()" />
        <div class="input-group-btn">
        </div>
      </div>
    </div>
  </div>
</form>
            <h1>CSE ADMIN</h1>
        </div>
     
        <!-- PHP code to read records will be here -->
<?php
    include 'config/database.php';
    
    //delete message prompt
    $action = isset($_GET['action']) ? $_GET['action'] : "";
 
// if it was redirected from delete.php
if($action=='deleted'){
    echo "<div class='alert alert-success'>Record was deleted.</div>";
}

if($action == 'delete_failed')
    echo "<div class = 'alert alert-danger'>Unable to delete file.</div>";

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set records or rows of data per page
         $records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;

   
  // select data for current page
$query = "SELECT roll, name, father_name, mother_name, address,image FROM student ORDER BY roll DESC
    LIMIT :from_record_num, :records_per_page";
 
$stmt = $con->prepare($query);
$stmt->bindParam(":from_record_num", $from_record_num, PDO::PARAM_INT);
$stmt->bindParam(":records_per_page", $records_per_page, PDO::PARAM_INT);
$stmt->execute();

        $num=$stmt->rowCount();
        echo "<a href='create.php' class='btn btn-primary m-b-1em'>Add New Student</a>";

    if($num>0)
    {
    echo "<table class='table table-hover table-responsive table-bordered' id='myTable'>";//start table
 
    //creating our table heading
    echo "<tr>";
        echo "<th>Roll</th>";
        echo "<th>Name</th>";
        echo "<th>Father Name</th>";
        echo "<th>Mother Name</th>";
        echo "<th>Address</th>";
        echo "<th>Image</th>";
        echo "<th>Action</th>";
    echo "</tr>";
     
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['firstname'] to
    // just $firstname only
    extract($row);
     
    // creating new table row per record
    echo "<tr>";
        echo "<td>{$roll}</td>";
        echo "<td>{$name}</td>";
        echo "<td>{$father_name}</td>";
        echo "<td>{$mother_name}</td>";
        echo "<td>{$address}</td>";
        echo "<td>{$image}</td>";
        echo "<td>";
            // read one record 
            echo "<a href='read_one.php?roll={$roll}' class='btn btn-info m-r-1em'>Read</a>";
             
            // we will use this links on next part of this post
            echo "<a href='update.php?roll={$roll}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            echo "<a href='delete.php?roll={$roll}' onclick='delete_user({$roll});'  class='btn btn-danger'>Delete</a>";
        echo "</td>";
    echo "</tr>";
}
// end table
echo "</table>";
$query="SELECT COUNT(*) as total_rows FROM student";
$stmt=$con->prepare($query);
$stmt->execute();

$row=$stmt->fetch(PDO::FETCH_ASSOC);
$total_rows=$row['total_rows'];
$page_url="index.php?";
include_once "paging.php";

    }
    else{

     echo "<div class='alert alert-danger'>No records found.</div>";
        }
?>
    </div> <!-- end .container -->
     
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
   
<!-- Latest compiled and minified Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 
<!-- confirm delete record will be here -->
 <script type='text/javascript'>
// confirm record deletion
function delete_user(roll){
     
    var answer = confirm('Are you sure?');
    if (answer){
        // if user clicked ok, 
        // pass the roll to delete.php and execute the delete query
        window.location = 'delete.php?roll=' +roll;
    } 
}
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
<style type="text/css">
.container
{
    background: rgb(240,248,255);
    width: 100%;

}
body
{
    background: rgb(250,235,215);
}

h1
{
    transform: translateY(-130%);
}
form
{
    transform: translateX(70%);
    padding-top: 20px;
}
</style>
</html>