<?php

    include 'inc/header.php';

    if( isset( $_GET['to'] ) ){
         
        $to= $_GET['to'];
        
        if( ctype_alnum( $to ) ){
            
            $check= user_exists( $to );
            
            if( $check=== true ){       // if user exists
                
                if( $to != $username ){  // if sender and reciever are not same;
                    
                    // send message
                    
                    if( isset( $_POST['send_msg'] ) ){
                        
                        $msg_body= stripcslashes( @$_POST['msg_body'] );
                        
                        if( $msg_body!= "" ){
                            $date= date( 'Y-m-d' );
                            $read= 'false';

                            $sent= send_message( $username, $to, $msg_body, $date, $read );

                            if( $sent=== true ){
                                echo '<h3>Your message has been sent.<h3/>';
                            }else{
                                echo '<h3>There was an error sending your message.<h3/>';
                            }
                        }else{
                            echo '<h3>You cannot send message an empty message </h3>';
                        }
                        
                    }
                    
                    echo '<form action="" method="post">
                                <h2>Compose a Message</h2>
                                <textarea rows="7" cols="80" name="msg_body"></textarea><br/>
                                <input type="submit" value="Send Message to '.$to.'" name="send_msg"/>
                          </form>';
                    
                    
                }else{
                    echo '<h2>You cannot send message to yourself :(</h2>';
                }
                
            }else{
                echo '<h2>The user you want to send message doesn\'t exist :(</h2>';
            }
            
            
            
        }
        
        
    }


?>
