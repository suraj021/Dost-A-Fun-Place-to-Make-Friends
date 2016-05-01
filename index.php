<?php 
    include '/inc/header.php';

    if( $username!= "" ){
        header( 'Location: home.php' );
        exit();
    }

   if( $_SERVER['REQUEST_METHOD']=== 'POST' ){
       
       if( isset( $_POST['reg'] )=== true ){
        
            //echo 'So you want to register';

            $f_name= $_POST['first_name'];
            $l_name= $_POST['last_name'];
            $username= $_POST['username'];
            $email= $_POST['email'];
            $pwd1= $_POST['password1'];
            $pwd2= $_POST['password2'];

            $required= array( 'first_name', 'last_name', 'username', 'email', 'password1', 'password2' );

            $errors= false;

            foreach( $_POST as $key=>$value ){
                if( empty( $value ) && in_array( $key, $required ) ){
                    echo 'Please fill the complete form<br/>';
                    $errors= true;
                    break;
                }
            }

            if( !$errors ){

                // validate username
                if( preg_match( "/\\s/", $username ) == true ){
                    echo 'Username must not contain spaces<br/>';
                    $errors= true;
                }

                if( user_exists( $username )=== true ){
                    echo 'The username is taken<br/>';
                    $errors= true;
                }

                // validate password
                if( strlen( $pwd1 ) < 8 ){
                    echo 'The length of the password must be greater than 8 <br/>';
                    $errors= true;
                }

                if( $pwd1 != $pwd2 ){
                    echo 'The passwords don\'t match<br/>';
                    $errors= true;
                }

                // validate email
                if( preg_match( "/\\s/", $_POST['email'] ) == true ){
                    echo "The Email must not contain spaces.<br/>";
                    $errors= true;
                }
                if( email_exists( $_POST['email'] )=== true ){
                    echo "Sorry! the email '" . $_POST['email'] . "' is already in use.<br/>";
                    $errors= true;
                }
                if( filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL )=== false ){
                    echo "A valid email is required.<br/>";
                    $errors= true;
                }

            }

            if( !$errors ){

                $success= register( $_POST );

                if( $success=== true ){
                    echo 'Successfully Registered. Please login.';
                    header( 'Location: index.php?success' );
                    exit();
                }else{
                    echo $success;
                }

            }
        
        
       }
        elseif( isset( $_POST['login'] )=== true ){
           
          //echo 'So you want to login'; 
           $username= $_POST['username_login'];
           $password= $_POST['password_login'];
           
           $login= login( $username, $password );
           
           if( $login=== true ){
               
               $_SESSION['user_login']= $username;
               header( 'Location: home.php' );
               exit();
               
           }else{
               echo '<h3>Couldn\'t login because of following reasons:<br/><h3/>';
               echo $login;
           }
           
           
       }     
       
       
   } 



?>
                

                <div id="login">
                    
                    <h2>Already a member! Login</h2>
            
                    <form action="index.php" method="post" id="login_form">
                    
                        <input type="text" name="username_login" placeholder="   Username" />
                        <input type="password" name="password_login" placeholder="   Password" />
                        <input type="submit" name="login" value="Log In"/>
                    
                    </form>
                    
                </div>

                <div id="signup">
                    
                    <h2>Sign Up Here!</h2>
                    
                    <form action="index.php" method="post" class="sign_up">
                    
                        <input type="text" name="first_name" placeholder="  First Name"/> <br/><br/>
                        <input type="text" name="last_name" placeholder="  Last Name"/> <br/><br/>
                        <input type="text" name="username" placeholder="  Username"/> <br/><br/>
                        <input type="text" name="email" placeholder="  Email Address"/> <br/><br/>
                        <input type="password" name="password1" placeholder="  Password"/> <br/><br/>
                        <input type="password" name="password2" placeholder="  Password (Again)"/> <br/><br/>
                        <input type="submit" name="reg" value="Sign Up" />
                    
                    </form>
                    
                </div>      <!-- End of Signup -->
                
                <div id="motive">
                    <img src="img/connect.jpg"/>
                </div>
                
            </div>    <!-- End of wrapper-->
		</div>  <!-- End of headerMenu -->

<?php  include '/inc/footer.php'; ?>