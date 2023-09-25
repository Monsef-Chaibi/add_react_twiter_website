<?php
session_start();
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
  <title>دعم حسابك</title>
  <link rel="stylesheet" href="css/style.css" media="screen">
  <link rel="stylesheet" href="css/Home.css" media="screen">
  <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="js/main.js" defer=""></script>
  <meta name="generator" content="elwhab">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
  <meta property="og:title" content="Home">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">
</head>

<body data-home-page="Home.php" data-home-page-title="دعم حسابك" class="u-body u-xl-mode" data-lang="en">
<?php  include('includes/header.php');
?>
  <section class="u-clearfix u-grey-90 u-section-1" id="sec-2c42">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div
        class="u-align-right-lg u-align-right-md u-align-right-sm u-align-right-xs u-clearfix u-custom-html u-custom-html-1">
        <form class="form_main" method="post">
          <p class="heading">تسجيل</p>
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
            <input placeholder="اسم المستخدم او البريد الإلكتروني" id="user" name="user" class="inputField" type="text" required 
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <div class="inputContainer">
            <svg viewBox="0 0 16 16" fill="#2e2e2e" height="16" width="16" xmlns="http://www.w3.org/2000/svg"
              class="inputIcon">
              <path
                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
              </path>
            </svg>
            <input placeholder="كلمة المرور" type="password" id="pass" name="pass" class="inputField" required
              style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
          </div>
          <button id="button" type="submit" name="submit"
            style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">دخول</button>
          <div class="signupContainer">
            <a href="resetpassword.php" style="background-color: transparent;color:black;margin-top:0px;margin-bottom:0px;font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
            نسيت كلمة المرور ؟</a>
            <p
              style="margin-top:0px;margin-bottom:5px;  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">
              ليس لديك حساب..؟</p>
            <a href="register.php"
              style="xfont-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;">حساب
              جديد</a>
          </div>
        </form>
      </div>
      <h4 style="direction: rtl;"
        class="u-align-center-sm u-align-center-xs u-align-right-lg u-align-right-md u-align-right-xl u-custom-font u-text u-text-1">
        <span class="u-text-palette-3-base"></span>
        <span class="u-text-palette-3-base">دعم حسابك</span> لزيادة التعليقات والردود والاقتباسات
      </h4>
      <h4 style="direction: rtl;"
        class="u-align-center-xs u-align-right-lg u-align-right-md u-align-right-sm u-align-right-xl u-custom-font u-text u-text-2">
        <span class="u-text-palette-3-base"></span>ميزاتنا <br>√ حسابات عربية 100% <br>√ضمان العدد <br>√ ضمان عدم النقص
        <br>√ دعم سريع او بطيئ ( إختياري )
      </h4>
      <a href="register.php"
        class="u-align-center-xs u-align-right-lg u-align-right-md u-align-right-sm u-border-2 u-border-grey-30 u-btn u-btn-round u-button-style u-custom-font u-grey-90 u-hover-grey-60 u-radius-6 u-btn-1">اطلب
        الأن</a>
    </div>
  </section>
  <section class="u-clearfix u-grey-90 u-section-2" id="sec-3603">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div
        class="u-align-left-xl u-border-2 u-border-grey-75 u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-1">
        <div class="u-container-layout u-container-layout-1">
          <h3 class="u-align-center u-text u-text-1" data-animation-name="counter" data-animation-event="scroll"
            data-animation-duration="3000">+9545</h3>
          <h4 class="u-align-center u-custom-font u-text u-text-palette-3-base u-text-2">طلبات</h4>
        </div>
      </div>
      <div class="u-border-2 u-border-grey-75 u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-2">
        <div class="u-container-layout u-container-layout-2">
          <h3 class="u-align-center u-text u-text-3" data-animation-name="counter" data-animation-event="scroll"
            data-animation-duration="3000">+2157</h3>
          <h4 class="u-align-center u-custom-font u-text u-text-palette-3-base u-text-4">خدمات سريعة</h4>
        </div>
      </div>
      <div class="u-border-2 u-border-grey-75 u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-3">
        <div class="u-container-layout u-container-layout-3">
          <h3 class="u-align-center u-text u-text-5" data-animation-name="counter" data-animation-event="scroll"
            style="direction: rtl;" data-animation-duration="3000">1K/30$</h3>
          <h4 class="u-align-center u-custom-font u-text u-text-palette-3-base u-text-6">أسعارنا</h4>
        </div>
      </div>
      <a href="register.php"
        class="u-border-2 u-border-grey-75 u-btn u-btn-round u-button-style u-custom-font u-grey-90 u-hover-grey-60 u-radius-6 u-btn-1">سجل
        الان !</a>
    </div>
  </section>
  <section class="u-clearfix u-grey-90 u-section-3" id="sec-222e">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h4 class="u-custom-font u-text u-text-default u-text-1"> كيف تعمل منصتنا؟</h4>
      <div
        class="u-align-right-lg u-align-right-md u-align-right-sm u-align-right-xl u-border-2 u-border-grey-75 u-container-align-center-xs u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-1">
        <div class="u-container-layout u-container-layout-1"><span
            class="u-align-center-xs u-file-icon u-icon u-icon-1"><img src="images/1077012.png" alt=""></span>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-2"> إنشاء حساب مجاني</h4>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-grey-40 u-text-3" style="direction: rtl;"> انضم إلى
            نظامنا مجانًا من خلال
            النقر على زر التسجيل.</h4>
        </div>
      </div>
      <div
        class="u-align-right u-border-2 u-border-grey-75 u-container-align-center-xs u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-2">
        <div class="u-container-layout u-container-layout-2"><span
            class="u-align-center-xs u-file-icon u-icon u-icon-2"><img src="images/1041904.png" alt=""></span>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-4"> اطلب الخدمة التي تختارها</h4>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-grey-40 u-text-5" style="direction: rtl;"> قم بالدفع
            بخيار الدفع الذي يناسبك.
          </h4>
        </div>
      </div>
      <div
        class="u-align-right u-border-2 u-border-grey-75 u-container-align-center-xs u-container-style u-grey-90 u-group u-radius-20 u-shape-round u-group-3">
        <div class="u-container-layout u-container-layout-3"><span
            class="u-align-center-xs u-file-icon u-icon u-icon-3"><img src="images/2143150.png" alt=""></span>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-6"> استمتع بالصعود</h4>
          <h4 class="u-align-center-xs u-custom-font u-text u-text-grey-40 u-text-7" style="direction: rtl;"> استمتع
            بترويجك على وسائل التواصل
            الاجتماعي معنا!</h4>
        </div>
      </div>
    </div>
  </section>
  <section class="u-clearfix u-grey-90 u-section-4" id="sec-77f1">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h3 class="u-align-left u-custom-font u-text u-text-default u-text-1">من نحــــن</h3>
      <h3 style="direction: rtl;"
        class="u-align-center-xs u-align-right-lg u-align-right-md u-align-right-sm u-align-right-xl u-custom-font u-text u-text-default u-text-2">
        نحن موقع متخصص في تقديم خدمات زيادة التعليقات والردود والاقتباسات الحقيقية لمنصة تويتر. نهدف إلى مساعدة عملائنا
        في تعزيز وجاذبية حساباتهم على تويتر وزيادة تفاعل متابعيهم من خلال توفير خدماتنا عالية الجودة بأسعار منافسة. <br>
        <br>مميزات خدماتنا: <br>1. زيادة حقيقية: نحرص دائمًا على تقديم تعليقات وردود واقتباسات حقيقية من مستخدمين حقيقين
        على تويتر، مما يساهم في تعزيز مصداقية حسابك. <br>
        <br>2. أسعار مناسبة: نفتخر بتقديم أفضل الأسعار في السوق، مما يتيح لك الحصول على تلك الخدمات دون الحاجة إلى دفع
        مبالغ كبيرة. <br>
        <br>3. خدمة موثوقة: نحن نعمل بجد لضمان رضا عملائنا، ونقدم دعمًا فنيًا ممتازًا لمساعدتك في حالة وجود أي استفسارات
        أو مشكلات. <br>
        <br>4. سهولة الاستخدام: يمكنك بسهولة طلب الخدمات التي تحتاجها عبر موقعنا والدفع بأمان، دون عناء أو تعقيدات. <br>
        <br>بفضل خبرتنا في هذا المجال، نهدف دائمًا إلى تقديم أفضل الحلول لتحقيق أهدافك على تويتر وزيادة تواصلك مع
        متابعيك. اعتمادًا على احتياجاتك، يمكننا تقديم خدمات تعزيز التفاعل الاجتماعي التي تناسبك بشكل مثالي.
      </h3>
    </div>
  </section>


  <footer class="u-align-center u-clearfix u-footer u-gradient u-footer" id="sec-2fe9">
    <div
      class="u-clearfix u-sheet u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-valign-middle-xs u-sheet-1">
      <p class="u-custom-font u-small-text u-text u-text-body-alt-color u-text-variant u-text-1"
        style="direction: rtl;">جميع الحقوق محفوظة</p>
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
  

</body>

</html>