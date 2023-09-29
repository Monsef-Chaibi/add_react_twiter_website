<?php 
    session_start();
    if(isset($_SESSION["user"])){

        header("location: dashboard.php");
    }
    
    $successMessage = ""; // Initialisez la variable de message de succès
    $errorMessage = ""; // Initialisez la variable de message de danger

    if (isset($_POST["submit"])){
        $email = $_POST["email"];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$mysqli =  mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi","souqdev_wajdi");

$sql = "UPDATE users
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("sss", $token_hash, $expiry, $email);

$stmt->execute();

if ($mysqli->affected_rows) {

    $mail = require __DIR__ . "/mailer.php";

    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Reset Password";
    $mail->Body = <<<END
    مرحبا بك في موقعنا 
    اضغط  <a href="http://localhost/xreply/newpassword.php?token=$token">هنا</a> 
    لاعادة تعيين كلمة المرور.

    END;

  
   

    try {
      if($mail->send()){
        $successMessage = "تم ارسال الرابط "; //  affichez un message 
        
      }

    } catch (Exception $e) {

        $errorMessage = "حدت خطأ حاول مجددا"; //affichez un message d'erreur


    }

}

    

       
    } 
    
  
 
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ar">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>حساب جديد</title>
  <link rel="stylesheet" href="css/style.css" media="screen">
  <link rel="stylesheet" href="css/signup.css" media="screen">
  <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="js/main.js" defer=""></script>
  <meta name="generator" content="elwhab">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link id="u-theme-google-font" rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Almarai:300,400,700,800">
  <link rel="icon" href="images/8149884-48bfb943.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "wajdi"
}</script>
  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="signup">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">


  <style>
   



.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 9999;
}

.modal {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    width: 80%;
    max-width: 400px;
    margin: 0 auto;
}

.random-number {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}


    

.overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    text-align: center;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    cursor: pointer;
}

#verificationResult {
    margin-top: 10px;
}

@media screen and (max-width: 600px) {
    .modal {
        width: 90%;
    }
}

  </style>
</head>

<body class="u-body u-xl-mode" data-lang="en">
<?php  include('includes/header.php');
?>



<div class="overlay" id="overlay">
        <div class="modal">
            <div class="modal-content">
                <span id="close" class="close">&times;</span>
                <p>الرقم العشوائي: <span id="randomNumber"></span></p>
                <input type="text" id="userInput" placeholder="ادخل الرقم العشوائي">
                <button id="verifyButton">تحقق</button>
                <p id="verificationResult"></p>
            </div>
        </div>
    </div>


  <section class="u-clearfix u-white u-section-1" id="sec-4e99">
    <div class="u-clearfix u-sheet u-valign-middle u-sheet-1">
      <div class="u-clearfix u-custom-html u-custom-html-1">
      <form class="form_main" method="post">
          <p class="heading" style="margin-bottom:0px">إعادة تعيين </p>
          <p class="heading" style="margin-top:0px"> كلمة المرور</p>
          <?php if (!empty($successMessage)) : ?>
                <div class="text-success text-center"  style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"><a href="login.php"><?php echo $successMessage; ?></a></div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)) : ?>
                <div class="text-danger text-center"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
          <div class="inputContainer">
            <svg viewBox="0 0 19 19" fill="#2e2e2e" height="16" width="15" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
              d="M16.999,4.975L16.999,4.975C16.999,4.975,16.999,4.975,16.999,4.975c-0.419-0.4-0.979-0.654-1.604-0.654H4.606c-0.584,0-1.104,0.236-1.514,0.593C3.076,4.928,3.05,4.925,3.037,4.943C3.034,4.945,3.035,4.95,3.032,4.953C2.574,5.379,2.276,5.975,2.276,6.649v6.702c0,1.285,1.045,2.329,2.33,2.329h10.79c1.285,0,2.328-1.044,2.328-2.329V6.649C17.724,5.989,17.441,5.399,16.999,4.975z M15.396,5.356c0.098,0,0.183,0.035,0.273,0.055l-5.668,4.735L4.382,5.401c0.075-0.014,0.145-0.045,0.224-0.045H15.396z M16.688,13.351c0,0.712-0.581,1.294-1.293,1.294H4.606c-0.714,0-1.294-0.582-1.294-1.294V6.649c0-0.235,0.081-0.445,0.192-0.636l6.162,5.205c0.096,0.081,0.215,0.122,0.334,0.122c0.118,0,0.235-0.041,0.333-0.12l6.189-5.171c0.099,0.181,0.168,0.38,0.168,0.6V13.351z">
              </path>
            </svg>
            <input placeholder="البريد الإلكتروني" id="pass" class="inputField" type="text" name="email" required
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <button id="button" type="submit" name="submit" 
            style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">إرسال</button>
          <div class="signupContainer">
            <p
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
              لديك حساب..؟</p>
            <a href="login.php"
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;"> 
            دخول
            </a>
          </div>
        </form>
      </div>
    </div>
  </section>


  <footer class="u-align-center u-clearfix u-footer u-gradient u-footer" id="sec-2fe9">
    <div
      class="u-clearfix u-sheet u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-valign-middle-xs u-sheet-1">
      <p class="u-custom-font u-small-text u-text u-text-body-alt-color u-text-variant u-text-1">جميع الحقوق محفوظة</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>



  <script>
      
      /*document.addEventListener("DOMContentLoaded", function () {
    const overlay = document.getElementById("overlay");
    const modal = document.querySelector(".modal");
    const close = document.getElementById("close");
    const randomNumberSpan = document.getElementById("randomNumber");
    const userInput = document.getElementById("userInput");
    const verifyButton = document.getElementById("verifyButton");
    const verificationResult = document.getElementById("verificationResult");

    function generateRandomNumber() {
        return Math.floor(Math.random() * 10000);
    }

    function openModal() {
        const randomNum = generateRandomNumber();
        randomNumberSpan.textContent = randomNum;
        userInput.value = "";
        verificationResult.textContent = "";
        overlay.style.display = "flex";
    }

    function closeModal() {
        overlay.style.display = "none";
    }

    function verifyRandomNumber() {
        const enteredValue = userInput.value;
        const randomNum = randomNumberSpan.textContent;

        if (enteredValue === randomNum) {
            verificationResult.textContent = "تم التحقق من أنك بشري";
            verificationResult.style.color = "green";
        } else {
            verificationResult.textContent = "تعذر التحقق";
            verificationResult.style.color = "red";
        }

        setTimeout(closeModal, 3000);
    }

    
    verifyButton.addEventListener("click", verifyRandomNumber);

    openModal();
});

   */

    </script>
    
</body>

</html>

