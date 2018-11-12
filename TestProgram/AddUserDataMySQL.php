<html>
   
   <head>
      <title>Login Page</title>
      
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#FFFFFF">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
               		<input type="text" value="" name="username"><br>
               		<input type="password" value="" name="password"><br>
                 	<input type = "submit" value = "Submit" name="submit"/><br />
               </form>
               
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"></div>
						
            </div>
				
         </div>
			
      </div>

   </body>
</html>
<?php
	include 'ALOSUNREN1.0.php';
	if(isset($_POST['submit']))
	{
		$where = 10;
		UserAdd("user","username","password","username,password",$where);
	}
?>