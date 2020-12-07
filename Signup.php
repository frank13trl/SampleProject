<!DOCTYPE html>
<html>
    <head>
        <title>Sign Up</title>
        <link href="Signup.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <h3>Sign Up</h3>
            <form action="Signup.php" method="POST">
                <input type="text" name="name" placeholder="Name"><br>
                <br>
                <input type="email" name="mailid" placeholder="E-mail"><br>
                <br>
                <input type="text" name="address" placeholder="City"><br>
                <br>
                <input type="number" name="number" placeholder="Contact number"><br>
                <br>
                <input type="text" name="uname" placeholder="Username"><br>
                <br>
                <input type="password" name="pass" placeholder="New password"><br>
                <br>
                <input type="submit" name="signup" value="Sign Up">
                <br>
            </form><br>
            <?php
            // error_reporting(0);
            if(isset($_POST['signup'])){
                $name=$_POST['name'];
                $mail=$_POST['mailid'];
                $place=$_POST['address'];
                $num=$_POST['number'];
                $user=$_POST['uname'];
                $pword=$_POST['pass'];
                $newdb=pg_connect("host=localhost dbname=Patient user=postgres password=root");
                if(!$newdb){
                    echo "Unable to connect to database";
                 }
                 $checkq = "Select * from public.\"patient_info\" where username like '".$user."' and password like '".$pword."';";
                 $check = pg_query($newdb,$checkq);
                 $res=pg_fetch_row($check);
                 if(empty($res)){
                    $query = "Insert into public.\"patient_info\" values(DEFAULT,'".$name."','".$mail."','".$place."','".$num."','".$user."','".$pword."');";
                    $sign = pg_query($newdb,$query);
                    
                    if($sign){
                        echo "\nRegistered successfully<br>";
                    }
                    else{
                        echo "<em>*Please fill all the details<em><br>";
                    }  
                 }
                 else{
                    echo "<em>*This username is already taken<em><br>";
                 }
                 
                 pg_close();
             }
            ?>
            <br><a href="Main.php">Back to homepage</a>
        </div>
    </body>
</html>