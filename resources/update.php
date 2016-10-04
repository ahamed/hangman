<?php
session_start();
include "connect.php";
//echo "player0: ".$players[0];
$playerName =  $_SESSION['player0'].",".$_SESSION['player1'];
$mid = $_SESSION['mid'];
$getAll = mysqli_query($conn, "select score from game_data where mid = '$mid'");
$data = mysqli_fetch_array($getAll,MYSQLI_NUM);
$myData = explode(',',$data[0]);
for( $i = 0; $i < count($myData); $i++){
    if($_SESSION['player1'] == $myData[$i]){
        $scr = (int) $myData[$i+1] + 1;
        $myData[$i+1] =''.$scr;
        break;
    }
}
$scrVal = '';
for( $i = 0; $i < count($myData); $i++){
    $scrVal .= $myData[$i];
    if($i < count($myData)-1){
        $scrVal .= ",";
    }
}


mysqli_query($conn,"update game_data set score = '$scrVal' where mid = '$mid'");
$sql = mysqli_query($conn,"update match_info set users = '$playerName'");
if(!$sql){
echo mysqli_error($conn);
}else{
    ?>
<script>
    window.location.href="../play.php";
</script>

<?php
}