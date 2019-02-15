<?php
include_once 'config/database.php';

try
{
    $roll=isset($_GET['roll']) ? $_GET['roll'] : die('ERROR: Record roll not found.');
    
    $query="SELECT image FROM student WHERE roll=?";
    $stmt=$con->prepare($query);
    $stmt->bindParam(1, $roll);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!unlink($row['image'])) {
        header("Location: index.php?action=delete_failed");
    }



    $query="DELETE FROM student WHERE roll=?";

    $stmt=$con->prepare($query);
    $stmt->bindParam(1,$roll);

    if($stmt->execute())
    {
    	header('Location: index.php?action=deleted');
    }
    else
    {
    	header('Location: index.php?action=delete_failed');
    }

}

catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>