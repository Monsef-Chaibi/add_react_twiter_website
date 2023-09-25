<?php
session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    $id = $_SESSION ["user_id"];
} else {
    header("Location: index.php");
    exit();
}

try {

    $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
    }
    
    try {
        // Corrected the SQL query and added a placeholder for the id
        $stmt = $connect->prepare("SELECT email FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT); // Bind the id parameter
        $stmt->execute(); // No need to pass an array here
        $email = $stmt->fetchColumn(); // This will directly fetch the email value
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            
      
      $error = false;
      $successMessage = ""; // Initialisez la variable de message de succès
      $errorMessage = ""; // Initialisez la variable de message de danger
  
      if (isset($_POST["submit"])) { 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $msg = $_POST['msg'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "ادخل بريد إلكتروني صحيح";
          }
        else{
                $sql = "INSERT INTO contact (name, email,msg) VALUES (:name, :email,:msg)";
                $stmt = $connect->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':msg', $msg, PDO::PARAM_STR);
                $stmt->execute();    
                $successMessage = 'تم الارسال بنجاح <a style="color:black" href="javascript:history.go(-2)"> الرجوع</a>'; 
          }
  }              
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الدعم</title>
    <style>   
.contact-form{
    background: #fff;
    margin-top: 10%;
    margin-bottom: 5%;
    width: 70%;
    border-radius:10px;
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}
.contact-form .form-control{
    border-radius:1rem;
}
.contact-image{
    text-align: center;
}
.contact-image img{
    border-radius: 6rem;
    width: 11%;
    margin-top: -3%;
}
.contact-form form{
    padding: 14%;
}
.contact-form form .row{
    margin-bottom: -7%;
}
.contact-form h3{
    margin-bottom: 5%;
    margin-top: -10%;
    text-align: center;
    color: #0062cc;
}
.contact-form .btnContact {
    width: 50%;
    border: none;
    border-radius: 1rem;
    padding: 1.5%;
    background: #dc3545;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
    box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
}
.btnContactSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    color: #fff;
    background-color: #0062cc;
    border: none;
    cursor: pointer;
}
    </style>
    <link rel="icon" href="images/8149884-48bfb943.png">

</head>
<body style="background-color:#FFFFFF">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container contact-form">
            <div class="contact-image">
                <img src="data:image/png;base64,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" alt="rocket_contact"/>
            </div>
            <form method="post">
                <h3>مركز الدعم </h3>
                <?php if (!empty($successMessage)) : ?>
                <div style="margin-bottom: 5%;" class="text-success text-center"  style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"><a href="login.php"><?php echo $successMessage; ?></a></div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)) : ?>
                <div style="margin-bottom: 5%;" class="text-danger text-center"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="اسمك *" value="<?php echo $_SESSION['user']; ?>" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" required placeholder="بريدك الالكتروني *" value="<?php echo $email; ?>" />
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea name="msg" class="form-control" required placeholder="رسالتك *" style="width: 100%; height: 115px;"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                            <button  id="button" type="submit" name="submit" class="btnContact"  >ارسل الرسالة</button>
                        </div>
                </div>
            </form>
</div>
</body>
</html>
