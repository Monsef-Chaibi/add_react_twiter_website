<?php
            session_start();
            $user_id=  $_SESSION['userid'];
            $connect = mysqli_connect('localhost','souqdev_wajdi','wajdiwajdi','souqdev_wajdi');
            $sql = "SELECT * FROM contact where user_from = '$user_id' or user_to = '$user_id' ORDER BY id asc"; // Change to your table name
            $result =mysqli_query($connect,$sql);  
            while($contact=mysqli_fetch_array($result)){
         ?>
             <li class="<?php if($contact['user_from']==='admin'){echo 'out';}else{echo 'in';} ;?>">
                 <div class="chat-body">
                        <div class="chat-message">
                         <h5><?php if($contact['user_from']==='admin'){echo 'Me';}else{echo $contact['name'];} ;?></h5>
                           <p><?php echo $contact['msg']; ?></p>
                       </div>
                   </div>
              </li>
         <?php } ?>