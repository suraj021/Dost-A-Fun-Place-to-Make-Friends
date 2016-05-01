<?php

    include '/inc/header.php';

    if( $username=="" )
        header( 'Location: index.php' );
    else{       // get all the posts
        
        $query= "SELECT * FROM `posts` WHERE `added_by`='$username' OR `user_posted_to`='$username'";
        $posts= $conn->query( $query );
        
    }


?>




<div class="newsFeed">

    <h2>News Feed</h2><hr/>
    
    <?php
        
        if( $posts ){
            
            $num_rows= $posts->num_rows;
            
            for( $i= 0; $i< $num_rows; ++$i ){
                
                $posts->data_seek( $i );
                $post_id= $posts->fetch_assoc()['id'];
                
                $posts->data_seek( $i );
                $post_body= $posts->fetch_assoc()['body'];
                
                $posts->data_seek( $i );
                $date_added= $posts->fetch_assoc()['date_added'];
                
                $posts->data_seek( $i );
                $added_by= $posts->fetch_assoc()['added_by'];
                
                $profile_pic= get_profile_pic( $added_by );
                
                if( $profile_pic== "" ){
                    $profile_pic= 'img/defaultpic.png';
                }else{
                    $profile_pic= 'userdata/profile_pics/' . $profile_pic;
                }
                
                $query= "SELECT * FROM `comments` WHERE `post_id`='$post_id' AND `comment_removed`= 0";
                $get_comments= $conn->query( $query );
                
                $num_of_comments= $get_comments->num_rows;
                
                echo '<div class="feedItem">
                            <div class="feed_face">
                                <a href="profile.php?user='.$added_by.'"><img src="'.$profile_pic.'" width="100" height="100"/></a>
                                <div class="feedItemByDate">
                                    <a href="profile.php?user='.$added_by.'">'.$added_by.'</a>
                                    '.$date_added.'
                                </div>
                            </div>
                            <div class="feedMainContent">
                                '.$post_body.'
                            </div>
                            <div id="posts'.$post_id.'" > ';
                
                /*
                
                for( $j= 0; $j < $num_of_comments; ++$j ){
                    
                    $get_comments->data_seek( $j );
                    $comment_body= $get_comments->fetch_assoc()['comment_body'];
                    
                    $get_comments->data_seek( $j );
                    $comment_by= $get_comments->fetch_assoc()['comment_by'];
                    
                    $comment_by_pic= get_profile_pic( $comment_by );
                
                    if( $comment_by_pic== "" ){
                        $comment_by_pic= 'img/defaultpic.png';
                    }else{
                        $comment_by_pic= 'userdata/profile_pics/' . $comment_by_pic;
                    }
                    
                    echo '<div class="commentItem">
                            <div class="comment_face">
                                <a href="profile.php?user='.$comment_by.'"><img src="'.$comment_by_pic.'" width="70" height="70"/></a>
                                <div class="commentItemByDate">
                                    <a href="profile.php?user='.$comment_by.'">'.$comment_by.'</a>
                                </div>
                            </div>
                            <div class="commentContent">
                                '.$comment_body.'
                            </div>
                        </div>';
                    
                }
                
                */
                
                echo '</div></div><br/>';
                
                
            }            
            
        }else{
            echo '<h3>Your News Feed is Empty. Shame on You.<h3/>';
        }
    
    
    ?>
    

</div>