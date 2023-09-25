<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
    }
    try {

        $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connect->prepare("SELECT DISTINCT name , type  ,id ,user_to,user_from FROM contact");
        $stmt->execute();
        $contacts = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
        die("فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
        }
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contact_id"]) && isset($_POST["new_type"])) {
            try {
                $contactId = $_POST["contact_id"];
                $newType = $_POST["new_type"];
        
                $stmt = $connect->prepare("UPDATE contact SET type = :new_type WHERE id = :contact_id");
                $stmt->bindParam(":new_type", $newType, PDO::PARAM_STR);
                $stmt->bindParam(":contact_id", $contactId, PDO::PARAM_INT);
                $stmt->execute();
        
                echo "success";
                exit(); // Assurez-vous de sortir après avoir renvoyé la réponse
            } catch (PDOException $e) {
                echo "error";
                exit(); // Assurez-vous de sortir après avoir renvoyé la réponse
            }
        }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>رسائل الدعم</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/ewatyle.css" />
    <link rel="icon" href="images/8149884-48bfb943.png">
</head>
<body class="bg-dark">
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
        ?>
    </header>

    <span class="text-center text-light mt-4 contact100-form-title">
        صفحة رسائل الدعم
    </span>    
        <table class="mt-2 table container border">
            <thead>
                <tr>
                    <th class="border" scope="col">الاسم</th>
                    <th class="border" scope="col">المحادتة </th>
                    <th class="border" scope="col">الحالة </th>
                    <th class="border" scope="col"> تغيير الحالة</th>
                </tr>
            </thead>
            
            <tbody>
        <?php
            foreach($contacts as $contact): 
                 ?>
                <tr>
                    <th class="border"><?php echo $contact['name']; ?></th>
                    <td class="border"><a href="contactadmin.php?id='<?php echo $contact['user_from']; ?>'">الذهاب الى المحادتة</a></td>
                    <td class="border"><?php if($contact['type']===1){ echo '<img src="images/check.png" alt="Girl in a jacket" width="40" height="40">'; }else{ echo '<img src="images/X.png" alt="Girl in a jacket" width="40" height="40">';}?></td>
                    <td>
                        <button style="color:green;" onclick="changeType1(<?php echo $contact['id']; ?>)">تاكييد</button>
                        <button style="color:red;margin-right:20px" onclick="changeType0(<?php echo $contact['id']; ?>)">الغاء</button>
                    </td>
                </tr>   
                <?php endforeach; ?>
        </tbody>
        
    </table>
        <div class="container mt-2">
            <a href="dashboard.php" class="w-100 rounded-1 btn btn-outline-dark mt-2 border-light text-light">الرجوع</a>
        </div>  


</body>
</html>

<script>
        function changeType0(contactId) {
            var newType = 0;
            if (newType !== null && newType !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "", true); // Laissez l'URL vide pour envoyer à la même page
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            location.reload(); // Rechargez la page pour refléter les changements
                        } else {
                            alert("Erreur lors de la mise à jour du type.");
                        }
                    }
                };
                xhr.send("contact_id=" + contactId + "&new_type=" + newType);
            }
        }
        function changeType1(contactId) {
            var newType = 1;
            if (newType !== null && newType !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "", true); // Laissez l'URL vide pour envoyer à la même page
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            location.reload(); // Rechargez la page pour refléter les changements
                        } else {
                            alert("Erreur lors de la mise à jour du type.");
                        }
                    }
                };
                xhr.send("contact_id=" + contactId + "&new_type=" + newType);
            }
        }
    </script>