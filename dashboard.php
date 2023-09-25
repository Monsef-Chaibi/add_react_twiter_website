<?php
session_start();
if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
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

// اتصال بقاعدة البيانات باستخدام PDO
try {

    $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
}

// get user
$stmt = $connect->prepare("SELECT id, status, Wallet FROM users WHERE username = :username LIMIT 1");
$stmt->bindParam(":username", $user, PDO::PARAM_STR);
$stmt->execute();
$user_data = $stmt->fetchObject();
if ($user_data) {
    $user_id = $user_data->id;
    $log_status = $user_data->status;
    $wallet_balance = $user_data->Wallet;
} else {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}


//////////////////////////////////////////////


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $quantity = $_POST["quantity"];
    
    // احتساب السعر بناءً على الكمية المدخلة
    $price_per_unit = 30; // قيمة السعر لكل وحدة
    $total_price = $quantity * $price_per_unit;

    if ($total_price <= $wallet_balance) {
        // إذا كان رصيد المستخدم كافيًا للدفع
        // خصم المبلغ من رصيد المستخدم
        $new_wallet_balance = $wallet_balance - $total_price;
/*
        // تحديث رصيد المستخدم في قاعدة البيانات
        $update_wallet_stmt = $connect->prepare("UPDATE users SET wallet = :new_wallet_balance WHERE id = :user_id");
        $update_wallet_stmt->bindParam(":new_wallet_balance", $new_wallet_balance, PDO::PARAM_STR);
        $update_wallet_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $update_wallet_stmt->execute();

        // إضافة سجل الدفع إلى جدول payment_records
        $payment_description = "شراء كمية: " . $quantity;
        $add_payment_stmt = $connect->prepare("INSERT INTO payment_records (user_id, payment_amount, payment_description) VALUES (:user_id, :total_price, :payment_description)");
        $add_payment_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $add_payment_stmt->bindParam(":total_price", $total_price, PDO::PARAM_STR);
        $add_payment_stmt->bindParam(":payment_description", $payment_description, PDO::PARAM_STR);
        $add_payment_stmt->execute();
*/
        // عرض رسالة نجاح للمستخدم
        echo "<div class='message' style='color: green;'>تمت عملية الشراء بنجاح.</div>";
    } else {
        // إذا كان رصيد المستخدم غير كافي للدفع
        echo "<div class='message' style='color: red;'>رصيدك غير كافي لشراء هذه الكمية.</div>";
    }
}
?>




<!DOCTYPE html>
<html dir="rtl" lang="ar">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>دعم حسابك</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="css/ewatyle.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="icon" href="images/8149884-48bfb943.png">
    <style>
        * {
            outline: none !important;
        }

        .wrap-contact100 {
            padding: 40px 60px !important;
        }

        .wrap-input100 {
            margin-bottom: 15px;
        }

        .weca {
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: green;
        }

        .btn00 {
            color: beige;
            background-color: black;
            margin-right: 5px;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        /* أسلوب CSS للمربع الذي يظهر عند فتح الصفحة */
        #popup-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* خلفية شفافة للخلفية */
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* زيادة القيمة لتظهيره فوق العناصر الأخرى */
        }

        #popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        #popup h2 {
            margin-bottom: 10px;
        }

        #popup button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>

</head>

<body class="bg-dark">

    <header>
        <?php
        if (isset($user) && !empty($user) && $log_status == "user") {
            echo '
            <nav style="background-color: white;" class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="w-100 navbar-brand weca" href="#" > مرحبا بك  ** ' . $user . '** </a>    
                    <div class="navbar-collapse">
                            <a class="btn btn-info" href="requests.php"> طلباتك </a>
                            <a href="welat.php">
                            <button class="btn  btn00" > محفظتي</button>
                            </a>
                            <a class="btn btn-outline-dark mx-2" href="contactuser.php"> الدعم </a>
                            <a class="btn btn-outline-dark mx-2" href="?logout"> الخروج </a>
                    </div>
                </div>
            </nav>
            ';
        }
        ?>



        <?php
        if ($log_status == "admin") {
            echo '
            <nav style="background-color: white;" class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="w-100 navbar-brand weca" href="#" > مرحبا بك  ** ' . $user . '** </a>    
                    <div class="navbar-collapse">
                            <a class="btn btn-info" href="requests.php"> طلباتك </a>
                            <a href="welat.php">
                            <button class="btn  btn00" > محفظتي</button>
                            </a>
                            <a class="btn btn-outline-dark mx-2" href="contactview.php" style="Width:150px"> رسائل الدعم </a>
                            <a class="btn btn-outline-dark mx-2" href="?logout"> الخروج </a>
                    </div>
                </div>
            </nav>
                        <nav style="background-color: white;" class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="w-100 navbar-brand weca" href="#" >يمكنك الشحن لاي مستخدم من هنا </a>    
                    <div class="navbar-collapse">
                            <a class="btn btn-info" href="recharg.php"> شحن</a>

                    </div>
                </div>
            </nav>
                        ';
        }
        ?>
    </header>








    <?php
    if ($log_status == "user" && $wallet_balance == 0) {
        echo '
    <div id="popup-container">
    <div id="popup">
        <h2>ملاحظة</h2>
        <p>لا يوجد لديك رصيد</p>
        <a href="welat.php"><button>محفظتي</button></a>
        <a href="alart.php"><button>شحن المحفظة</button></a>
        
        <a  href="?logout">
        <button id="close-button">تسجيل الخروج</button>
        </a>
    </div>
</div>
    ';
    }
    ?>














    <div style="min-height: auto !important; margin-top: 40px !important;" class="container-contact100">
        <div class="wrap-contact100">
            <form method="post" class="contact100-form validate-form">

                <div class="message" style="display: none;color: green; size: 15px"></div>

                <span class="text-center contact100-form-title">
                    تعليقات
                </span>

                <div class="wrap-input100">
                    <span class="label-input100"> النوع </span>
                    <select style="height: 55px; border: none;" class="input100" name="option" required>
                       <option value="reply">ردود</option>
                        <option value="quote">اقتباس</option>
                        
                    </select>
                </div>

                <div class="wrap-input100">
                    <span class="label-input100"> تأخير زمني </span>
                   <input class="input100" type="number" name="timesleep" placeholder="تأخير زمني" required value="5">

                </div>

                <input type="hidden" name="userid" id="userid" value="<?php echo $user_id; ?>">

                <div class="wrap-input100">
                    <span class="label-input100">id التغريدة أو الرابط</span>
                    <input class="input100" type="text" name="tweet_id" placeholder="id التغريدة أو الرابط" required>
                </div>
                <div class="wrap-input100">
  <span class="label-input100">الكمية المطلوبة</span>
  <input class="input100" type="number" name="quantity" placeholder="الكمية المطلوبة" id="quantityInput">
