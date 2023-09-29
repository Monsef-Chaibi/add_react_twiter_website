<?php
                                            session_start();
                                            $user_id=  $_SESSION['user_id'];
                                            $connect = new PDO("mysql:host=localhost;dbname=souqdev_wajdi", "souqdev_wajdi", "wajdiwajdi");
                                            $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                            $sql = "SELECT * FROM contact where user_from = '$user_id' or user_to = '$user_id' ORDER BY id asc"; // Change to your table name
                                            $result = $connect->query($sql);
                                            foreach($result as $contact): 
                                        ?>
                                            <li class="<?php if($contact['user_from']!='admin'){echo 'out';}else{echo 'in';} ;?>">
                                                <div class="chat-body">
                                                    <div class="chat-message">
                                                        <h5><?php if($contact['user_from']!='admin'){echo $contact['name'];}else{echo 'Admin';} ;?></h5>
                                                        <p><?php echo $contact['msg']; ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endforeach; ?>