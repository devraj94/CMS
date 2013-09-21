<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");
    include(dirname(dirname(__FILE__))."./db_config.php");
    
    $institute_No=$_SESSION["institute_id"];
	$username=$_SESSION['username'];
      
	$sql1="SELECT user_id FROM users WHERE username='$username' ";
	$result1=mysql_query($sql1) or die("Error Connecting to Server1.".mysql_error());
	$row1=mysql_fetch_array($result1,MYSQL_ASSOC);
	$userid=$row1['user_id'];
	
	$sql2="SELECT instructor_id FROM instructor WHERE user_id=".$userid." ";
	$result2=mysql_query($sql2) or die("Error Connecting to Server2.".mysql_error());
	$row2=mysql_fetch_array($result2,MYSQL_ASSOC);
	$instructorid=$row2['instructor_id'];
	$_SESSION['instructor_id']=$instructorid;
	$courseid=$_GET['id'];
	$sql3="SELECT * FROM assignment WHERE instructor_id=".$instructorid." AND course_id='$courseid' AND institute_No='$institute_No'";
			$result3=mysql_query($sql3) or die("Error Connecting to Server3.".mysql_error());	
   $acyear=get_academic_year();
   $session=get_session();
		 // we should set the appropriate header information. Do not forget this.
			header("Content-type: text/xml;charset=utf-8");
			 
			$s = "<?xml version='1.0' encoding='utf-8'?>";
			$s .=  "<rows>";
			$page=1;
			$total_pages=1;
			$count=1;
			$s .= "<page>".$page."</page>";
			$s .= "<total>".$total_pages."</total>";
			$s .= "<records>".$count."</records>";
			while($row3=mysql_fetch_array($result3)){
				$s .= "<row id='". $row3['assignment_id']."'>";            
				$s .= "<cell>". $row3['topic']."</cell>";
				$s .= "<cell>". $row3['due_date']."</cell>";
				$s .= "<cell>". $acyear."</cell>";
				$s .= "<cell>". $session."</cell>";
				$s .= "<cell>". $row3['filename']."</cell>";
				$s .= "</row>";
			}
			$s .= "</rows>"; 
			 
			echo $s;
     
   ?> 