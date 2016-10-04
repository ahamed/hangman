<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		
		<title>Hangman game</title>
		
        <script src="../bower_components/jquery/dist/jquery.min.js"></script>
               
			
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	-->
		<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
        
        <style>
            .custom{
                width: 50%;
                background: white;
                margin-top: 200px;
                padding: 80px;
                
            }
            .set{
                margin-bottom: 10px;
            }
        </style>
	</head>
    <body style="background: gray;">
        <div class="container">
            <div class="row customRow">
                <div class="col-sm-6 col-sm-offset-3 custom showOrNot" data-show="true">
                    <form  method="post" action="#">
                        <div class="row">
                            <div class="col-sm-12 set">
                                <input type="text" name="user" placeholder="user name" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 set">
                                <input type="password" name="pass" placeholder="Password" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 set">
                                <input type="text" name="mid" placeholder="match ID" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 set">
                                <input id="twoPlayers" type="submit" name="login" class="btn btn-danger form-control" value="login">
                            </div>
                        </div>
                    
                    </form>
                </div>
            </div>
        </div><!-- end the container-->
        <?php
            session_start();
            include "../resources/connect.php";
            if(isset($_POST['login'])){
                $user = $_POST['user'];
                $pass = $_POST['pass'];
                $mid = $_POST['mid'];
                $sql = "select * from user where user = '$user' and pass = '$pass'";
                $s = mysqli_query($conn,$sql) or die("select from user: ".mysqli_error($conn));
                $fetch_user = mysqli_fetch_array($s,MYSQLI_NUM);
                
                if($s){
                    
                    $_SESSION['login'] = 87;
                    $_SESSION['mid'] = $mid;
                    $_SESSION['user'] = $user;
                    $_SESSION['name'] = $fetch_user[2];
                    
                    $minfo = "select * from match_info where mid = '$mid'";
                    $checkmid = mysqli_query($conn, $minfo) or die("Select from match info".mysqli_error($conn));
                    $rows = mysqli_num_rows($checkmid);
                    echo $rows;
                    if($rows==1){
                        echo "Found!";
                        $data = mysqli_fetch_array($checkmid, MYSQLI_NUM);
                        $name = explode(",",$data[1]);
                        $user_name = "";
                        echo "array size: ".count($name);
                        if(count($name) === 1){
                            $user_name = $data[1].",".$fetch_user[2];
                            
                            
                            
                            $finalVal = $data[1].",0,".$fetch_user[2].","."0";
                            $s = mysqli_query($conn, "update game_data set pressed = '$user_name' , score = '$finalVal' where mid = '$mid'");
                            
                        }elseif(count($name) === 2){
                            $user_name = $data[1];
                        }
                        
                        $update = "update match_info set users = '$user_name' where mid = '$mid'";
                        $u = mysqli_query($conn, $update) or die(mysqli_error($conn));
                        
                        
                    }else{
                        echo "not found!";
                        // insert new records here
                        $name = $fetch_user[2];
                        $nameVal = explode(",",$name);
                        $finalVal = $nameVal[0].",0";
                        $ins = "insert into match_info values('$mid','$name',0,0,0,0,'','')";
                        $s = mysqli_query($conn, "insert into game_data values('$mid','','$name','$finalVal','')");
                        $i = mysqli_query($conn,$ins) or die(mysqli_error($conn));
                        if($i){
                            echo "Successfull";
                            
                        }
                    }
                    ?>
        <script>
            window.location.href='../index.php';
        </script>  
                        
                        <?php
                }
            }
            
        ?>
        
    </body>
</html>