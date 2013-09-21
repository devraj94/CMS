<?php	
	session_start();
	if(!isset($_SESSION['username']) || !isset($_SESSION['password']))
	{
		header("Location:../login.php"); ///location of page to show error message..###############
	}else{
		$username=$_SESSION['username'];
		$password=$_SESSION['password'];
		$_SESSION["user_pass"]=0;
		
	} 
?>