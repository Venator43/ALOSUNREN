<?php
   include 'ALOSUNREN1.0.php';
   UserSession("SecureLogin.php");
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
   		<form action = "" method = "post">
   			<h1>Welcome <?php echo $_SESSION["username"]; ?></h1>
   		<input type = "submit" value = "logout" name="submit"/><br />
   </body>
   
</html>
<?php
	if(isset($_POST['submit']))
	{
		UserLogout();
	}
?>