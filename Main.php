<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>HealthCare</title>
        <link href="Main.css" rel="stylesheet">
    </head>
    <body>
        <header>
            <h1>HealthCare 4 All</h1>
            <em>Healthcare group of companies</em>
        </header>
        <main>
            <div class="half">
                <p><em>HealthCare 4 All aims at improving the health and wellness of the worlds population.
                    We dream of a better world with healthy people</em>
                </p>
                <h4>What we do here?</h4>
                <p>
                    We collect your data, so that we could keep track of your health. The information you provide 
                    about your measure of glucose level in blood will be used by our doctors and healthcare specialists to
                    assess your current heath conditions. We will show you the way and will guide you to have a proper lifestyle
                </p>
            </div>
            <div class="half">
                <h3>User Login</h3>
                <form action="Login.php" method="POST">
                    <input type="text" name="usr" placeholder="Username"><br>
                    <br>
                    <input type="password" name="pwd" placeholder="Password"><br>
                    <br>
                    <input type="submit" name="login" value="Login">
                </form><br>
                <?php
                error_reporting(0);
                    if(isset($_POST['login'])){
                       $id=$_POST['usr'];
                       $pw=$_POST['pwd'];
                       $db=pg_connect("host=localhost dbname=Patient user=postgres password=root");
                       if(!$db){
                           echo "Unable to connect to database";
                        }
                        else{
                            $query = "Select pid, name from public.\"patient_info\" where username='".$id."' and password='".$pw."'";
                            $result = pg_query($db,$query);
                            $row = pg_num_rows($result);
                            $data = pg_fetch_assoc($result);
                            $_SESSION["currID"] = $data["pid"];
                            $_SESSION["currName"] = $data["name"];
                        if($row==1){
                            echo "<em>Login Successful - You will be redirected to your Dashboard<em><br>";
                            header("refresh:3; url=Home.php");
                        }
                        else{
                            echo "<br><em>Incorrect username or password<em><br>";
                        }
                        }
                    }
                    pg_close();
                ?>
                <a href="Signup.php">New user? Sign up here</a><br>
                <br>
                <a href="#">Forgot Password</a>
            </div>
        </main>
        <footer>
            <div class="half">
                <h2>HealthCare group of companies</h2>
                <a href="#">Privacy Policy</a>
            </div>
            <div class="half">
                <h4>Our partners</h4>
                <nav>
                    <ul>
                        <li>ABC</li>
                        <li>XYZ</li>
                        <li>DEF</li>
                    </ul> 
                </nav>
            </div>
            <div class="half">
                <h4>Contact us</h4>
                <nav>
                    <ul>
                        <li>E-mail <a href="#">ABC</a></li>
                        <li>Phone <a href="#">+91 12345 67890</a></li>
                        <li>Facebook <a href="#">HealthCare@facebook.com</a></li>
                    </ul> 
                </nav>
            </div>
        </footer>
    </body>
</html>