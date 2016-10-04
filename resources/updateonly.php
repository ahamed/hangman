<?php
session_start();
include "connect.php";
//echo "player0: ".$players[0];
$playerName =  $_SESSION['player0'].",".$_SESSION['player1'];
$mid = $_SESSION['mid'];

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