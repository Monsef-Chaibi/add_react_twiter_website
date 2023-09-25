<?php

 session_start();
 if(isset($_SESSION["user"])){

     header("location: dashboard.php");
 }
 $successMessage = ""; // Initialisez la variable de message de succès
 $errorMessage = ""; // Initialisez la variable de message de danger

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi", "souqdev_wajdi");;

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    $errorMessage = "اسم المستخدم موجود غير موجود"; 
  


}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    $errorMessage = "انتهت صلاحية الرابط";
    
}
if (isset($_POST["submit"]) ) {
    

if($_POST["password"] == $_POST["password_confirmation"])
{
$token_hash = hash("sha256", $token);

$mysqli = mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi", "souqdev_wajdi");;

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    $errorMessage = "انتهت صلاحية الرابط";
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    $errorMessage = "انتهت صلاحية الرابط";
}



$sql = "UPDATE users
        SET password = ?,
            reset_token_hash = NULL,
            reset_token_expires_at = NULL
        WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss",$_POST["password"], $user["id"]);

$stmt->execute();

$successMessage = "تم تغيير كلمة المرور بنجاح";
}else
{

    $errorMessage = "كلمة المرور خاطئة";

}}

?>
<!DOCTYPE html>
<html style="font-size: 16px;" lang="ar">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>كلمة المرور جديدة</title>
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
            <svg viewBox="0 0 16 16" fill="#2e2e2e" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
              </path>
            </svg>
            <input placeholder="كلمة المرور"   id="passs" type="password"  name="password" <?php if (strtotime($user["reset_token_expires_at"]) <= time()) echo "disabled" ;?> class="inputField" 
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <div class="inputContainer">
            <svg viewBox="0 0 16 16" fill="#2e2e2e" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
              </path>
            </svg>
            <input placeholder="كلمة المرور" type="password"  id="pass" <?php if (strtotime($user["reset_token_expires_at"]) <= time()) echo "disabled" ;?> name="password_confirmation" class="inputField" required
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <button <?php if (strtotime($user["reset_token_expires_at"]) <= time()) echo "disabled" ;?> id="button" type="submit" name="submit" 
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

