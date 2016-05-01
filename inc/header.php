<?php 
    include 'connect.php';
    include '/functions/functions.php';
    
    session_start();

    if( isset( $_SESSION['user_login'] ) ){
        $username= $_SESSION['user_login'];
    }else{
        $username= '';
    }

?>
<!doctype html>
<html lang="en">
	
	<head>
		<title>Dost | A Fun Place to Make Friends</title>
		<link rel="stylesheet" type="text/css" href="./css/style.css"/>
        <script src="js/main.js" type="text/javascript"></script>
       <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
	</head>
	
	<body>
		
		<div class="headerMenu">
			<div id="wrapper">
                <div class="logo">
                    <img src="img/logo.jpg"/>
                </div>
                
                <div class="search_box">
                    <form action="search.php" method="post" id="search">
                        <input type="text" name="q" size="60" placeholder="   Search"/>
                    </form>
                </div>   
                
                <div id="menu">
                    
                    
                    <?php
                    
                        if( isset( $_SESSION['user_login'] ) ){
                            $url= 'home.php';
                        }else{
                            $url= 'index.php';
                        }
                    
                        if( isset( $_SESSION['user_login'] ) ){
                            echo   '<a href="home.php">'.$username.'+</a>
                                    <a href="http://localhost/dost/profile.php?user='.$username.'">Profile</a>
                                    <a href="friends.php">Friends</a>
                                    <a href="account_settings.php">Account</a>';
                        }else{
                            echo   '<a href="'.$url.'">Home</a>
                                    <a href="#">About</a>
                                    <a href="index.php">Log In</a>
                                    <a href="index.php">Sign Up</a>';
                        }
                    ?>
                    
                </div>  <!-- End of Menu -->
                