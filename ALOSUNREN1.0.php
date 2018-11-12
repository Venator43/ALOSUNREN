<?php
	//Start ALOSUNREN(Advance Libary fOr eaSyer Use aNd moRe sEcure oNe)
	/*
		>LoadALOSUNRENInfoData_|
		>
		>Loading Info.......
		>
		>ALOSUNREN Version : v.1.0
		>Known Vuln : NULL
		>Known Bug : NULL
		>
		>LoadALOSUNRENFunctionList_|
		>
		>Loading Info.....
		>Loading Database....
		>Database Loaded!
		>Searching Function....
		>Loading Function.....
		>Function Loaded!
		>Printing Now....
			Function List:
			@ALOSUNREN test function:		
			@TESTconn():Test Connection With Library
			@File input function:
			@FILTinp(temporary_dictionary,upload_dictionary):Call APATISFON Filter Note:Use this if ypu want to make your own upload function 
			@IMGinp(input_name,upload_dictionary,max_file_size(default=2097152)):Use For Uploading Image File
			@Login function:
			@UserSession(login_page):Session Set
			@UserLogin(login_table,user_row,password_row,input_name_user,input_name_pass,welcome_page):Login Function
			@UserAdd(table_name,username_inputname,password_inputname,row_name,cost_value):Add a new user + hash password with BCRYPT
			@CRUD function:
			@DBinsert(table_name,row_name,value):Input data to MySQL record
			@DBselect(table_name,row(s)_name,where_statment(optional)):Select data from MySQL table 
			@DBupdate(table_name,row_name,value,where_argument):Update data in MySQL database
			@DBdelete(table_name,where_argument):Delete data in MySQL database
		>
	*/

	//Database Connection
	define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'testlib');
    $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	
	if (!$conn) 
	{
   		die("Error : " . mysqli_connect_error());
	}
	function DBinsert($table,$row,$iname)
	{
		$value = mysqli_real_escape_string($GLOBALS['conn'],$iname);
		$sql = "INSERT INTO $table ($row) VALUES ('$value')";

		
		if(!mysqli_query($GLOBALS['conn'], $sql))
		{
			return FALSE;
    		echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
		}
		else
		{
			return TRUE;
		}
	}
	function DBselect($table,$row,$where = "'1' = '1'")
	{
		$sql="SELECT $row FROM $table where $where";
		$result=mysqli_query($GLOBALS['conn'],$sql);

		$rowarray = array();
		// Associative array
		while($row=mysqli_fetch_array($result,MYSQLI_ASSOC)){array_push($rowarray, $row);}
		return $rowarray;
	}
	function DBupdate($table,$row,$value,$where)
	{
		$truevalue = mysqli_real_escape_string($GLOBALS['conn'],$value);

		$sql = "UPDATE $table SET $row='$truevalue' WHERE $where";

		if (!mysqli_query($GLOBALS['conn'], $sql)) {
    		echo "Error updating record: " . mysqli_error($conn);
    		return FALSE;
		}
		else 
		{
    		return TRUE;
		}
	}
	function DBdelete($table,$where)
	{
		$sql = "DELETE FROM $table WHERE $where";

		if (!mysqli_query($GLOBALS['conn'], $sql)) 
		{
			return FALSE;
    		echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
		}
		else
		{
			return TRUE;
		}
	}
	function UserLogin($table,$rname,$rpass,$uname,$pass,$url)
	{
		session_start();
		// username and password sent from form 
      
      	$myusername = mysqli_real_escape_string($GLOBALS['conn'],$_POST[$uname]);
      	$mypassword = mysqli_real_escape_string($GLOBALS['conn'],$_POST[$pass]); 
		
      	$sql = "SELECT * FROM $table where $rname =	'$myusername'";
		$result = mysqli_query($GLOBALS['conn'], $sql);

		if (mysqli_num_rows($result) == 1) 
		{
    		// output data of each row
    		while($row = mysqli_fetch_assoc($result)) 
    		{
        		$pass = $row[$rpass];
    		}
    		if(password_verify($mypassword, $pass))
      		{
      			session_start();
                            
                // Store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["username"] = $myusername;                            
                
                // Redirect user to welcome page
                header("location: $url");
      		}
      		else
      		{
      			echo "<script>alert('Your Login Name or Password is invalid');</script>";
      		}
		} 
		else 
		{
    		echo "<script>alert('Your Login Name or Password is invalid');</script>";
		}
	}
	function UserSession($lpage)
	{
		session_start();

   		if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
   		{
    		header("location: $lpage");
    		exit;
		}
	}
	function UserAdd($table,$iname,$ipass,$row,$cost)
	{
		$Username = mysqli_real_escape_string($GLOBALS['conn'],$_POST[$iname]);
		$Password = mysqli_real_escape_string($GLOBALS['conn'],$_POST[$ipass]);
		$options = ['cost' => $cost,];
		$TruePassword = password_hash($Password, PASSWORD_BCRYPT, $options);
		$sql = "INSERT INTO $table ($row) VALUES ('$Username','$TruePassword')";

		
		if(!mysqli_query($GLOBALS['conn'], $sql))
		{
			return FALSE;
    		echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
		}
		else
		{
			return TRUE;
		}
	}
	function TESTconn()
	{
		echo "Connection Establish,Libary Ready To Use";
	}
	function FILTinp($tmpdict,$fdict)//Use this if you want to make your own input function
	{
		copy($tmpdict, $fdict . "/gdhbfh.png"); //Copy Uploded File
		$test = rename($fdict . "/gdhbfh.png",$fdict . "/test.txt"); //Change File Extension To TXT
		fwrite(fopen($fdict . "/test.txt","a+"),"//"); //Write "//" Necesary???????
		$cek = file_get_contents($fdict . "/test.txt"); //Get Content Of File And Return It As String 
		if($cek != null)										//_
		{														// |
			$file = explode( "<?php", $cek );                   // |
			if(sizeof($file) == 1)								// |
			{													// |
				move_uploaded_file($tmpdict,$fdict . "/"	    // |
				. $file_name);									// |
				unlink($fdict . "/test.txt");		            // |
		        return $file_name;				                // |
			}													//  \
			else 												//   > Filter
			{													//  /
		 		echo "Script Detected Rejecting File";			// |
		 		unlink($fdict . "/test.txt");			        // |
			} 													// |
		}														// |
		else 													// |
		{														// |
			echo "File Acting Not Intended Rejecting File";		// |
		}                                                       //_|
	}
	function IMGinp($iname,$fdict,$msize = 2097152)
	{
		$errors= array();
	    $file_name = $_FILES[$iname]['name'];
	    $file_size =$_FILES[$iname]['size'];
	    $file_tmp =$_FILES[$iname]['tmp_name'];
	    $file_type=$_FILES[$iname]['type'];
	    $file_ext=strtolower(end(explode('.',$_FILES[$iname]['name'])));
	    
	    $expensions= array("jpeg","jpg","png");
	    
	    if(in_array($file_ext,$expensions)=== false)
	    {
	       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
	    }
	    if($file_size > $msize)
	    {
	       $errors[]='File size cannot be more than ' . $msize/1024 . ' MB';//Error MSG For Extending Size
	    }
	    
	    if(empty($errors)==true)
	    {
	    	//APATISFON(Advance PHP Alghorithme To dIfferentiate Safe File Or Not) For IMG Start Here

			copy($file_tmp, $fdict . "/gdhbfh.png"); //Copy Uploded File
			$test = rename($fdict . "/gdhbfh.png",$fdict . "/test.txt"); //Change File Extension To TXT
			fwrite(fopen($fdict . "/test.txt","a+"),"//"); //Write "//" Necesary???????
			$cek = file_get_contents($fdict . "/test.txt"); //Get Content Of File And Return It As String 
			if($cek != null)										//_
			{														// |
				$file = explode( "<?php", $cek );                   // |
				if(sizeof($file) == 1)								// |
				{													// |
					move_uploaded_file($file_tmp,$fdict . "/"		// |
					. $file_name);									// |
					unlink($fdict . "/test.txt");		            // |
			        echo "Success";								    // |
				}													//  \
				else 												//   > Filter
				{													//  /
			 		echo "Script Detected Rejecting File";			// |
			 		unlink($fdict . "/test.txt");			        // |
				} 													// |
			}														// |
			else 													// |
			{														// |
				echo "File Acting Not Intended Rejecting File";		// |
			}														//_|
	    }
	    else
	    {
	       echo $errors[0];
	    }
	}
?>