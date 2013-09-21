<?php 
    
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");
    include(dirname(dirname(__FILE__))."./db_config.php");
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);
	$result=get_row_from_table("users","username = '$username'");
	$row = mysql_fetch_array($result);
	$user_id=$row["user_id"];
	$result1=get_row_from_table("instructor_m_details","user_id = '$user_id'");
	$row1 = mysql_fetch_array($result1);
	$instructorid = $row1["instructor_id"];
	$_SESSION['instructor_id']=$instructorid;
	$instructorid=$_SESSION['instructor_id'];
	$name=$_SESSION['instName'];
	$sqli="SELECT institute_id FROM institute_m_details WHERE institute_name='$name'";
	$resulti=mysql_query($sqli,$connection);
	$rowi=mysql_fetch_array($resulti);
	$_SESSION['institute_id']=$rowi['institute_id'];
	$institute_id=$_SESSION['institute_id'];
	
	// to the url parameter are added 4 parameters as described in colModel
    // we should get these parameters to construct the needed query
    // Since we specify in the options of the grid that we will use a GET method 
    // we should use the appropriate command to obtain the parameters. 
    // In our case this is $_GET. If we specify that we want to use post 
    // we should use $_POST. Maybe the better way is to use $_REQUEST, which
    // contain both the GET and POST variables. For more information refer to php documentation.
    // Get the requested page. By default grid sets this to 1. 
    $page = $_GET['page']; 
     
    // get how many rows we want to have into the grid - rowNum parameter in the grid 
    $limit = $_GET['rows']; 
     
    // get index row - i.e. user click to sort. At first time sortname parameter -
    // after that the index from colModel 
    $sidx = $_GET['sidx']; 
     
    // sorting order - at first time sortorder 
    $sord = $_GET['sord']; 
     
    // if we not pass at first time index use the first column for the index or what you want
    if(!$sidx) $sidx =1; 

    //if search enable
    if ($_REQUEST["_search"] == "false") {
        $where1 = " 1";
    } else {

        $value = mysql_real_escape_string($_REQUEST["searchString"]);
        $searchOper = mysql_real_escape_string($_REQUEST["searchOper"]);
        $searchField = mysql_real_escape_string($_REQUEST["searchField"]);
        $where1 = sprintf("%s='%s'", $searchField, $value);
    }
	
	if(isset($_GET['ins']) && isset($_GET['table'])){
	        $table=$_GET['table'];
			$SQL = "SELECT * FROM ta_m_details INNER JOIN ta_instructor_course ON ta_m_details.ta_id=ta_instructor_course.ta_id WHERE ta_instructor_course.institute_id='$institute_id' AND ta_m_details.institute_id='$institute_id' AND ".$where1." AND ta_instructor_course.instructor_id='$instructorid'"; 
            $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
			$resultrs=get_count("ta_m_details INNER JOIN ta_instructor_course ON ta_m_details.ta_id=ta_instructor_course.ta_id","ta_instructor_course.institute_id='$institute_id' AND ta_m_details.institute_id='$institute_id' AND ta_instructor_course.instructor_id='$instructorid'");
			$row = mysql_fetch_array($resultrs);
            $count = $row['count'];
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
		 
			// we should set the appropriate header information. Do not forget this.
			header("Content-type: text/xml;charset=utf-8");
			 
			$s = "<?xml version='1.0' encoding='utf-8'?>";
			$s .=  "<rows>";
			$s .= "<page>".$page."</page>";
			$s .= "<total>".$total_pages."</total>";
			$s .= "<records>".$count."</records>";
			while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$s .= "<row id='". $row['ta_id']."*".$row['course_id']."'>";            
				$s .= "<cell>". $row['ta_id']."</cell>";
				$s .= "<cell>". $row['ta_name']."</cell>";
				$s .= "<cell>". $row['email_id']."</cell>";
				$s .= "<cell>". $row['address']."</cell>";
				$s .= "<cell>". $row['contactNo']."</cell>";
				$sqlk="SELECT * FROM course_m_details WHERE institute_id='$institute_id' AND course_code='".$row['course_id']."' LIMIT $start , $limit";
				$resu=mysql_query($sqlk);
				$res=mysql_fetch_array($resu);
				$s .= "<cell>".$res['name']."</cell>";
				
				$s .= "<cell>".$row['status']."</cell>";
				
				
				$s .= "</row>";
			}
			$s .= "</rows>"; 
     
            echo $s;
	}elseif(isset($_GET['table']) && $_GET['table']=="group_t_details"){
	           $table=$_GET['table'];
	       $id=$_GET['id'];
			$username=$_SESSION['username'];
			$userid=get_column_from_table("user_id","users","username='$username'");
			
			$id=get_column_from_table("course_id","course_m_details","institute_id='$institute_id' AND course_code='$id'");
			$instructorid=get_column_from_table("instructor_id","instructor_m_details","user_id=".$userid."");
			$_SESSION['instructor_id']=$instructorid;
			$groupid=get_column_from_table("group_id","group_m_details","institute_id='$institute_id' AND instructor_id='$instructorid' AND course_id='$id'");
			$where="course_code='$id' AND ".$where1." AND instructor_id='$instructorid'";
			$my_sql = "SELECT COUNT(*) AS count
                    FROM $table WHERE group_id='$groupid' AND ".$where1;
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
                           $result = get_row_from_table($table,"institute_id='$institute_id' AND group_id='$groupid' AND ".$where1." ORDER BY student_id $sord LIMIT $start , $limit");
						    header("Content-type: text/xml;charset=utf-8");
     
						$s = "<?xml version='1.0' encoding='utf-8'?>";
						$s .=  "<rows>";
						$s .= "<page>".$page."</page>";
						$s .= "<total>".$total_pages."</total>";
						$s .= "<records>".$count."</records>";
				
					while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
						$s .= "<row id='". $row['group_id']."'>";            
						$std = get_row_from_table("student_m_details","student_id='".$row['student_id']."' AND ".$where1." AND institute_id='$institute_id' LIMIT $start , $limit");
						$rowz=mysql_fetch_array($std);
						$s .= "<cell>". $row['group_name']."</cell>";
						$s .= "<cell>". $rowz['student_name']."</cell>";
						$s .= "<cell>". $rowz['email_id']."</cell>";
						$s .= "<cell>".$rowz['roll_no']."</cell>";
						$s .= "</row>";
		            }
                						
						$s .= "</rows>"; 
     
						echo $s;
						
						
						
	}else{
	 
			
             
			 $resultcount=get_count("course_instructor","instructor_id='$instructorid' AND institute_id='$institute_id'");
			 $row = mysql_fetch_array($resultcount);
            $count = $row['count'];
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
			$sql3="SELECT course_id FROM course_instructor WHERE instructor_id=".$instructorid." AND institute_id=".$institute_id." ORDER BY course_id LIMIT $start , $limit";
			$result3=mysql_query($sql3) or die("Error Connecting to Server3.".mysql_error());	
			
		 // we should set the appropriate header information. Do not forget this.
			header("Content-type: text/xml;charset=utf-8");
			 
			$s = "<?xml version='1.0' encoding='utf-8'?>";
			$s .=  "<rows>";
			$s .= "<page>".$page."</page>";
			$s .= "<total>".$total_pages."</total>";
			$s .= "<records>".$count."</records>";
			while($row3=mysql_fetch_array($result3)){
			   $result4=get_row_from_table("course_m_details","course_id=".$row3['course_id']." AND ".$where1." AND institute_id=".$institute_id." LIMIT $start , $limit");
			   $row4=mysql_fetch_array($result4);
			   $result9=get_row_from_table("course_instructor","course_id=".$row3['course_id']." AND ".$where1." AND institute_id=".$institute_id." AND instructor_id='$instructorid' LIMIT $start , $limit");
			    $row9=mysql_fetch_array($result9);
			   $rod=$row4['course_code'].",".$row9['semester'];
				$s .= "<row id='". $rod."'>";            
				$s .= "<cell>". $row4['course_id']."</cell>";
				$s .= "<cell>". $row4['course_title']."</cell>";
				$s .= "<cell>". $row4['course_code']."</cell>";
				if(isset($_GET['con'])){
				$sql6="SELECT Total_groups FROM group_m_details WHERE instructor_id=".$instructorid." AND ".$where1." AND course_id=".$row4['course_id']." ORDER BY course_id LIMIT $start , $limit";
			    $result6=mysql_query($sql6) or die("Error Connecting to Server3.".mysql_error());
				if($row6=mysql_fetch_array($result6)){
					
				$s .= "<cell>". $row6['Total_groups']."</cell>";
				}else{
				$se=0;
				$s .= "<cell>0</cell>";
				}
			    
				$s .= "<cell>Manage Groups</cell>";
				}
				$s .= "<cell>". $row4['description']."</cell>";
				$s .= "</row>";
			}
			$s .= "</rows>"; 
			 
			echo $s;

        }
  
     
   ?> 