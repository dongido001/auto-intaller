<?php

  require("xmlapi.php");
  
   if($_SERVER["REQUEST_METHOD"] == "POST"){
	   
//$xmlapi = new xmlapi($_SERVER['HTTP_HOST']);   
$xmlapi = new xmlapi("secure142.sgcpanel.com");   
$xmlapi->set_port( 2083 );   
$xmlapi->password_auth($_POST['cpanel_uname'], $_POST['cpanel_password']);    
$xmlapi->set_debug(0);//output actions in the error log 1 for true and 0 false 

$cpaneluser = $_POST['cpanel_uname'];
$databasename = $_POST['cpanel_uname'] . "_SiTe";
$databaseuser = $databasename ;
$databasepass = $_POST['db_password'];

$msg = [];
//create database    
$createdb = $xmlapi->api1_query($cpaneluser, "Mysql", "adddb", array($databasename));   
 $msg[] =  $createdb[0]->error;
//create user 
$usr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduser", array($databaseuser, $databasepass));
$msg[] = $usr[0]->error ;   
//add user 
$addusr = $xmlapi->api1_query($cpaneluser, "Mysql", "adduserdb", array("".$cpaneluser."_".$databasename."", "".$cpaneluser."_".$databaseuser."", 'all'));
$msg[] = $addusr[0]->error;

   }
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
  <title>Set UP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container text-center">
  
  
  
    <div class="panel panel-primary">
      <div class="panel-heading"><h1>Simple Quick-Start Script ...</h1></div>
	  <p> please enter the cpanel, database details below... </p>
      <div class="panel-body">
	     <form method="POST" action="">
		     <?php if( $_SERVER['REQUEST_METHOD'] == "POST" ) {?>
                  <div class="alert alert-success" role="alert">
				      <?=  @$msg[0], @$msg[1], @$msg[2] ?>
				  </div>
             <?php }?>
           <div class="input-group">
             <span class="input-group-addon" id="basic-addon3">Cpanel Username</span>
               <input type="text" class="form-control" name="cpanel_uname" id="basic-url" aria-describedby="basic-addon3" required>
            </div>
                <br>		
				
           <div class="input-group">
             <span class="input-group-addon" id="basic-addon3">Cpanel Password</span>
               <input type="text" class="form-control" name="cpanel_password" id="basic-url" aria-describedby="basic-addon3" required>
            </div>
                <br>				

  <div class="form-group form-inline">
               <div class="input-group">
             <span class="input-group-addon" id="basic-addon3">DB Password</span>
               <input type="text" class="form-control" name="db_password" id="db_pasword" aria-describedby="basic-addon3" required>
            </div>
	       <button onClick="getPassword();" type="button"  class="btn btn-primary" role="button">  Generate </button>
  </div>
  
                <br>
			<input  type="submit" class="btn btn-info" value="Send">

         </form>
	  </div>
    </div>
  
</div>

<script>
  String.prototype.pick = function(min, max) {
    var n, chars = '';

    if (typeof max === 'undefined') {
        n = min;
    } else {
        n = min + Math.floor(Math.random() * (max - min + 1));
    }

    for (var i = 0; i < n; i++) {
        chars += this.charAt(Math.floor(Math.random() * this.length));
    }

    return chars;
};


// Credit to @Christoph: http://stackoverflow.com/a/962890/464744
String.prototype.shuffle = function() {
    var array = this.split('');
    var tmp, current, top = array.length;

    if (top) while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array.join('');
};


function getPassword(){
	
   var specials = '!@#$%^&*()_+{}:"<>?\|[];\',./`~';
   var lowercase = 'abcdefghijklmnopqrstuvwxyz';
   var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   var numbers = '0123456789';

    var all = specials + lowercase + uppercase + numbers;
	var password = '';
    password += specials.pick(2);
    password += lowercase.pick(3);
    password += uppercase.pick(2);
    password += all.pick(2, 15);
    password  = password.shuffle();
	
	document.getElementById("db_pasword").value = password;

}



</script>

</body>
</html>