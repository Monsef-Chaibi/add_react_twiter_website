<?php
session_start();

// التحقق من وجود معرف المستخدم في الجلسة
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    
    // اتصال بقاعدة البيانات
    $con = mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi", "souqdev_wajdi");

    if (!$con) {
        die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
    }

    // استعلام SQL لاستعراض رصيد المستخدم الحالي
    $sql = "SELECT Wallet FROM users WHERE id = $userId";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $walletBalance = $row['Wallet'];
      
    } else {
        echo "حدثت مشكلة في استعلام قاعدة البيانات.";
    }

    // إغلاق الاتصال بقاعدة البيانات
    mysqli_close($con);
} else {
    echo "يجب تسجيل الدخول أولاً لعرض رصيد المحفظة.";
}
?>


<!DOCTYPE html>
<html style="font-size: 16px;" lang="ar">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <title>المحفظة</title>
  <link rel="stylesheet" href="css/style.css" media="screen">
  <link rel="stylesheet" href="css/welat.css" media="screen">
  <script class="u-script" type="text/javascript" src="js/jquery.js" defer=""></script>
  <script class="u-script" type="text/javascript" src="js/main.js" defer=""></script>
  <meta name="generator" content="Nicepage 5.2.4, nicepage.com">
  <link id="u-theme-google-font" rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
  <link id="u-page-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Almarai:300,400,700,800">


  <script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "wajdi"
}</script>
  <meta name="theme-color" content="#478ac9">
  <meta property="og:title" content="welat">
  <meta property="og:description" content="">
  <meta property="og:type" content="website">
  <link rel="icon" href="images/8149884-48bfb943.png">
</head>

<body class="u-body u-xl-mode" data-lang="en">
<?php  include('includes/header.php');
?>
  <section class="u-clearfix u-grey-90 u-section-1" id="sec-bc88">
    <div class="u-clearfix u-sheet u-sheet-1">
      <h4 class="u-align-left u-custom-font u-text u-text-default u-text-1">رصيدك</h4>
      <h4 class="u-align-center-xs u-custom-font u-text u-text-default u-text-2"><?php echo $walletBalance; ?> $</h4>











      




      
      <a href="payment.php"
        class="u-border-2 u-border-grey-75 u-btn u-btn-round u-button-style u-custom-font u-hover-grey-10 u-radius-6 u-white u-btn-1">شحن
        المحفظة</a>
    </div>

    
  </section>


  <footer class="u-align-center u-clearfix u-footer u-gradient u-footer" id="sec-2fe9">
    <div
      class="u-clearfix u-sheet u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-valign-middle-xs u-sheet-1">
      <p class="u-custom-font u-small-text u-text u-text-body-alt-color u-text-variant u-text-1">جميع الحقوق محفوظة</p>
    </div>
  </footer>

</body>

</html>