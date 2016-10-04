<!DOCTYPE html>
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
	</head>
    <body style="background: gray;">
        <div class="container">
            <div class="row customRow">
                <span data-show="showing"></span>
                <div class="col-sm-6 col-sm-offset-3 custom showOrNot" data-show="true">
                    <div class="row">
                        <div class="col-sm-12 set">
                            <button id="single"  class="btn btn-danger form-control">Sigle Player</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 set">
                            <button id="twoPlayers" class="btn btn-danger form-control">2 Players</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 option" style="display: none; margin-top: 10px;">
                            <input type="text" id="name1" class="form-control" placeholder="Enter a player1 name">
                            <input type="button" id="next" value="Next >>" class="btn btn-danger btn-block" style="margin-top: 5px;">
                        </div>
                        <div class="col-sm-12 namePlate" style="display: none;  margin-top: 10px;">
                            <!--<label class="form-inline" for="name">Player Name: </label>-->
                            <input type="text" id="name2" class="form-control" placeholder="Enter  player2 name">
                            <input type="button" id="go" value="Play" class="btn btn-danger btn-block" style="margin-top: 5px;">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div><!-- end the container-->
        <?php
        session_start();
        
        ?>
        <script type="text/javascript">
            $(document).ready(function(){
               //alert(localStorage.getItem("win")); 
                $("#single").click(function(){
                    localStorage.setItem("method","single");
                   window.location.href = 'play.php'; 
                });
                $("#twoPlayers").click(function(){
                   localStorage.setItem("method","double"); 
                    $(".option").show("slow");
                    $(".namePlate").hide("slow");
                    window.location.href = "play.php";
                    
                });
              
                
                
            });
               
            
        </script>
        
        
        <?php
        ?>
        
    </body>
</html>