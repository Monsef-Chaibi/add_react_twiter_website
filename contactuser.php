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
    <script>
        function ajax(){
            var req = new XMLHttpRequest();
            req.onreadystatechange=function(){
                if(req.readyState == 4 && req.status == 200){
                    document.getElementById('aff').innerHTML =req.responseText;
                }
            }
            req.open('GET','chatuser.php',true)
            req.send();
           
            window.scrollTo(0, document.body.scrollHeight);
        }
        setInterval(function(){ajax()},500);
    </script>
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
        .chat-list {
    padding: 0;
    font-size: .8rem;
}

.chat-list li {
    margin-bottom: 10px;
    overflow: auto;
    color: #ffffff;
}
.chat-list .chat-message {
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    border-radius: 50px;
    background: #5a99ee;
    display: inline-block;
    padding: 10px 20px;
    position: relative;
}

.chat-list .chat-message:before {
    content: "";
    position: absolute;
    top: 15px;
    width: 0;
    height: 0;
}

.chat-list .chat-message h5 {
    margin: 0 0 5px 0;
    font-weight: 600;
    line-height: 100%;
    font-size: .9rem;
}

.chat-list .chat-message p {
    line-height: 18px;
    margin: 0;
    padding: 0;
}

.chat-list .chat-body {
    margin-left: 20px;
    float: left;
    width: auto;
}

.chat-list .in .chat-message:before {
    left: -12px;
    border-bottom: 20px solid transparent;
    border-right: 20px solid #5a99ee;
}

.chat-list .out .chat-img {
    float: right;
}

.chat-list .out .chat-body {
    float: right;
    margin-right: 20px;
    text-align: right;
}

.chat-list .out .chat-message {
    background: #fc6d4c;
}

.chat-list .out .chat-message:before {
    right: -12px;
    border-bottom: 20px solid transparent;
    border-left: 20px solid #fc6d4c;
}

.card .card-header:first-child {
    -webkit-border-radius: 0.3rem 0.3rem 0 0;
    -moz-border-radius: 0.3rem 0.3rem 0 0;
    border-radius: 0.3rem 0.3rem 0 0;
}
.card .card-header {
    background: #17202b;
    border: 0;
    font-size: 1rem;
    padding: .65rem 1rem;
    position: relative;
    font-weight: 600;
    color: #ffffff;
}

.content{
    margin-top:40px;    
}
    </style>
</head>
<body  onload="ajax();"  class="bg-dark">
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
        } 
        $user_id= $_SESSION ["user_id"];
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
    <div class="container content">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body height3">
                                        <ul id="aff" class="chat-list">
                                       
                                        </ul>
                                    </div>
                                </div>
                            </div>
                                        
                            <div class="fixed-input-container">
                                    <form method="post">
                                        <input type="text" name="msg" required value="" class="input" placeholder="اكتب الرسالة ">
                                        <button style="width: 20%;height:45px" class=" rounded-1 btn btn-outline-dark  border-light text-light" id="button" type="submit" name="submit">ارسل</button>
                                        <br> 
                                    </form>
                                        <a href="dashboard.php" class="w-100 rounded-1 btn btn-outline-dark mt-2 border-light text-light">الرجوع</a>
                                    </div>
                        
                            </div>
                    </div>
        <div class="container mt-2">
            
        </div>  


</body>
</html>
<script>

</script>