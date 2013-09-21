<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");
    
    $institute_id=$_SESSION["institute_id"];
    $table = $_GET["table"];
	if(isset($_GET['myid'])){
    $no = $_GET["myid"];
	$no=get_column_from_table("course_id","course_m_details","course_code='$no' AND institute_id='$institute_id'");
	}else{
	$no=$_GET['ID'];
	}
    //include the information needed for the connection to MySQL data base server. 
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
        $where = "1";
    } else {

        $value = mysql_real_escape_string($_REQUEST["searchString"]);
        $searchOper = mysql_real_escape_string($_REQUEST["searchOper"]);
        $searchField = mysql_real_escape_string($_REQUEST["searchField"]);
        $where = sprintf("%s='%s'", $searchField, $value);
    }
      
    // calculate the number of rows for the query. We need this for paging the result 
    $my_sql = "";
    $instructor_id = "";
    if ($table=="course") {
        $instructor_id = get_column_from_table("instructor_id","course_instructor","no='$no'");
        $my_sql = "SELECT COUNT(*) AS count
                    FROM course_m_details t1 INNER JOIN course_instructor t2
                    ON (t1.course_id=t2.course_id AND t2.instructor_id='$instructor_id')";
    }elseif ($table=="student") {
        $my_sql = "SELECT COUNT(*) AS count
                    FROM student_m_details t1 INNER JOIN student_course t2
                    ON (t1.student_id=t2.student_id AND t2.course_id='$no')";
    }
    $result = mysql_query($my_sql); 
    $row = mysql_fetch_array($result,MYSQL_ASSOC); 
    $count = $row['count']; 
     
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
 
    // the actual query for the grid data 
    $result = get_row_from_table($table,"institute_id='$institute_id' AND ".$where." ORDER BY $sidx $sord LIMIT $start , $limit"); 
     
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");
     
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .=  "<rows>";
    $s .= "<page>".$page."</page>";
    $s .= "<total>".$total_pages."</total>";
    $s .= "<records>".$count."</records>";
     
 if($table=="student" && isset($_GET['q'])){ //Students
	 $SQL = "SELECT * FROM student_m_details INNER JOIN student_course ON student_m_details.institute_id=".$institute_id." WHERE student_course.institute_id=".$institute_id." AND student_course.course_id=".$no." AND student_m_details.institute_id=".$institute_id." AND ".$where." AND student_m_details.student_id=student_course.student_id ORDER BY student_m_details.roll_no LIMIT $start , $limit";
    $result = mysql_query( $SQL ) or die("Couldnt execute query.".mysql_error());
	
		while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
			$s .= "<row id='". $row['student_id']."'>";
			$s .= "<cell>". $row['student_id']."</cell>";            
			$s .= "<cell>". $row['student_name']."</cell>";
			$s .= "<cell>". $row['roll_no']."</cell>";
			$s .= "<cell>". $row['email_id']."</cell>";

			$s .= "<cell>". $row['status']."</cell>";
			$s .= "</row>";
		}
	}
    $s .= "</rows>"; 
     
    echo $s;
?>