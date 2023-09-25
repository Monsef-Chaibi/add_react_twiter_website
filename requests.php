<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];

        // connect to db
        include 'api/connect.php';
        // get user
        $stmt = $connect->prepare("SELECT * FROM 
        users WHERE username = :username LIMIT 1");
        $stmt->bindParam("username", $user);
        $stmt->execute();
        if($stmt->rowCount() === 1){
            $stmt = $stmt->fetchObject();
            $user_id = $stmt->id;
            $log_status = $stmt->status;
        }
        else{
            session_unset();
            session_destroy();
            header("Location: index.php");
            exit();
        }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>طلباتك في الموقع</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/ewatyle.css" />
    <link rel="icon" href="images/8149884-48bfb943.png">
</head>
<body class="bg-dark">
    <header>
        <?php
        if(isset($user) && !empty($user)){
            echo '
                <nav class="navbar bg-body-tertiary">
                    <div class="text-center container-fluid">
                        <a class="w-100 navbar-brand" href="#"> طلبات  - '.$user.'  </a>
                    </div>
                </nav>
            ';
        }
        ?>
    </header>

    <span class="text-center text-light mt-4 contact100-form-title">
        صفحة التقرير
    </span>    
    <?php
        // connect to db
        include 'api/connect.php';
        // get data
        if($stmt->status == "admin"){
            $stmt = $connect->prepare("SELECT * FROM comments ORDER BY(task) DESC");
            $stmt->execute();
            $counter = $stmt->rowCount();
        }else if($stmt->status == "user"){
            $stmt = $connect->prepare("SELECT * FROM comments 
            WHERE user_id = :user_id ORDER BY(task) DESC");
            $stmt->bindParam('user_id', $user_id);
            $stmt->execute();
            $counter = $stmt->rowCount();
        }

        if($counter > 0){?>
        <table class="mt-2 table container border">
            <thead>
                <tr>
                    <th class="border" scope="col">رقم الطلب</th>
                    <th class="border" scope="col">العملية</th>
                    <th class="border" scope="col">العدد</th>
                    <th class="border" scope="col">الحالة</th>
                    <?php
                    if($log_status == "admin"){
                        echo '<th class="border" scope="col"> إضغط لتعديل الحالة </th>';
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
        <?php
            foreach($stmt as $data){
                $task = $data['task'];
                $type = $data['type'];
                $timesleep = $data['timesleep'];
                $tweet_id = $data['tweet_id'];
                $comment = $data['comment'];
                $quantity = $data['quantity'];
                $status = $data['status'];
    
                echo '
                <tr>
                    <th class="border">'.$task.'</th>
                    <td class="border">'.$type.'</td>
                    <td class="border">'.$quantity.'</td>
                    <td class="border">'.$status.'</td>
                    ';?>
                    <?php
                    if($log_status == "admin"){
                        echo '
                            <td class="border">
                                <a href="edit.php?task='.$task.'"> تأكيد<a/> 
                            </td>
                        ';
                    }
                    ?>
                    <?php echo '
                </tr>
                ';
            }?>
        </tbody>
        
    </table>
        <div class="container mt-2">
            <a href="dashboard.php" class="w-100 rounded-1 btn btn-info"> تقديم طلب جديد </a>
            <a href="?logout" class="w-100 rounded-1 btn btn-outline-dark mt-2 border-light text-light"> تسجيل الخروج  </a>
        </div>  

            <?php
        }else{
            echo '

            <div class="container">
            <div class="alert alert-info mt-2 text-center">
                لا يوجد اي طلبات في الموقع
            </div>
                <a href="dashboard.php" class="w-100 rounded-1 btn btn-info  mx-auto">تقديم طلب</a>
            </div>
            ';
        }



    ?>

</body>
</html>

<?php
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