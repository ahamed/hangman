<!doctype html>
<html>
	<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta charset="UTF-8">
		<link rel="stylesheet" href="style.css">
		<title>Hangman game</title>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
			
		<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	-->
		<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <style>
            span{
                color: white;
            }
            th,td{
                color: red;
            }
            .scorebar{
                height: 200px;
                background: black;
            }
        </style>
	</head>
	<body style="background: gray;">
		
		<?php
                session_start();
                include "resources/connect.php";
                
                $mid = $_SESSION['mid'];
                $sql = "select * from match_info where mid = '$mid'";
                $s = mysqli_query($conn,$sql);
                $data = mysqli_fetch_array($s,MYSQLI_NUM);
                $players = explode(',',$data[1]);
                
                
        
                $who = $_SESSION['name']==$players[0] ? $players[1] : $players[0];  
        
               if(count($players) == 2){
                   if($players[0] == $_SESSION['name']){
                       
                       $_SESSION['meactive'] = 1;
                       
                   }else{
                       $_SESSION['meactive'] = 0;
                       $gql = mysqli_query($conn,"select word,who from game_data where mid = '$mid'");
                       $data = mysqli_fetch_array($gql,MYSQLI_NUM);
                       $count  = mysqli_num_rows($gql);
                       if($count === 0){
                           
                       }
                       $_SESSION['word'] = $data[0];
                       $_SESSION['player0'] = $players[1];
                       $_SESSION['player1'] = $players[0];
                   //    echo "Data 4 is: ".$data[1];
                       if($data[1] != $_SESSION['name']){
                           $_SESSION['start'] = 'start';
                       }else{
                           $_SESSION['start'] = 'pause';
                       }
                       
                   }
               }
                
        
        ?>
		<div class="container myContainer">
			<div class="row pb"></div>
			<div class="row firstRow">
				<div class="col-sm-6 col-sm-offset-3">
                    <div class="row">
                        <div class="col-sm-12 inp" style="background: black;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4><span><?php echo $_SESSION['name'];?> gives a word for <?php echo $who."<small> account for (".$_SESSION['name']."</small>)";?></span></h4>
                                </div>
                                
                            </div>
                            <div class="row">
                                <?php 
                                    if($_SESSION['meactive'] == 1){
                                        ?>
                                <div class="col-sm-12">
                                    <form method="post" name="wordForm">
                                        <div class="col-sm-10">
                                            <input  type="text" name="word" placeholder="Enter a word" class="form-control">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" name="submit" value="send" class="btn btn-danger">
                                        </div>

                                    </form>
                                </div>
                                <?php
                                    }else{
                                        ?>
                                <div class="col-sm-12">
                                    <form method="post" name="wordForm">
                                        <div class="col-sm-10">
                                            <input  type="text" name="word" placeholder="Enter a word" class="form-control" disabled="true">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="submit" name="submit" value="send" class="btn btn-danger" disabled="true">
                                        </div>

                                    </form>
                                </div>
                                
                                <?php
                                        
                                    }
                                ?>
                                
                                
                                
                                <?php
                                session_start();
                                // send button code section
                                    if(isset($_POST['submit'])){
                                        
                                        $word = $_POST['word'];
                                        $gdt = mysqli_fetch_array(mysqli_query($conn,"select score from game_data where mid = '$mid'"),MYSQLI_NUM);
                                        
                                        $del = mysqli_query($conn,"delete from game_data where mid = '$mid'");
                                        
                                        $keypad = $players[0].",".$players[1];
                                        $name = $_SESSION['name'];
                                        $sql = "insert into game_data values('$mid','$word','$keypad','$gdt[0]','$name')";
                                        $s = mysqli_query($conn,$sql);
                                        if($s){
                                            ?>
                                    <script>
                                        window.location.href="../hangman/play.php";
                                    </script>
                                
                                        <?php    
                                        }
                                        
                                    }
                                    
                                
                                ?>
                            </div>
                            
                        </div>
                    </div>
					<div class="row">
						<div class="col-sm-12 message">

						</div>
					</div><!-- end inner row-->
					
                    <div class="row">
                        <div class="col-sm-12" style="background: black;">
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped active progress-bar-danger myBar" role="progressbar"
                              aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:0%">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
						<div class="content">
							<div class="col-sm-12 showDesh">
							
                            </div>
						</div>
						
					</div><!-- end inner row-->
					
				</div>
                <div class="col-sm-3 scorebar">
                    <table class="table table-stripped table-borderd">
                        
                        <?php
                        session_start();
                        include "resources/connect.php";
                        $mid = $_SESSION['mid'];
                            $sql = mysqli_query($conn,"select score from game_data where mid = '$mid'");
                            $fetch = mysqli_fetch_array($sql,MYSQLI_NUM);
                            $data = explode(',',$fetch[0]);
                            ?>
                        
                            <tr>
                                <th></th>
                                <th><?php echo $data[2];?></th>
                                <th><?php echo $data[0];?></th>
                            </tr>
                            <tr>
                                <td>win</td>
                                <td><?php echo $data[1];?></td>
                                <td><?php echo $data[3];?></td>
                            </tr>
                        
                        <?php
                            
                        ?>
                       
                    </table>
                </div>
			</div><!-- end first row-->
			<div class="row secondRow">
				
                    <div class="col-sm-6 col-sm-offset-3 board">
                        <div class="row">
                            <div class="col-sm-12 row-1">
                                <input class="btns" type="button" id="b1" value="Q" name="b1">
                                <input class="btns" type="button" id="b2" value="W" name="b2">
                                <input class="btns" type="button" id="b3" value="E" name="b3">
                                <input class="btns" type="button" id="b4" value="R" name="b4">
                                <input class="btns" type="button" id="b5" value="T" name="b5">
                                <input class="btns" type="button" id="b6" value="Y" name="b6">
                                <input class="btns" type="button" id="b7" value="U" name="b7">
                                <input class="btns" type="button" id="b8" value="I" name="b8">
                                <input class="btns" type="button" id="b9" value="O" name="b9">
                                <input class="btns" type="button" id="b10" value="P" name="b10">
                            </div>
                        </div><!-- end inner row-->
                        <div class="row">
                            <div class="col-sm-12 row-2">
                                <input type="button" id="b0" class="btninv">
                                <input class="btns" type="button" id="b11" value="A" name="b11">
                                <input class="btns" type="button" id="b12" value="S" name="b12">
                                <input class="btns" type="button" id="b13" value="D" name="b13">
                                <input class="btns" type="button" id="b14" value="F" name="b14">
                                <input class="btns" type="button" id="b15" value="G" name="b15">
                                <input class="btns" type="button" id="b16" value="H" name="b16">
                                <input class="btns" type="button" id="b17" value="J" name="b17">
                                <input class="btns" type="button" id="b18" value="K" name="b18">
                                <input class="btns" type="button" id="b19" value="L" name="b19">
                            </div>
                        </div><!-- end inner row-->

                        <div class="row">
                            <div class="col-sm-12 row-3">
                                <input type="button" value="" id="b0" class="btninv">
                                <input type="button" id="b0" value="" class="btninv">
                                <input class="btns" type="button" id="b20" value="Z" name="b20">
                                <input class="btns" type="button" id="b21" value="X" name="b21">
                                <input class="btns" type="button" id="b22" value="C" name="b22">
                                <input class="btns" type="button" id="b23" value="V" name="b23">
                                <input class="btns" type="button" id="b24" value="B" name="b24">
                                <input class="btns" type="button" id="b25" value="N" name="b25">
                                <input class="btns" type="button" id="b26" value="M" name="b26">
                            </div>
                        </div><!-- end inner row-->
                    </div><!-- end col-->
                
			</div><!-- end second row-->
			
		</div><!-- end container-->
		
        
        
        <script language="javascript" type="text/javascript">
		       
                var method  = localStorage.getItem("method") || "none";
            
            
                
            
            if(method == "none" || method == "single"){
                
              
                
                
            }else if( method == "double"){
                
                
                var win = localStorage.getItem("win") || 0;
                var loss = localStorage.getItem("loss") || 0;
                
             
                var player = '<?php echo ($players[$turn]);?>';
                
                <?php
                    if($_SESSION['meactive']== 0 && ($_SESSION['start'] == 'start')){
                        ?>
                    loadThis();
                <?php
                    }else{
                        // refresh the page
                        ?>
                    setTimeout(function(){
                       window.location.reload(1);
                    }, 20000);
                <?php
                    }
                ?>
                
                
                $("#pa").click(function(){
                   
                    //localStorage.setItem("turn",null);
                    window.location.reload();
                    
                });
                
                
                
                
            }
            
                
			
			// Hang man game part

			
			
			function getRandom(min, max) {
			    return Math.floor(Math.random() * (max - min + 1)) + min;
			}
			
			
					

			function getValueOfLetter(ind){
				return $("#"+ind).val().toLowerCase();
			}
			
            
            
            
            // function loadThis 
            
            
			function loadThis(){
                
                var selectedWord = '<?php echo $_SESSION['word'];?>';
                
                
                
                var wordLength = selectedWord.length;
				
				for( var i = 1; i <= wordLength; i++){
					$(".showDesh").append("<span id='s"+i+"'>_</span>");
					
				}
				
				var indicator = 1;
				var isHang = 0;
				var checker = [];
				var isFound = false;
				var isMatch = 0;
				var msg = "HANG MAN!";
				var isFinished = false;
                var isWin = false;
                var isLoss = false;
				
			
			
			
				// initialize the checker array with zero
					
					for( var i = 0; i < wordLength; i++){
						checker[i] = 0;
					}
					
		
		
				// initialization buttons
				
					for( var i =1 ; i <= 26; i++){
						$("#b"+i).prop("disabled",false);
					}
					$("#pa").prop("disabled",false);
               
				
                // button click / input click checking
                
				$("input").click(function(){
				
					if(!isFinished){
						var id = this.id;
					var letter = getValueOfLetter(id);
                       
                        
					isFound = false;				
					
				
				
				
					//check if the pressed letter is contained in the word or not
					for( var i = 0; i < wordLength; i++){
						if(letter === selectedWord[i]){
							if(checker[i] === 0){
								checker[i] = 1;
								$("#s"+(i+1)).text(letter);
								isFound = true;
								isMatch ++;
							}

						}
					}


					if(!isFound){
						isHang ++;
                        var val = 1.0;
                        val = isHang * (100/9);
                        $(".myBar").css("width",val+"%").animate("slow");
                        
						if( isHang >= 9){
                            isLoss = true;
							$(".pg9").show();
                            //localStorage.setItem("loss",(parseInt(localStorage.getItem("loss") || '0')+1));
							localStorage.setItem("loss",parseInt(loss)+1);
							$(".message").html("Hang the man!<br> The word is: <b>"+ selectedWord+"</b><br>Win: "+localStorage.getItem("win")+"<br>Loss: "+localStorage.getItem("loss"));
							isFinished = true;
                            
                            
						
													
						}
						
					}
					if(isMatch === wordLength){
                        isWin  = true;
						localStorage.setItem("win",parseInt(win)+1);
                        $(".message").html("Congratulations!<br> The word is: "+ selectedWord+"<br>Win: "+localStorage.getItem("win")+"<br>Loss: "+localStorage.getItem("loss"));
					}
					
					$(this).prop('disabled', true);
					$(this).css("color","red");
					$("#pa").prop("disabled",false);
					
                        
                    if(isWin){
                        alert("Congratulations!");
                        window.location.href="resources/update.php";
                        
                    }
                        if(isLoss){
                            alert("Sorry dude! You have to hang :(");
                            window.location.href="resources/updateonly.php";
                        }
					
					}
				
									
				});
				
                
                
                
                <?php
                
                
                ?>
               
				
				
			} 
			
			//$(document).ready(loadThis);
			
			
			
			
		</script>
                
                
                
                <?php
                
        ?>
		
		
		<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	</body>
	
</html>
