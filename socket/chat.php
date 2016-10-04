<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        
        <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    </head>
    <body>
       
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <form method="post">
                        <input type="text" name="msg" placeholder="Message" class="form-control">
                        <input type="submit" name="sub" id="sub" value="submit" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
        
        <script>
    $(document).ready(
            function() {
                setInterval(function() {
                    echo "refreshed";
                }, 3000);
            });
</script>
        
    </body>
    
    
    <?php
    session_start();
    include "../resources/connect.php";
    echo $_SESSION['login'];
    if(isset($_SESSION['login']) && $_SESSION['login'] == 87){
        if(isset($_POST['sub'])){
            $msg = $_POST['msg'];
            $mid = $_SESSION['mid'];
            $user = $_SESSION['user'];
            $sql = "select * from game_data where mid = '$mid'";
            $s = mysqli_query($conn,$sql);
            $fetch_data = mysqli_fetch_array($s,MYSQLI_NUM);
            //echo $fetch_data[2];
            $rows = mysqli_num_rows($s);
            if($rows<1){
                $ins = "insert into game_data values('$mid','$user','$msg')";
                $s = mysqli_query($conn,$ins);
            }else{
                $ms = $fetch_data[2].",".$msg;
                $upd = "update game_data set pressed = '$ms' where mid = '$mid'";
                $up = mysqli_query($conn,$upd);
            }
            
            $i =0;
            $val = explode(",",$fetch_data[2]);
            while($i < count($val)){
                echo $val[$i++]."<br>";
            }
        }
        
    }
        
    ?>
</html>