</div>
<div class="wrap-input100">
  <span class="label-input100">السعر</span>
  <input class="input100" type="text" name="price" id="priceInput" readonly>
</div>
<div class="wrap-input100">
  <span class="label-input100">الرصيد بعد الطلب</span>
  <input class="input100" type="text" name="balance" id="balanceInput" value="<?php echo $wallet_balance; ?>" readonly>
</div>




                <div class="wrap-input100 validate-input" data-validate="Message is required">
                    <span class="label-input100">ضع التعليقات هنا</span>
                    <textarea class="input100" name="comment" required placeholder="ضع التعليقات هنا..."></textarea>
                </div>
                <div class="container-contact100-form-btn">
                    <div class="wrap-contact100-form-btn" style="
    width: 100%;
">
                        <div class="contact100-form-bgbtn"></div>
                        <button name="submit" type="submit" class="contact100-form-btn w-100" id="fastReplayButton">
                            أرسل (خصم من الرصيد)
                        </button>

                    </div>
                </div>
            </form>
        </div>



        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const form = document.querySelector(".contact100-form");

                form.onsubmit = e => {
                    e.preventDefault();
                    const formData = new FormData(form);

                    fetch("api/insert.php", {
                        method: 'POST',
                        body: formData
                    }).then(result => result.json()).then(data => {
                        console.log(data);
                        if (data.msg != "error") {
                            // succes alert
                            Swal.fire('تم إرسال البيانات بنجاح', '', 'success');
                        } else {
                            // error alert
                            Swal.fire('حدث خطأ غير متوقع', '', 'error');
                        }
                    })

                }



            });
        </script>



        <script>
            // JavaScript لعرض مربع البوب ​​أب عند فتح الصفحة
            window.onload = function () {
                var popupContainer = document.getElementById("popup-container");
                var closeBtn = document.getElementById("close-button");

                // إظهار مربع البوب ​​أب
                popupContainer.style.display = "flex";

                // إغلاق مربع البوب ​​أب عند النقر على زر الإغلاق
                closeBtn.onclick = function () {
                    popupContainer.style.display = "none";
                }
            }
        </script>
        <script>
const quantityInput = document.getElementById('quantityInput');
const priceInput = document.getElementById('priceInput');
const balanceInput = document.getElementById('balanceInput');

function calculatePrice() {
  // تأكد من أن المستخدم أدخل قيمة عددية صالحة
  const quantity = parseInt(quantityInput.value, 10);
  if (isNaN(quantity)) {
    alert('يرجى إدخال قيمة عددية صالحة لحجم الطلب.');
    return;
  }

  // احتساب السعر بناءً على الكمية المدخلة
  const price = (quantity / 10) * 0.30;

  // عرض السعر في حقل السعر بدقة
  priceInput.value = price.toFixed(2);

  // تحديث الرصيد المتاح بناءً على السعر الجديد
  const currentBalance = parseFloat(balanceInput.value);
  const newBalance = (currentBalance - price).toFixed(2);

  // عرض الرصيد بعد الطلب بدقة
  balanceInput.value = newBalance;

  // التحقق من الرصيد الجديد وعرض رسالة تنبيه إذا كان سالبًا
  if (newBalance < 0) {
    alert('الرصيد الحالي غير كافٍ لهذا الطلب.');
  }
}

quantityInput.addEventListener('input', calculatePrice);
  </script>



</body>

</html>

