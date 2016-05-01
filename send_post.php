<?php

    include 'inc/connect.php';

    $post= $_POST['post'];
    
    if( $post!= null ){
        
        $date_added= date( 'Y-m-d' );
        $added_by= 'test123';
        $user_posted_to= 'test123';
        
        $query= "INSERT INTO `posts` VALUES( '', '$post', '$date_added', '$added_by', '$user_posted_to' )";
        
        $res= $conn->query( $query );
        
    }else{
        echo 'You must enter something in the post field before you can send it...';
    }


?>