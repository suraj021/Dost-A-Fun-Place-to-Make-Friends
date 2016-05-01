<?php
    
        include 'inc/header.php';
        
        if( isset( $_GET['id'] ) ){
            $user_from= $_GET['id'];
    
            $query= "DELETE FROM `friend_requests` WHERE `user_from`='$user_from' AND `user_to`='$username'";

            $res= $conn->query( $query );

            // add friend
            add_friend( $username, $user_from );
            add_friend( $user_from, $username );
                        
        }
        


?>