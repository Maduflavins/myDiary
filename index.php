<?php
    session_start();
    $error = "";

    if(array_key_exists("Logout", $_GET)){
        unset($_SESSION);
        setcookie("id", "", time() -60*60);
        $_COOKIE["id"] = "";
    }else if(array_key_exists("id", $_SESSION) OR array_key_exists("id", $_COOKIE)){
        header("Location: loggedinpage.php");
    }

    if(array_key_exists("submit", $_POST)){
        include("connection.php");
        
    }
    if($_POST){
        if(!$_POST["name"]){
            $error .= "<p>the name field is required.</p>";
        }
        if(!$_POST["email"]){
            $error .= "the email field is required.<br>";
        }
        if(!$_POST["password"]){
            $error .= "the password field is required.<br>";
        }

        if ($_POST["email"] && filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
            $error .= "the email address is invalid.<br>"; 
          }

          if($error !=""){
            $error = '<div class="alert alert-danger" role="alert"><strong>there were error(s) in your form</strong>' . $error .'</div>';
          }else{
              if($_POST['signup'] == '1'){
                $query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'LIMIT 1";
                $result = mysqli_query($link, $query);

                if(mysqli_num_rows($result) == 1){
                    $error = "that email address is already taken.";
                }else{
                    $password_string = mysqli_real_escape_string($link, $_POST["password"]);
                    $password_hash = password_hash($password_string, PASSWORD_BCRYPT);

                    $query ="INSERT INTO users (`name`, `email`, `password`) VALUE('".mysqli_real_escape_string($link, $_POST['name'])."', 
                    '".mysqli_real_escape_string($link, $_POST['email'])."', 
                    '".$password_hash."')";
                    if(!mysqli_query($link, $query)){
                        $error = "Sorry unable to sign you up.";
                    }else{
                        $_SESSION['id'] = mysqli_insert_id($link);
                        if($_POST['stayedLoggedIn'] == '1'){
                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                        }
                        //$query = "UPDATE `users` SET password = (password_hash($_POST['password'], PASSWORD_BCRYPT)).";
                        header("Location: loggedinpage.php");
                    }
                }
            }else{
                $query = "SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);
                if(isset($row)){
                    $password_string = $_POST["password"];
                    $verify=password_verify($password_string,$row['password']);
                    
                    if($verify){
                        $_SESSION['id'] = $row['id'];
                        if($_POST['stayedLoggedIn'] == '1'){
                            setcookie("id", $row['id'], time() + 60*60*24*365);
                        }
                        header("Location: loggedinpage.php");
                    }

                }else{
                    $error = "<p>Email or password is wrong</p>";
                }

            }
          }
    }
?>
<?php include("header.php"); ?>
  <div class="container" id="#homepageContainer">
        <div id="error"><?php echo $error; ?><div>
        <h1 class="text-white">Your Diary is Your Personal Property</h1>
        <h3>Preserve your thoughts in the cloud</h3>
        <form method = "post" id="signupForm">
            <h3>Curious? Signup</h3>
            <div class="form-group">
                <input class="form-control"type ="text" id= "name" name="name" placeholder="your name">
            </div>
            <div class="form-group">
                <input class="form-control" type ="text" id="email" name="email" placeholder="your email">
            </div>
            <div class="form-group">
                <input class="form-control" type ="password" id="password" name="password" placeholder="password">
            </div>
            <div class="form-check text-white">
                <label class="form-check-label">
                    <input type= "checkbox" name="stayLoggedIn" value=1>
                    stay logged in
                </label>
            </div>
            <div class="form-group">
                <input class="form-control" type="hidden" name="signup" value=1>
                <input class="btn btn-success" type="submit" id="submit" name ="submit" value="sign up">
            </div>
            <p><a class="toggleForms">Login</a></p>
        </form>
        <form method = "post" id="loginForm">
            <h3>Please login with your details</h3>
            <div class="form-group">
                <input class="form-control" type ="text" id= "name" name="name" placeholder="your name">
            </div>
            <div class="form-group">
                <input class="form-control" type ="text" id="email" name="email" placeholder="your email">
            </div>
            <div class="form-group">
                <input class=" form-control" type ="password" id="password" name="password" placeholder="password">
            </div>
            <div class="form-check">
                <label class="form-check-label">
                    <input type= "checkbox" name="stayLoggedIn" value=1>
                    stay logged in
                </label>
            </div>
            <div class="form-group">
                <input class=" form-control" type="hidden" name="signup" value=0>
            </div>
            <div class="form-group">
                <input class="btn btn-success" type="submit" id="submit" name ="submit" value="Log In">
                <p><a class="toggleForms">Sign up</a></p>
            </div>
            
        </form>

<?php include("footer.php"); ?>