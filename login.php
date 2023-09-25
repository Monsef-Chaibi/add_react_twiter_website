<?php
session_start();
$_SESSION["Humans"] = false ;
if (isset($_SESSION["user"])) {
  header("Location: dashboard.php");
}

$error = false;
$errorMessage = ""; // Initialisez la variable de message de danger

if (isset($_POST["submit"])) {
  $user_login = $_POST["user"];

  $con = mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi", "souqdev_wajdi");

  // Query the database for the user with the given username or email.
  $sql = "SELECT * FROM users WHERE username = '$user_login' OR email = '$user_login'";
  $result = mysqli_query($con, $sql);
// If the user exists, verify the password.
if ($user = mysqli_fetch_assoc($result)) {
    $password = $_POST['pass'];
    if ($password === $user['password']) {
        // Log the user in by setting the `$_SESSION['login_user']` variable.
        $_SESSION["user"] = $user['username'];
        $_SESSION['user_id'] = $user['id'];
        // Redirect the user to the next page.
        header("Location: dashboard.php");
    } else {
        // The password is incorrect.
        $errorMessage = "كلمة المرور خاطئة ";
    }
} else {
    // The user does not exist.
    $errorMessage = "مستخدم غير موجود";
}
  mysqli_close($con);
}
?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ar">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="css/style.css" media="screen">
  <link rel="stylesheet" href="css/login.css" media="screen">
  <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="js/main.js" defer=""></script>

  <meta name="generator" content="elwhab">

  <link id="u-theme-google-font" rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Almarai:300,400,700,800">
  <link rel="icon" href="images/8149884-48bfb943.png">

  <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": "wajdi"
}</script>
  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="login">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


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
          <p class="heading">دخول حسابك</p>
          <?php if (!empty($errorMessage)) : ?>
                <div class="text-danger text-center"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
          <div class="inputContainer">
            <svg viewBox="0 0 16 16" fill="#2e2e2e" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
                d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z">
              </path>
            </svg>
            <input placeholder="اسم المستخدم او البريد الإلكتروني"  id="user" class="inputField" type="text" required name="user"
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <div class="inputContainer">
            <svg viewBox="0 0 16 16" fill="#2e2e2e" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
              </path>
            </svg>
            <input placeholder="كلمة المرور" id="pass" class="inputField" type="password" name="pass" required
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <button id="button" type="submit" name="submit"
            style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">دخول</button>
          <div class="signupContainer">
          <a href="resetpassword.php" style="background-color: transparent;color:black;margin-top:0px;margin-bottom:0px;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
            نسيت كلمة المرور ؟</a>
            <p
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
              ليس لديك حساب..؟</p>
            <a href="register.php"
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">حساب
              جديد</a>
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
  <?php

  if($error){
    echo " 
    <script>
    var x = document.getElementById('modal1');
    new bootstrap.Modal(x).show();

    </script>
    
    ";
  }
  
  
  ?>




<script>
      
      document.addEventListener("DOMContentLoaded", function () {
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
            <?php 
              $_SESSION["Humans"] = true ;
            ?>
        } else {
            verificationResult.textContent = "تعذر التحقق";
            verificationResult.style.color = "red";
        }

        setTimeout(closeModal, 3000);
    }

    
    verifyButton.addEventListener("click", verifyRandomNumber);

    <?php
      if($_SESSION["Humans"] === false) {
    ?>
    openModal();
    <?php } ?>
});

   

    </script>
</body>

</html>