<?php
    include 'inc/header.php';
?>

<?php
    
    // This block to accpet friend requests
    if( $_SERVER['REQUEST_METHOD']=== 'POST' ){
        header("refresh:0;");
    }
    
?>

<h2>Friend Requests</h2>

<?php
    
    $query= "SELECT `user_from` FROM `friend_requests` WHERE `user_to`='$username'";
    $res= $conn->query( $query );
    $rows= $res->num_rows;
    
    $img_src= "";
    $user_from="";

    for( $i= 0; $i < $rows; ++$i ){
        $res->data_seek( $i );
        $user_from= $res->fetch_assoc()['user_from'];
        
        // get the profile picture
        $query= "SELECT `profile_pic` FROM  `users` WHERE `username`='$user_from'";
        $result= $conn->query( $query );
        $result->data_seek( 0 );
        $img_src= $result->fetch_assoc()['profile_pic'];
        
        if( $img_src== "" ){
                $img_src= "img/defaultpic.png";
        }else{
            $img_src= "userdata/profile_pics/" . $img_src;
        }
        
        $from_url= "profile.php?user=" . $user_from;
        
        echo '<div class="friend_request">
                <img src="' . $img_src . '" width="100px" height="100px" >
                <a href="' . $from_url . '">' . $user_from . '</a>
                <form action="accept_requests.php" method="post">
                    <input type="submit" name="accept_request" id="'.$user_from.'" value="Accept Friend Request"/>
                </form>
            </div>';
        
    }


?>
<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script>
$(document).ready(function(){
 $("form").submit(function(event){
        event.preventDefault();
        var idname = $(this).find("input").attr("id");
        console.log(idname);   
     $.ajax
        ({
            url: "accept_requests.php?id="+idname ,
            method: "POST",
            data: {id : idname},
            success:function(){
                console.log("hey");
            
        }
            
        });
 });
                });
</script>

