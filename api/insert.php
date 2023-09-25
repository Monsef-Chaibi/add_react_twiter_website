<?php
session_start();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: *");

$response = [];

if (!isset($_SESSION["user"])) {
    $response['msg'] = "User not logged in.";
    echo json_encode($response);
    exit();
}

$user = $_SESSION["user"];

try {
    $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $stmt = $connect->prepare("SELECT id, status, Wallet FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(":username", $user, PDO::PARAM_STR);
        $stmt->execute();
        $user_data = $stmt->fetchObject();
        
        if (!$user_data) {
            $response['msg'] = "User not found";
            echo json_encode($response);
            exit();
        }
        
        $user_id = $user_data->id;
        $wallet_balance = $user_data->Wallet;
        
        $quantity = $_POST["quantity"];
        
        // احتساب السعر بناءً على الكمية المدخلة
        $price_per_unit = 0.30; // قيمة السعر لكل 10 وحدات
        $total_price = ($quantity / 10) * $price_per_unit;

        if ($total_price <= $wallet_balance) {
            $new_wallet_balance = $wallet_balance - $total_price;
            
            $update_wallet_stmt = $connect->prepare("UPDATE users SET wallet = :new_wallet_balance WHERE id = :user_id");
            $update_wallet_stmt->bindParam(":new_wallet_balance", $new_wallet_balance, PDO::PARAM_STR);
            $update_wallet_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $update_wallet_stmt->execute();
         $payment_description = "شراء كمية: " . $quantity;
        $add_payment_stmt = $connect->prepare("INSERT INTO payment_records (user_id, payment_amount, payment_description) VALUES (:user_id, :total_price, :payment_description)");
        $add_payment_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $add_payment_stmt->bindParam(":total_price", $total_price, PDO::PARAM_STR);
        $add_payment_stmt->bindParam(":payment_description", $payment_description, PDO::PARAM_STR);
        $add_payment_stmt->execute();           
            // Insert comment
            
            $url = $_POST['tweet_id'];
            $parts = explode('/', $url);
            // The status ID is the last part of the URL
            $statusID = end($parts);
            // Remove any additional query parameters
            $statusID = strtok($statusID, '?');
            $_POST['tweet_id']=$statusID;


            $stmt = $connect->prepare("INSERT INTO comments (user_id, type ,quantity,  timesleep , tweet_id , comment , status) VALUES (:user_id, :type , :quantity , :timesleep , :tweet_id ,:comment ,'process' )");
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":type", $_POST['option'], PDO::PARAM_STR);
            $stmt->bindParam(":timesleep", $_POST['timesleep'], PDO::PARAM_STR);
            $stmt->bindParam(":tweet_id", $_POST['tweet_id'], PDO::PARAM_STR);
            $stmt->bindParam(":comment", $_POST['comment'], PDO::PARAM_STR);
            $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
            $stmt->execute();
            
            if ($stmt->rowCount() === 1) {
                $response['msg'] = "تمت عملية الشراء وإضافة التعليق بنجاح.";
            } else {
                $response['msg'] = "حدث خطأ أثناء إضافة التعليق.";
            }
        } else {
            $response['msg'] = "رصيدك غير كافي لشراء هذه الكمية.";
        }
    } else {
        $response['msg'] = "Invalid request.";
    }
} catch (PDOException $e) {
    $response['msg'] = "فشل الاتصال بقاعدة البيانات: " . $e->getMessage();
}

echo json_encode($response);
?>
