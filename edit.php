<link rel="stylesheet" href="css/bootstrap.min.css" />
<link rel="stylesheet" href="css/ewatyle.css" />
<link rel="icon" href="images/8149884-48bfb943.png">
<?php
    session_start();
    if (isset($_SESSION["user"])) {
        if (isset($_GET['task']) && !empty($_GET['task']) && is_integer(intval($_GET['task']))) {
            $task = intval($_GET['task']);
            // connect to db
            include 'api/connect.php';
            $update = $connect->prepare("UPDATE comments SET status = 'finished' WHERE task = :task");
            $update->bindParam("task",$task);
            if ($update->execute()) {
                echo '<div class="alert alert-success text-center container mt-2">
                تمت العملية بنجاح <a href="requests.php">العودة</a>
                </div>';
            }
            # code...
        }        
    } else {
        header("Location: index.php");
        exit();
    }
    if (isset($_GET["logout"])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }
?>