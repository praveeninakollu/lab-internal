<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
        <style>
        body{
         text-align:center;
         }
        </style>
    </head>
    <body>
        <?php
            function process($data){
                $data=htmlspecialchars($data);
                $data=trim($data);
                $data=stripslashes($data);
                return $data;
            }
            if(isset($_POST['submit'])){
                $username=$password=$confirm=$email="";
                $userErr=$passErr=$confErr="";
                if($_SERVER["REQUEST_METHOD"]=="POST"){
                    $username= process($_POST["username"]);
                    $password=process($_POST["password"]);
                    $confirm=process($_POST["repassword"]);
                    $email=process($_POST["email"]);                   
                }
                $host="localhost";
                $user="root";
                $pass="";
                $db="property";
                $conn = new mysqli($host,$user,$pass,$db);
                if($conn->connect_error){
                    die("connection failed".$conn->connect_error);
                }
                $sql="INSERT INTO `user`(`username`, `password`, `email`) VALUES ('$username','$password','$email');";
                if($conn->query($sql)===true){
                    print "<script>
                        alert('sucessfully logged in')
                    </script>";
                }else{
                    print $conn->error;
                }
            }
            
        ?>
        

        <header>
            <nav>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="login.php">LogIn</a></li>
                    <li><a href="registration.php">SignUp</a></li>
                </ul>
            </nav>
        </header>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="signupForm" method="post">
            <label for="username" >Username : </label>
            <input type="text" name="username" placeholder="username" id="username" onkeyup="userVal()">
            <span class="errorMsg" id="userErr" hidden>* username required</span>
            <br>   
            <label for="password">Password : </label>
            <input type="password" name="password" placeholder="password" id="password" onkeyup="passVal()" >
            <span class="errorMsg" id="passErr" hidden> * password required</span>
            <br>
            <label for="repassword">Confirm password: </label>
            <input type="password" name="repassword" placeholder="password" id="repassword" onkeyup="confVal()">
            <span class="errorMsg" id="confErr" hidden> * password must match</span>
            <br>
            <label for="email">Mail-id : </label>
            <input type="email" name="email" placeholder="email" id="email" >
            <br>
            <input type="submit" name="submit" value="Submit" class="submit" id="loginSub" >
            
        </form>
    </body>
</html>
