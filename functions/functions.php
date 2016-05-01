<?php

    function send_message( $from, $to, $msg_body, $date, $read ){
        
        global $conn;
        
        $query= "INSERT INTO `messages` VALUES( '', '$from', '$to', '$msg_body', '$date', '$read' )";
        $res= $conn->query( $query );
        
        if( !$res )
            return false;
        else
            return true;
        
    }
    
    function are_friends( $user, $username ){
        
        $friends_of_user= get_friends( $user );
        
        $pos= strpos( $friends_of_user, $username );
        
        if( $pos=== false )
            return false;
        else
            return true;
        
    }

    function get_profile_pic( $user ){
        
        global $conn;
        
        $query= "SELECT `profile_pic` FROM `users` WHERE `username`='$user'";
        $res= $conn->query( $query );
        $res->data_seek( 0 );
        $pic_name= $res->fetch_assoc()['profile_pic'];
        
        return $pic_name;
    }

    function get_friends( $user ){
        
        global $conn;
        
        $query= "SELECT `friend_array` FROM `users` WHERE `username`='$user'";
        $res= $conn->query( $query );
        $res->data_seek( 0 );
        $friend_list= $res->fetch_assoc()['friend_array'];
        
        return $friend_list;
        
    }

    function add_friend( $username, $user_from ){
        
        global $conn;
        
        $query= "SELECT `friend_array` FROM `users` WHERE `username`='$username'";
        $res= $conn->query( $query );
        $res->data_seek( 0 );
        $friend_list= $res->fetch_assoc()['friend_array'];
        
        $friend_list_explode= explode( '|', $friend_list );
        $count= count( $friend_list_explode );
        
        if( $friend_list== "" ){  // no friend
            $friend_list= $user_from;
        }else{     
            $friend_list= $friend_list . '|' . $user_from;
        }
        
        $query= "UPDATE `users` SET `friend_array`='$friend_list' WHERE `username`='$username'";
        $res= $conn->query( $query );
        
        
    }

    function friend_request_sent( $user_from, $user_to ){
        
        global $conn;
        
        $query= "SELECT `id` FROM `friend_requests` WHERE `user_from`='$user_from' AND `user_to`='$user_to'";
        $res= $conn->query( $query );
        
        if( $res )
            return true;
        else
            return false;
        
    }

    function send_friend_request( $user_from, $user_to ){
        global $conn;
        
        $query= "INSERT INTO `friend_requests` VALUES( '', '$user_from', '$user_to' )";
        $result= $conn->query( $query );
        
        if( !$result ){
            return false;
        }else
            return true;
    }

    function set_profilepic( $username, $rand_dir_name, $file_name ){
        
        global $conn;
        
        $query= "UPDATE `users` SET `profile_pic`='$rand_dir_name/$file_name' WHERE `username`='$username'";
        $result= $conn->query( $query );
        
        if( !$result ){
            echo 'Some Error Occurred';
        }else{
            echo true;
        }
        
        
    }

    function update_aboutMe( $username, $about_me ){
        
        global $conn;
        
        $query= "UPDATE `users` SET `about_me`='$about_me' WHERE `username`= '$username'";
        $result= $conn->query( $query );
        
        if( !$result ){
            return 'Some error occured';
        }else{
            return true;
        }
        
    }

    function update_info( $username, $fname, $lname ){
        global $conn;
        
        $query= "UPDATE `users` SET `first_name`= '$fname' WHERE `username`= '$username'";
        $result1= $conn->query( $query );
        
        $query= "UPDATE `users` SET `last_name`= '$lname' WHERE `username`= '$username'";
        $result2= $conn->query( $query );
        
        if( !$result1 || !$result2 ){
            return "Some Error occured";
        }else{
            return true;
        }
        
    }

    function change_password( $username, $old_pwd, $new_pwd ){
        
        global $conn;
        
        $old_pwd= md5( $old_pwd );
        
        $query= "SELECT * FROM `users` WHERE `username`= '$username' AND `password`='$old_pwd'";
        $result= $conn->query( $query );
        
        if( $result->num_rows=== 1 ){
            
            $new_pwd= md5( $new_pwd );
            
            $query= "UPDATE `users` SET `password` = '$new_pwd' WHERE `username` = '$username'";
            $result= $conn->query( $query );
            
            if( !$result ){
                return $result->connect_error;
            }else
                return true;
        
        }else{
            return 'Incorrect Old Password';    
        }
        
    }

    function login( $username, $password ){
        
        global $conn;
        
        $password= md5( $password );
        
        if( user_exists( $username )=== false ){
            return 'Username doesn\'t exist';
        }
        
        //echo $username . ' ' . $password;
        
        $query= "SELECT * FROM `users` WHERE `username`= '$username' AND `password`= '$password'";
        $result= $conn->query( $query );
        $num_rows= $result->num_rows;
        
        //echo $num_rows;
        
        if( $num_rows== 1 ){
            return true;
        }else{
            return 'Username and passwords do not match';
        }
        
    }

    function user_exists( $username ){
        
        global $conn;
        
        $username= htmlentities( stripslashes( $username ) );
        
        $query= "SELECT * FROM `users` WHERE `username`= '$username'";
        $result= $conn->query( $query ) ;
        $num_rows= $result->num_rows;
        
        if( $num_rows== 1 )
            return true;
        else
            return false;
        
    }

    function email_exists( $email ){
        
        global $conn;
        
        $email= htmlentities( stripslashes( $email ) );
        
        $query= "SELECT * FROM `users` WHERE `email`= '$email'";
        $result= $conn->query( $query ) ;
        $num_rows= $result->num_rows;
        
        if( $num_rows== 1 )
            return true;
        else
            return false;
    }
    
    function register( $data ){
        
        $f_name= $data['first_name'];
        $l_name= $data['last_name'];
        $username= $data['username'];
        $email= $data['email'];
        $pwd1= md5( $data['password1'] );
        $pwd2= $data['password2'];
        $date= date( 'Y-m-d ' );
        
        global $conn;
        
        $query= "INSERT INTO `users` VALUES( '', '$username', '$f_name', '$l_name', '$email', '$pwd1', '', '', '', '$date', '1')" ;
        $result= $conn->query( $query );
        
        
        if( !$result )
            return 'Some Error Occurred';
        else
            return true;
        
    }


?>