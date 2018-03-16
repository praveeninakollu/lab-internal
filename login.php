<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <?php
            function process($data){
                $data=htmlspecialchars($data);
                $data=trim($data);
                $data=stripslashes($data);
                return $data;
            }
            $userErr=$passErr="";
            if(isset($_POST['submit'])){
                $username=$password="";
                $userErr=$passErr="";
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    if(empty($_POST["username"])) $userErr="username required"; else $username=process($_POST["username"]);
                    if(empty($_POST["password"])) $passErr="password required"; else $password=process($_POST["password"]);
                }
                
                $host="localhost";
                $user="root";
                $pass="";
                $db="property";
                $conn =new mysqli($host,$user,$pass,$db);
                if($conn->connect_error){
                    die("connection failed". $conn->connect_error);
                }
                $sql="SELECT * from `user` WHERE  `username`='$username' AND `password`= '$password' ;";
                $result=$conn->query($sql);
                if( $result->num_rows > 0 ){
                    $val=$result->fetch_assoc();
                    if($val['password']===$password){
                        print "
                            <script>
                                alert('sucessfully logged in');
                            </script>
                        ";
                        session_start();
                        $_SESSION['username']=$val['username'];
                        $_SESSION['email']=$val['email'];
                        $_SESSION['userid']=$val['userId'];
                        header('location: details.php');
                        
                    }else{
                        $passErr="Inccorect Password!!";
                    }
                }else{
                    print "<script>
                        alert('user does not exist ');
                    </script>";
                    header('location: registration.php');
                }
            }
            
        ?>
        <header>
            <nav>
                <ul>
                    <li><a href="main.php">Home</a></li>
                    <li><a href="login.php">LogIn</a></li>
                    <li><a href="registration.php">SignUp</a></li>
                </ul>
            </nav>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="loginForm" method="post">
            <label for="username">Username : </label>
            <input type="text" name="username" placeholder="username" id="username">
            <span class="errorMsg"> * <?php print $userErr ?></span>
            <br>
            <label for="password">Password : </label>
            <input type="password" name="password" placeholder="password" id="password" >
            <span class="errorMsg"> * <?php print $passErr ?></span>
            <br>
            <input type="submit" value="Submit" class="submit" name="submit">
        </form>
    </body>
</html>
