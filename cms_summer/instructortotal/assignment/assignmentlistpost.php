<?php 
    include(dirname(dirname(__FILE__))."./../user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");
    include(dirname(dirname(__FILE__))."./../db_config.php");
	
	$instName = $_SESSION["instName"];
	$username = $_SESSION["username"];

      $id=$_GET['id'];
	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	# Getting 'user_id' from 'users' table
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 		
		$user_id=$row["user_id"];
		break;
	}

	# Getting details from 'instructor' table
	$sql = "SELECT * FROM instructor_m_details WHERE user_id = '$user_id'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 
		$institute_id = $row["institute_id"];
		$instructorid = $row["instructor_id"];
	}
	$sem=$_GET['sem'];
	 $page = $_GET['page']; 
     
    // get how many rows we want to have into the grid - rowNum parameter in the grid 
    $limit = $_GET['rows']; 
     
     $courseid=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
    // if we not pass at first time index use the first column for the index or what you want

    //if search enable
    if ($_REQUEST["_search"] == "false") {
        $where1 = " 1";
    } else {

        $value = mysql_real_escape_string($_REQUEST["searchString"]);
        $searchOper = mysql_real_escape_string($_REQUEST["searchOper"]);
        $searchField = mysql_real_escape_string($_REQUEST["searchField"]);
        $where1 = sprintf("%s='%s'", $searchField, $value);
    }
	
	$my_sql = "SELECT COUNT(*) AS count
                    FROM assignment_m_details WHERE instructor_id=".$instructorid." AND course_id='$courseid' AND institute_id='$institute_id' AND ".$where1." ORDER BY assignment_id asc";
                    $result=mysql_query($my_sql);
					 
						if($result){
									$row = mysql_fetch_array($result);
									$count = $row['count'];
								}else{
									$count=1;
								}
								// calculate the total pages for the query 
						if( $count > 0 && $limit > 0) { 
									  $total_pages = ceil($count/$limit); 
						} else { 
									  $total_pages = 0; 
						} 
						 
						// if for some reasons the requested page is greater than the total 
						// set the requested page to total page 
						if ($page > $total_pages) $page=$total_pages;
						 
						// calculate the starting position of the rows 
						$start = $limit*$page - $limit;
						 
						// if for some reasons start position is negative set it to 0 
						// typical case is that the user type 0 for the requested page 
						if($start <0) $start = 0; 
	$sql3="SELECT * FROM assignment_m_details WHERE instructor_id=".$instructorid." AND course_id='$courseid' AND institute_id='$institute_id' AND ".$where1." ORDER BY assignment_id asc LIMIT $start , $limit";
			$result3=mysql_query($sql3) or die("Error Connecting to Server3.".mysql_error());	
   $acyear=get_academic_year();
   $session=get_session();
   
		 // we should set the appropriate header information. Do not forget this.
			header("Content-type: text/xml;charset=utf-8");
			 
			$s = "<?xml version='1.0' encoding='utf-8'?>";
			$s .=  "<rows>";
			$s .= "<page>".$page."</page>";
			$s .= "<total>".$total_pages."</total>";
			$s .= "<records>".$count."</records>";
			while($row3=mysql_fetch_array($result3)){
				$s .= "<row id='". $row3['assignment_id']."'>";            
				$s .= "<cell>". $row3['topic_name']."</cell>";
				$s .= "<cell>". $row3['due_date']."</cell>";
				$s .= "<cell>". $row3['permission_date']."</cell>";
				$s .= "<cell>". $acyear."</cell>";
				$s .= "<cell>". $session."</cell>";
				$s .= "<cell>". $row3['filename']."</cell>";
				$s .= "</row>";
			}
			$s .= "</rows>"; 
			 
			echo $s;
     
   ?> 