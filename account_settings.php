<?php
    // THIS PHP BLOCK IS TO CHECK IF THE USER IS LOGGED IN OR NOT

    include 'inc/header.php';
    
    if( isset( $_SESSION['user_login'] ) ){
        
    }else{
        die( '<h2>You don\'t have permission to view this page</h2>' );
    }

?>

<?php
    // THIS PHP BLOCK IS TO HANDLE FORMS

    if( $_SERVER['REQUEST_METHOD']=== 'POST' ){
        
        if( isset( $_POST['change_password'] ) ){
            
            $old_pwd= $_POST['old_password'];
            $new_pwd1= $_POST['new_password1'];
            $new_pwd2= $_POST['new_password2'];
            
            if( strlen( $new_pwd1 ) >= 8 ){
                if( $new_pwd1 === $new_pwd2 ){
                    $res= change_password( $username, $old_pwd, $new_pwd1 );
                
                    if( $res=== true ){
                        echo 'Password Changed Successfully!';
                    }else{
                        echo 'Incorrect Old Password';
                    }
                }else{
                    echo $res;    
                }   
                
            }else{
                echo 'The length of the new Password must be greater than 7';
            }
            
        }
        else if( isset( $_POST['update'] ) ){

            $fname= $_POST['fname'];
            $lname= $_POST['lname'];
            
            $res= update_info( $username, $fname, $lname );
            
            if( $res=== true ){
                echo 'Information Changed Successfully';
            }else{
                echo $res;
            }
            
        }
        else if( isset( $_POST['update_about_me'] ) ){
            
            $about_me= $_POST['aboutme'];
            
            $res= update_aboutMe( $username, $about_me );
            
            if( $res=== true )
                echo 'About Me Updated Successfully';
            else
                echo $res;
        }
        else if( isset( $_POST['uploadpic'] ) ){
            if( isset( $_FILES['profilepic'] ) ){
                
                if( ( $_FILES['profilepic']['size']  < 5048576 ) && ( ( $_FILES['profilepic']['type']='image/png' ) || ( $_FILES['profilepic']['type']='image/jpg' ) || ( $_FILES['profilepic']['type']='image/jpeg' ) ) ){
                       
                    $chars= 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM0123456789';
                    $rand_dir_name= substr( str_shuffle( $chars ), 0, 15 );
                    
                    mkdir( 'userdata/profile_pics/' . $rand_dir_name  );
                    
                    if( file_exists( 'userdata/profile_pics/' . $rand_dir_name . '/' . $_FILES['profilepic']['name'] ) ){
                        echo $_FILES['profilepic']['name'] . ' already exists';
                    }else{
                        move_uploaded_file( $_FILES['profilepic']['tmp_name'], 'userdata/profile_pics/' . $rand_dir_name . '/' . $_FILES['profilepic']['name'] );
                        echo 'File Upload Successfull';
                        
                        $res= set_profilepic( $username, $rand_dir_name, $_FILES['profilepic']['name'] );
                        
                        if( $res=== true ){
                            echo 'Profile Picture Updated';
                        }else{
                            echo $res;
                        }
                        
                    }
                    
                    
                    
                }else{
                    
                }
                
            }else{
                echo 'Please choose a file to upload.';
            }
        }
        
    }

?>

<?php
    //THIS PHP BLOCK IS TO CHECK IF THE PROFIL PIC IS CURRENTLY SET OR NOT
    
    $query= "SELECT `profile_pic` FROM `users` WHERE `username`='$username'";
    $res= $conn->query( $query );
    $res->data_seek( 0 );
    $pic_name= $res->fetch_assoc()['profile_pic'];
    
?>


<h2>Edit Your Account Settings</h2>
<hr/>

<h3>Change Profile Picture</h3>
<form action="" method="post" enctype="multipart/form-data">
    <img src="<?php 
                if( $pic_name== "" ){
                    echo 'img/defaultpic.png';
                }else{
                    echo 'userdata/profile_pics/' . $pic_name;
                }
              ?>" width="70px" height="70px"/>
    <input type="file" name="profilepic"/><br/>
    <input type="submit" name="uploadpic" value="Change Profile Picture"/>

</form>

<hr/>
<h3>Change Your Passsword</h3>
<form action="" method="post">
    
    Your Old Password  :<br/><input type="password" name="old_password"/><br/><br/>
    Your New Password  :<br/><input type="password" name="new_password1"/><br/><br/>
    New Password Again :<br/><input type="password" name="new_password2"/><br/><br/>
    <input type="submit" value="Change Password" name="change_password"/>

</form>

<hr/>
<h3>Update Your Info</h3>
<form action="" method="post">
    First Name:<br/><input type="text" name="fname"/><br/><br/>
    Last Name  :<br/><input type="text" name="lname"/><br/><br/>
    <input type="submit" value="Update" name="update"/>
</form
    
<hr/>
<h3>Change About Me</h3>
<form action="" method="post">
    About Me :<br/><textarea name="aboutme" id="about_me" cols="80" rows="7" ></textarea><br/><br/>
    <input type="submit" value="Change About Me" name="update_about_me"/>
</form>






