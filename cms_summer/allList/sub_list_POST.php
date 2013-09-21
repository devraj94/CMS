<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");
    
    $institute_id=$_SESSION["institute_id"];
    $table = $_GET["table"];

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
        $where = " 1";
    } else {

        $operations = array(
            'eq' => "= '%s'",            // Equal
            'ne' => "<> '%s'",           // Not equal
            'lt' => "< '%s'",            // Less than
            'le' => "<= '%s'",           // Less than or equal
            'gt' => "> '%s'",            // Greater than
            'ge' => ">= '%s'",           // Greater or equal
            'bw' => "like '%s%%'",       // Begins With
            'bn' => "not like '%s%%'",   // Does not begin with
            'in' => "in ('%s')",         // In
            'ni' => "not in ('%s')",     // Not in
            'ew' => "like '%%%s'",       // Ends with
            'en' => "not like '%%%s'",   // Does not end with
            'cn' => "like '%%%s%%'",     // Contains
            'nc' => "not like '%%%s%%'", // Does not contain
            'nu' => "is null",           // Is null
            'nn' => "is not null"        // Is not null
        ); 
        $value = mysql_real_escape_string($_REQUEST["searchString"]);
        $searchOper = mysql_real_escape_string($_REQUEST["searchOper"]);
        $searchField = mysql_real_escape_string($_REQUEST["searchField"]);
        $where = sprintf(" %s ".$operations[$searchOper], $searchField, $value);
    }
      
    // calculate the number of rows for the query. We need this for paging the result 
    $my_sql = "";
    
    if ($table=="course_m_details") {
        if (isset($_GET["student_id"])) {
            $where.=" AND t2.student_id='".mysql_real_escape_string($_GET["student_id"])."'";
            $my_sql = "SELECT COUNT(DISTINCT t1.course_id) AS count FROM course_m_details t1 
                INNER JOIN student_course t2 ON (t1.institute_id='$institute_id' AND t1.course_id=t2.course_id AND ".$where.")";
        }else{
            $instructor_id = "";
            if (isset($_GET["instructor_id"])) {
                $instructor_id = mysql_real_escape_string($_GET["instructor_id"]);
            }elseif (isset($_GET["mix_id"])) {
                $instructor_id = get_column_from_table("instructor_id","course_instructor","tblid='".$_GET["mix_id"]."'");
            }
            $where.=" AND t2.instructor_id='$instructor_id'";
            $my_sql = "SELECT COUNT(DISTINCT t1.course_id) AS count FROM course_m_details t1 
            INNER JOIN course_instructor t2 ON (t1.institute_id='$institute_id' AND t1.course_id=t2.course_id AND ".$where.")";
        }
    }elseif ($table=="student_m_details") {
        $where.=" AND t2.course_id='".mysql_real_escape_string($_GET["course_id"])."'";
        $my_sql = "SELECT COUNT(DISTINCT t1.student_id) AS count FROM student_m_details t1 
                INNER JOIN student_course t2 ON (t2.institute_id='$institute_id' AND t1.student_id=t2.student_id)
                INNER JOIN student_t_details t3 ON ( t1.student_id=t3.student_id AND ".$where.")";
        //echo $my_sql;
    }elseif ($table=="instructor_m_details") {
        $course_id = "";
        if (isset($_GET["course_id"])) {
            $course_id = mysql_real_escape_string($_GET["course_id"]);
        }elseif (isset($_GET["mix_id"])) {
            $course_id = get_column_from_table("course_id","course_instructor","tblid='".$_GET["mix_id"]."'");
        }
        $where.=" AND t2.course_id='$course_id'";
        $my_sql = "SELECT COUNT(DISTINCT t1.instructor_id) AS count FROM instructor_m_details t1 
                INNER JOIN course_instructor t2 ON (t1.institute_id='$institute_id' AND t1.instructor_id=t2.instructor_id AND ".$where.")";
        //echo $my_sql;
    }

    $result = mysql_query($my_sql) or die(mysql_error()."<br><br>".$my_sql); 
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
    $SQL = "SELECT * FROM $table WHERE institute_id='$institute_id' AND ".$where." ORDER BY $sidx $sord LIMIT $start , $limit"; 
    if ($table=="student_m_details") {
         $SQL = "SELECT t1.student_id, t1.roll_no, t1.student_name, t1.email_id,t3.program_id,t3.department_id,t1.status 
                FROM student_m_details t1 INNER JOIN student_course t2 
                ON (t2.institute_id='$institute_id' AND t1.student_id=t2.student_id)
                INNER JOIN student_t_details t3 ON ( t1.student_id=t3.student_id AND ".$where.") GROUP BY $sidx ORDER BY $sidx $sord LIMIT $start , $limit";
    }elseif ($table=="instructor_m_details") {
        $SQL = "SELECT t1.instructor_id,t1.instructor_name,t1.address,t1.email_id,t1.contactNo FROM instructor_m_details t1 
                INNER JOIN course_instructor t2 ON (t1.institute_id='$institute_id' AND t1.instructor_id=t2.instructor_id AND ".$where.")";
    }elseif ($table=="course_m_details") {
        if (isset($_GET["student_id"])) {
            $SQL = "SELECT t1.course_id,t1.course_code,t1.course_title,t1.description,t1.description_file_path 
                    FROM course_m_details t1 INNER JOIN student_course t2 
                    ON (t1.institute_id='$institute_id' AND t1.course_id=t2.course_id AND ".$where.")";
        }else{
            $SQL = "SELECT t1.course_id,t1.course_code,t1.course_title,t1.description,t1.description_file_path 
                    FROM course_m_details t1 INNER JOIN course_instructor t2 
                    ON (t1.institute_id='$institute_id' AND t1.course_id=t2.course_id AND ".$where.")";
        }
    }
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
     
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");
     
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .=  "<rows>";
    $s .= "<page>".$page."</page>";
    $s .= "<total>".$total_pages."</total>";
    $s .= "<records>".$count."</records>";
     
    // be sure to put text data in CDATA
    if ($table=="instructor_m_details") {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['instructor_id']."'>";            
            $s .= "<cell>". $row['instructor_id']."</cell>";
            $s .= "<cell>". $row['instructor_name']."</cell>";
            $s .= "<cell>". $row['email_id']."</cell>";
            $s .= "<cell>". $row['address']."</cell>";
            $s .= "<cell>". $row['contactNo']."</cell>";
            $s .= "</row>";
        }
    }elseif ($table=="student_m_details") {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['student_id']."'>";            
            $s .= "<cell>". $row['student_id']."</cell>";
            $s .= "<cell>". $row['student_name']."</cell>";
            $s .= "<cell>". $row['roll_no']."</cell>";
            $s .= "<cell>". $row['email_id']."</cell>";

            $s .= "<cell>".get_column_from_table("program_name","program_m_details","program_id='".$row["program_id"]."'")."</cell>";
            $s .= "<cell>".get_column_from_table("department_code","department_m_details","department_id='".$row["department_id"]."'")."</cell>";

            $s .= "<cell>". $row['status']."</cell>";
            $s .= "</row>";
        }
    }elseif ($table=="course_m_details") {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['course_id']."'>";            
            $s .= "<cell>". $row['course_id']."</cell>";
            $s .= "<cell>". $row['course_code']."</cell>";
            $s .= "<cell>". $row['course_title']."</cell>";
            $s .= "<cell>1</cell>";
            $s .= "<cell>". $row['description']."</cell>";
            $s .= "<cell>". $row['description_file_path']."</cell>";
            $s .= "</row>";
        }
    }
    $s .= "</rows>"; 
     
    echo $s;
?>