<script>
    window.scrollTo(0, document.body.scrollHeight); 
</script>
<?php

    session_start();
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
    }
    try {

        $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
        die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
        }
       
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>رسائل الدعم</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/ewatyle.css" />
    <link rel="icon" href="images/8149884-48bfb943.png">
    <style>
           .fixed-input-container {
           
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 10px;
            display:inline-block;
            
        }
        .input{
            border-radius:5px;
            border-color:20px green solid;
            padding:2px;
            padding-right:7px;
            width: 75%;
        }
        .aff{
            display:inline;

        }
    </style>
</head>
<body class="bg-dark">
    <header>
        <?php
        if(isset($user) && !empty($user)){
            echo '
                <nav class="navbar bg-body-tertiary">
                    <div class="text-center container-fluid">
                        <a class="w-100 navbar-brand" href="#"> رسائل  - '.$user.'  </a>
                    </div>
                </nav>
            ';
        } $user_id= $_SESSION ["user_id"];
        $sql = "SELECT * FROM contact where user_from = '$user_id' or user_to = '$user_id' ORDER BY id asc"; // Change to your table name
            $result = $connect->query($sql);
        if (isset($_POST["submit"])) { 
            $msg=$_POST['msg'];
           
            try {
              
                // Prepare and execute the SQL INSERT query
                $stmt = $connect->prepare("INSERT INTO contact (name,user_from, msg) VALUES (:name,:user_from, :msg)");
                $stmt->bindParam(':name', $_SESSION["user"]);
                $stmt->bindParam(':user_from', $user_id);
                $stmt->bindParam(':msg', $msg);
                $stmt->execute();
                header("Location: ".$_SERVER['REQUEST_URI']);
exit();
                
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
          
           
        }
        ?>
    </header>

    <span class="text-center text-light mt-4 contact100-form-title">
        صفحة رسائل الدعم
    </span>    
        <?php
            foreach($result as $contact): 
                    ?>
                    <div class="aff">
                        <input disabled style="border:2px solid black; margin:10px;border-radius: 30px;background-color:white<?php if($contact['user_from']==='admin'){echo 'color:white;background-color:black';} ;?>" type="text" value=" <?php echo $contact['msg']; ?>"><br>
                    </div>
                     <?php endforeach; ?>
   
            <div class="fixed-input-container">
                 <form method="post">
                <input type="text" name="msg" required value="" class="input" placeholder="اكتب الرسالة ">
                <button style="width: 20%;height:45px" class=" rounded-1 btn btn-outline-dark  border-light text-light" id="button" type="submit" name="submit">ارسل</button>
                <br> 
                </form>
                    <a href="dashboard.php" class="w-100 rounded-1 btn btn-outline-dark mt-2 border-light text-light">الرجوع</a>
                </div>
       
        <div class="container mt-2">
            
        </div>  


</body>
</html>
