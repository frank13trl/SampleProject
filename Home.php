<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <link href="Home.css" rel="stylesheet">
    </head>
    <body>
        <h1>
            <?php 
            echo " Welcome, ".$_SESSION["currName"]?>
        </h1>
        <div class="last">
            <h3>Report of your lastest submissions</h3>
                <?php
                $info = pg_connect("host=localhost dbname=Patient user=postgres password=root");
                $pid = $_SESSION["currID"];
                // echo $pid;
                $query = "Select last_visit, avg_read from public.\"medical_reading\" where pid='".$pid."';";
                $result = pg_query($info,$query);
                if(pg_num_rows($result)==0){
                    echo "<em>Hi, the date of your last visit will appear here</em><br>";
                    echo "<br><em>Sorry, we don't have any info</em>";
                }
                else{
                    $last = pg_fetch_assoc($result);
                    $lastvisit = $last["last_visit"];
                    $lastval = $last["avg_read"];
                    echo "Last visited on : $lastvisit<br>";
                    echo "<br>Average glucometer reading : $lastval";
                    //pg_close();
                }
                ?>
        </div>
        <div class="new">
            <h2 class="enter">Enter new readings</h2>
            <form method="POST">
                Input reading 1 : <input type='number' name='val1'><br>
                <br>Input reading 2 : <input type='number' name='val2'><br>
                <br>Input reading 3 : <input type='number' name='val3'><br>
                <br>Input reading 4 : <input type='number' name='val4'><br>
                <br>Input reading 5 : <input type='number' name='val5'><br>
                <br><input type="submit" value="Update Readings" name="update"><br>
            </form>
            <?php
            if(isset($_POST["update"])){
                $sum=0;
                $count=0;
                $arr=array();
                for($i=1;$i<6;$i++){
                    $tmp=$_POST["val$i"];
                    if($tmp==NULL){
                        $arr[]=0;
                        $count-=1;
                        continue;
                    }
                    $arr[]=$tmp;
                    $sum+=$tmp;
                    $count++;
                }
                $c="Select * from public.\"medical_reading\" where pid='".$pid."';";
                $check=pg_query($info,$c);
                if(pg_num_rows($check)>0){
                    $d="Delete from public.\"medical_reading\" where pid='".$pid."';";
                    $delete=pg_query($info,$d);
                }
                $avg=$sum/$count;
                $currtime=date("Y-m-d H:i:s");
                $upld="Insert into public.\"medical_reading\" values('".$pid."','".$currtime."','".$arr[0]."','".$arr[1]."','".$arr[2]."','".$arr[3]."','".$arr[4]."','".$avg."');";
                $upload=pg_query($info,$upld);
                if($upload){
                    echo "<br><em>Successfully updated</em>";
                }
            }
            pg_close();
            ?>
        </div>
    </body>
</html>