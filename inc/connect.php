<?php

    $db_name= 'socialnetwork';
    $db_user= 'root';
    $db_pass= '15071995';
    $db_host= 'localhost';

    $conn= new mysqli( $db_host, $db_user, $db_pass, $db_name );

    if( $conn->connect_error ){
        die( $conn->connect_error );
    }

    $query= "SELECT `id` FROM  `users`";
    $result= $conn->query( $query );

    if( !$result ){
        
        //  CREATING USERS TABLE
        
        $query = "CREATE TABLE `users` (
                          `id` int(11) AUTO_INCREMENT,
                          `username` varchar(255) NOT NULL,
                          `first_name` varchar(255) NOT NULL,
                          `last_name` varchar(255) NOT NULL,
                          `email` varchar(255) NOT NULL,
                          `password` varchar(255) NOT NULL,
                          `about_me`  text,
                          `profile_pic` text,
                          `friend_array` text,
                          `sign_up_date` date,
                          `active` enum('0', '1'),
                          PRIMARY KEY  (`id`)
                          )";
        
        $result= $conn->query( $query );
        
        if( !$result ){
            echo "Some error occured while creating USERS table\n";
        }
        
        //  CREATING COMMENTS TABLE
        
        $query = "CREATE TABLE comments (
                          `id` int(11) AUTO_INCREMENT,
                          `post_id` int(11) NOT NULL,
                          `comment_body` text NOT NULL,
                          `comment_by` varchar(256) NOT NULL,
                          `comment_to` varchar(256) NOT NULL,
                          `comment_removed` tinyint(1) NOT NULL,
                          PRIMARY KEY  (`id`)
                          )";
        
        $result= $conn->query( $query );
        
        if( !$result ){
            echo "Some error occured while creating COMMENTS table\n";
        }
        
        //  CREATING FRIEND_REQUESTS TABLE
        
        $query = "CREATE TABLE friend_requests (
                          `id` int(11) AUTO_INCREMENT,
                          `user_from` varchar(256) NOT NULL,
                          `user_to` varchar(256) NOT NULL,
                          PRIMARY KEY  (`id`)
                          )";
        
        $result= $conn->query( $query );
        
        if( !$result ){
            echo "Some error occured while creating FRIEND_REQUESTS table\n";
        }
        
        //  CREATING MESSAGES TABLE
        
        $query = "CREATE TABLE messages (
                          `id` int(11) AUTO_INCREMENT,
                          `user_from` varchar(255) NOT NULL,
                          `user_to` varchar(255) NOT NULL,
                          `message` text NOT NULL,
                          `date` date NOT NULL,
                          `is_read` varchar(10) NOT NULL,
                          PRIMARY KEY  (`id`)
                          )";
        
        $result= $conn->query( $query );
        
        if( !$result ){
            echo "Some error occured while creating MESSAGES table\n";
        }
        
        //  CREATING POSTS TABLE
        
        $query = "CREATE TABLE posts (
                          `id` int(11) AUTO_INCREMENT,
                          `body` text NOT NULL,
                          `date_added` date NOT NULL,
                          `added_by` varchar(255) NOT NULL,
                          `user_posted_to` varchar(255) NOT NULL,
                          PRIMARY KEY  (`id`)
                          )";
        
        $result= $conn->query( $query );
        
        if( !$result ){
            echo "Some error occured while creating POSTS table\n";
        }
        
        
    }


?>