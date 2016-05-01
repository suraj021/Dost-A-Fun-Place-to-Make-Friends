<?php include '/inc/header.php';  ?>

<?php
    
    if( isset( $_GET['user'] ) ){
        
        $user= $_GET['user'];
        
        $query= "SELECT `username`,`first_name` FROM `users` WHERE `username`='$user'" ;
        
        $result= $conn->query( $query );
        
        if( $result->num_rows== 1 ){
            $user= $result->fetch_assoc()['username'];
            $result->data_seek( 0 );
            $first_name= $result->fetch_assoc()['first_name'];
        }else{
            echo "<meta http-equiv=\"refresh\" content=\"0; url=http://localhost/dost/index.php\">" ;
            exit();
        }
        
    }

?>

<?php
    
    // THIS BLOCK IS TO CHECK IF $USER== $USERNAME;
    // $USERNAME= LOGGED IN USER
    // $USER= WHOSE PROFILE IS TO BE CHECKED

    if( $user === $username ){
        $same= true;
    }else{
        $same= false;
    }

?>

<?php
    //THIS PHP BLOCK IS TO CHECK IF THE PROFILE PIC IS CURRENTLY SET OR NOT
    
    $query= "SELECT `profile_pic` FROM `users` WHERE `username`='$user'";
    $res= $conn->query( $query );
    $res->data_seek( 0 );
    $pic_name= $res->fetch_assoc()['profile_pic'];
    
?>

<?php

    // for the post and friends and Message Systems

    if( isset( $_POST['post'] ) ){
        
        $post= $_POST['post'];
    
        if( $post!= null && $username!= '' ){

            $date_added= date( 'Y-m-d' );
            $added_by= $username;
            $user_posted_to= $user;

            $query= "INSERT INTO `posts` VALUES( '', '$post', '$date_added', '$added_by', '$user_posted_to' )";

            $res= $conn->query( $query );

        }
    }

    if( $_SERVER['REQUEST_METHOD']=== 'POST' ){
        if( isset( $_POST['addfriend'] ) ){
            $user_to= $user;
            $user_from= $username;

            $result= send_friend_request( $user_from, $user_to );

            if( $result== true ){

            }else{

            }
        }else if( isset( $_POST['removefriend'] ) ){
            
        }else if( isset( $_POST['sendmsg'] ) ){
            header( "Location: send_msg.php?to=$user" );
        }
    }
?>

<?php
    
    // Handle Messages and Logout Button

    if( isset( $_POST['messages'] ) ){
        header( 'Location: inbox.php' );
    }else if( isset( $_POST['logout'] ) ){
        header( 'Location: logout.php' );
    }

?>


<div class="postForm">
    <form action="" method="post">
        <textarea id="post" name="post" rows="5" cols="82"></textarea>
        <input type="submit" name="send" value="Post" style="background-color: #DCE5EE; border: 1px solid #666; color: #666; height: 73px; width: 65px; position: relative; top: -33px; margin-left:15px"/>
    </form>
</div>
<div class="profilePosts">
    <?php
        $query= "SELECT * FROM `posts` WHERE `user_posted_to`='$user' ORDER BY `id`";
        $getposts= $conn->query( $query );
        $rows= $getposts->num_rows;
    
        for( $i= 0; $i < $rows; ++$i ){
            $getposts->data_seek( $i );
            $id= $getposts->fetch_assoc()['id'];
            $getposts->data_seek( $i );
            $post= $getposts->fetch_assoc()['body'];
            $getposts->data_seek( $i );
            $date_added= $getposts->fetch_assoc()['date_added'];
            $getposts->data_seek( $i );
            $added_by= $getposts->fetch_assoc()['added_by'];
            $getposts->data_seek( $i );
            $user_posted_to= $getposts->fetch_assoc()['user_posted_to'];
            echo "<div class= 'posted_by'>
                    <a href='profile.php?user=$added_by'>$added_by</a> - $date_added - </div>&nbsp;&nbsp; $post <br/><hr/> ";
        }
    
    ?>
</div>
<img src="<?php 
                if( $pic_name== "" ){
                    echo 'img/defaultpic.png';
                }else{
                    echo 'userdata/profile_pics/' . $pic_name;
                }
              ?>" width="250" height="250" alt="<?php echo $user; ?>'s Profile" title="<?php echo $user; ?>'s Profile" /> <br/>

<?php

    // display Messages button

    if( $user=== $username ){
        echo '<form action="" method="post">
                    <input type="submit" name="messages" value="Inbox"/>
                    <input type="submit" name="logout" value="Log Out"/>
              </form>';
    }


    // Add/Remove friends and Send Message system

    echo $user . ' ' . $username;

    if( !$same && $username!= "" ){
        
        $ans= are_friends( $user, $username );
        $ans2= friend_request_sent( $username, $user );
        
        if( $ans=== true ){
            $value= 'Remove Friend';
            $name= 'removefriend';
        }elseif( $ans2=== true ){
            $value= 'Friend Request Sent';
            $name= 'request_sent';
        }else{
            $value= 'Add Friend';
            $name= 'addfriend';
        }
        
        echo '<form action="" method="post">
                    <input type="submit" value="'.$value.'" name="'.$name.'"/>
                    <input type="submit" value="Send Message" name="sendmsg"/>
             </form>';
    }

?>
<div class="textHeader"><?php echo '<h2>'.$user.'<h2/>'; ?></div>
<div id="profileDescription">
    <?php
        
        $query= "SELECT `about_me` FROM `users` WHERE `username`='$user'";
        $result= $conn->query( $query );
        
        $result->data_seek( 0 );
    
        echo $result->fetch_assoc()['about_me'];
    
    ?>
</div>
<div class="textHeader"> <a href="friends.php"><h2><?php echo $user; ?>'s Friends</h2></a> </div>
<div class="profileLeftSideContent">
    <?php
        
        $friends= get_friends( $user );
        $friends_array= explode( '|', $friends );
        $no_of_friends= count( $friends_array );
        
        if( $no_of_friends=== 0 && $friends_array=== '' ){    // no friends
            
        }else if( $no_of_friends=== 0 && $friends!= '' ){   // one friend
            $profile_pic= get_profile_pic( $friends );

            if( $profile_pic== "" ){
                    $profile_pic= 'img/defaultpic.png';
            }else{
                    $profile_pic= 'userdata/profile_pics/' . $profile_pic;
            }

            //echo $friend;
            echo '<a href="http://localhost/dost/profile.php?user='.$friend.'" ><img src="'.$profile_pic.'" width="50" height="50" /></a>';
            
        }else{      // multiple friends
            
            for( $i= 0; $i < $no_of_friends; ++$i ){
           
                $friend= $friends_array[$i];

                $profile_pic= get_profile_pic( $friends_array[$i] );

                if( $profile_pic== "" ){
                        $profile_pic= 'img/defaultpic.png';
                }else{
                        $profile_pic= 'userdata/profile_pics/' . $profile_pic;
                }


                //echo $friend;

                echo '<a href="http://localhost/dost/profile.php?user='.$friend.'" ><img src="'.$profile_pic.'" width="50" height="50" /></a>';
            
            }
            
        }
    
    
    
    ?>
</div>

<br/><br/><br/><br/>