<?php
    
    include 'inc/header.php';
    
    echo '<a href="friend_requests.php"><h3>Show Friend Requests</h3></a>';

    echo '</br><h2>Friends</h2><hr/><br/>';

    $friends= get_friends( $username );
    $friends_array= explode( '|', $friends );
    $no_of_friends= count( $friends_array );
        
    if( $no_of_friends== 0 && $friends_array== '' ){    // no friends
        
    }else if( $no_of_friends=== 0 && $friends!= '' ){   // one friend
        $profile_pic= get_profile_pic( $friends );

        if( $profile_pic== "" ){
                $profile_pic= 'img/defaultpic.png';
        }else{
                $profile_pic= 'userdata/profile_pics/' . $profile_pic;
        }

        //echo $friend;
        echo '<a href="http://localhost/dost/profile.php?user='.$friend.'" ><img src="'.$profile_pic.'" width="100" height="100" /></a>';
            
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

            echo '<a href="http://localhost/dost/profile.php?user='.$friend.'" ><img src="'.$profile_pic.'" width="100" height="100" padding-right="25px"/></a>';
            
        }
            
    }

?>