<?php
session_start();

if (isset($_SESSION['user_id'])) {
    // احصل على معرف المستخدم الحالي من الجلسة
    $userId = $_SESSION['user_id'];
    
    // اتصال بقاعدة البيانات
    $con = mysqli_connect("localhost", "souqdev_wajdi", "wajdiwajdi", "souqdev_wajdi");

    if (!$con) {
        die("فشل الاتصال بقاعدة البيانات: " . mysqli_connect_error());
    }

    // استخراج البيانات المدخلة من صفحة الشحن
    $amount = $_POST['amount'];
    $username = $_POST['username'];

    // قم بالتحقق من أن اسم المستخدم المدخل موجود في قاعدة البيانات
    $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
    $checkUserResult = mysqli_query($con, $checkUserQuery);

    if ($checkUserResult && mysqli_num_rows($checkUserResult) === 1) {
        // احصل على معرف المستخدم المستهدف
        $targetUserRow = mysqli_fetch_assoc($checkUserResult);
        $targetUserId = $targetUserRow['id'];

        // قم بإضافة الرصيد إلى حساب المستخدم المستهدف
        $updateBalanceQuery = "UPDATE users SET Wallet = Wallet + $amount WHERE id = $targetUserId";

        if (mysqli_query($con, $updateBalanceQuery)) {
            // تمت عملية الشحن بنجاح
            echo "تمت عملية الشحن بنجاح. الرصيد الجديد: " . ($targetUserRow['Wallet'] + $amount);
        } else {
            echo "حدثت مشكلة أثناء تحديث الرصيد: " . mysqli_error($con);
        }
    } else {
        echo "اسم المستخدم غير موجود في قاعدة البيانات.";
    }

    // إغلاق الاتصال بقاعدة البيانات
    mysqli_close($con);
} else {
    echo "يجب تسجيل الدخول أولاً لشحن الرصيد.";
}
?>
