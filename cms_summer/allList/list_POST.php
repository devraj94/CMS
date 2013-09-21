<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");
    
    $institute_id=$_SESSION["institute_id"];
    $table = $_GET["table"];
    //include the information needed for the connection to MySQL data base server. 
    // we store here username, database and password 
    ######include("dbconfig.php");
    if($table=='studentgroups'){
        $id=$_GET['id'];
        $username=$_SESSION['username'];
        $userid=get_column_from_table("user_id","users","username='$username'");
        $instructorid=get_column_from_table("instructor_id","instructor","user_id=".$userid."");
        $_SESSION['instructor_id']=$instructorid;
    }
    
    // Get the requested page. By default grid sets this to 1. 
    $page = $_GET['page']; 
    // get how many rows we want to have into the grid - rowNum parameter in the grid 
    $limit = $_GET['rows']; 
    $sidx = $_GET['sidx']; 
    // sorting order - at first time sortorder 
    $sord = $_GET['sord']; 
    // if we not pass at first time index use the first column for the index or what you want
    if(!$sidx) $sidx =1; 

    $value = "";
    $searchOper = "";
    $searchField = "";
    $where = "";

    //if search enable
    if ($_REQUEST["_search"] == "false") {
        $where = "1";
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
        if ($table=="student_m_details") {
            $where = sprintf(" t1."."%s ".$operations[$searchOper], $searchField, $value);
        }elseif ($table=="course_m_details") {
            $where = sprintf(" %s ".$operations[$searchOper], $searchField, $value);
        }elseif ($table=="course_instructor") {
            # if we are searching in 'course_instructor' table
            if ($searchField=="course_title") {
                $where = sprintf(" t1.course_title ".$operations[$searchOper], $value);
            }elseif ($searchField=="instructor_name") {
                $where = sprintf(" t3.instructor_name ".$operations[$searchOper], $value);
            }elseif ($searchField=="semester") {
                $where = sprintf(" t2.semester ".$operations[$searchOper], $value);
            }
        }
    }
    
    // Default Query 
    $my_sql = "SELECT COUNT(*) AS count FROM $table WHERE institute_id='$institute_id' AND ".$where; 
    
    if ($table=="student_m_details") {
        $academic_year = mysql_real_escape_string($_REQUEST["academic_year"]);
        $program_id = mysql_real_escape_string($_REQUEST["program_id"]);
        $department_id = mysql_real_escape_string($_REQUEST["department_id"]);

        if ($academic_year!="all") $where.=" AND t2.academic_year='".$academic_year."'";
        if ($program_id!="all") $where.=" AND t3.program_id='".$program_id."'";
        if ($department_id!="all") $where.=" AND t3.department_id='".$department_id."'";

        $my_sql = "SELECT COUNT(DISTINCT t1.student_id) AS count FROM student_m_details t1 
                INNER JOIN student_course t2 ON (t2.institute_id='$institute_id' AND t1.student_id=t2.student_id)
                INNER JOIN student_t_details t3 ON ( t1.student_id=t3.student_id AND ".$where.")";
    }elseif ($table=="course_instructor") {
        $academic_year = mysql_real_escape_string($_REQUEST["academic_year"]);
        $program_id = mysql_real_escape_string($_REQUEST["program_id"]);
        $department_id = mysql_real_escape_string($_REQUEST["department_id"]);

        if ($academic_year!="all") $where.=" AND t2.academic_year='".$academic_year."'";
        if ($program_id!="all") $where.=" AND t2.program_id='".$program_id."'";
        if ($department_id!="all") $where.=" AND t2.department_id='".$department_id."'";

        $my_sql = "SELECT COUNT(DISTINCT t1.course_id) AS count FROM course_m_details t1 
                INNER JOIN course_instructor t2 ON (t1.course_id=t2.course_id AND t1.institute_id='$institute_id')
                INNER JOIN instructor_m_details t3 ON (t2.instructor_id=t3.instructor_id AND ".$where.")";
    }
     
    $result = mysql_query($my_sql) or die("<br><br>".$my_sql); 
    $row = mysql_fetch_array($result,MYSQL_ASSOC);
    $count = $row["count"]; // count total numbers of rows in result

    //echo $count;
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
    if($table=="studentgroups"){
        $result = get_row_from_table($table,"institute_id='$institute_id' AND ".$where." ORDER BY $sidx $sord LIMIT $start , $limit");
    }else{
        $SQL = "SELECT * FROM $table WHERE institute_id='$institute_id' AND ".$where." ORDER BY $sidx $sord LIMIT $start , $limit"; 
        if ($table=="student_m_details") {
            $SQL = "SELECT t1.student_id, t1.roll_no, t1.student_name, t1.email_id,t3.program_id,t3.department_id,t1.status 
                FROM student_m_details t1 INNER JOIN student_course t2 
                ON (t2.institute_id='$institute_id' AND t1.student_id=t2.student_id)
                INNER JOIN student_t_details t3 ON ( t1.student_id=t3.student_id AND ".$where.") GROUP BY $sidx ORDER BY $sidx $sord LIMIT $start , $limit";
            //echo "<br><br>".$SQL."<br><br>";    
        }elseif ($table=="course_m_details") {
            $SQL = "SELECT * FROM course_m_details WHERE institute_id='$institute_id' AND ".$where." GROUP BY $sidx ORDER BY $sidx $sord LIMIT $start , $limit";
        }elseif ($table=="course_instructor") {
            $SQL = "SELECT t2.tblid,t1.course_title,t2.program_id,t2.department_id,t3.instructor_name,t2.academic_year,t2.session,
                            t2.feedback_status,t2.semester FROM course_m_details t1 INNER JOIN course_instructor t2 
                    ON (t1.course_id=t2.course_id AND t1.institute_id='$institute_id') INNER JOIN instructor_m_details t3
                    ON (t2.instructor_id=t3.instructor_id AND ".$where.")";
        }
        //echo $SQL;
        $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()."<br><br>".$SQL); 
    }
    
     
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");
     
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .=  "<rows>";
    $s .= "<page>".$page."</page>";
    $s .= "<total>".$total_pages."</total>";
    $s .= "<records>".$count."</records>";
     
    // be sure to put text data in CDATA
    if ($table=="course_m_details") { // if we are using table 'course'
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['course_id']."'>";            
            $s .= "<cell>". $row['course_id']."</cell>";
            $s .= "<cell>". $row['course_code']."</cell>";
            $s .= "<cell>". $row['course_title']."</cell>";
            $s .= "<cell>1</cell>";
            $s .= "<cell>". $row['description']."</cell>";

            if (is_null($row["description_file_path"]) || $row["description_file_path"]=="") {
                $s .= "<cell>0</cell>";
            }else{
                $s .= "<cell>". $row["description_file_path"]."</cell>";
            }
            
            $s .= "<cell>". $row['status']."</cell>";
            $s .= "</row>";
            
        }
    }elseif ($table=="admin_m_details") { // if we are using table 'admin_m_details'
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $type="Unknown";
            $s .= "<row id='". $row['admin_id']."'>";            
            $s .= "<cell>". $row['admin_id']."</cell>";
            $s .= "<cell>". $row['admin_name']."</cell>";
            $s .= "<cell>". $row['email_id']."</cell>";
            $s .= "<cell>". $row['admin_designation']."</cell>";

            $query = "SELECT t1.role_id FROM users_role t1 INNER JOIN admin_m_details t2 
                    ON (t1.user_id=t2.user_id AND t2.admin_id='".$row["admin_id"]."')";
            $result_admin = mysql_query($query) or die("Couldn't execute query.<br><br>".mysql_error()."<br><br>".$query);
            while ($data=mysql_fetch_array($result_admin)) {
                if ($data["role_id"]=="2") {
                    $type="Primary";
                    break;
                }elseif ($data["role_id"]=="3") {
                    $type="Secondary";
                    break;
                }
            }
            $s .="<cell>".$type."</cell>";
            $s .= "<cell>".$row['status']."</cell>";
            $s .= "</row>";
        }
    }elseif ($table=="instructor_m_details") { // if we are using table 'administrator'
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['instructor_id']."'>";            
            $s .= "<cell>". $row['instructor_id']."</cell>";
            $s .= "<cell>". $row['instructor_name']."</cell>";
            $s .= "<cell>". $row['email_id']."</cell>";
            $s .= "<cell>". $row['address']."</cell>";
            $s .= "<cell>". $row['contactNo']."</cell>";
            $s .= "<cell>". $row['status']."</cell>";
            $s .= "</row>";
        }
    }elseif($table=="ta"){
         while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['ta_id']."'>";            
            $s .= "<cell>". $row['ta_id']."</cell>";
            $s .= "<cell>". $row['ta_name']."</cell>";
            $s .= "<cell>". $row['address']."</cell>";
            $s .= "<cell>". $row['email_id']."</cell>";
            $s .= "<cell>". $row['contactNo']."</cell>";
            $s .= "<cell>". $row['status']."</cell>";
            $s .= "</row>";
        }
    }elseif ($table=="student_m_details") { // if we are using table 'administrator'
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
    }elseif ($table =="course_instructor") {
         while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['tblid']."'>";            
            $s .= "<cell>". $row['tblid']."</cell>";
            $s .= "<cell>". $row['course_title']."</cell>";

            $program = get_column_from_table("program_name","program_m_details","program_id='".$row['program_id']."'");
            $s .= "<cell>". $program."</cell>";

            $dep = get_column_from_table("department_code","department_m_details","department_id='".$row['department_id']."'");
            $s .= "<cell>". $dep."</cell>";

            $s .= "<cell>". $row['instructor_name']."</cell>";
            $s .= "<cell>". $row['academic_year']."</cell>";
            $s .= "<cell>". $row['semester']."</cell>";

            if ($row['feedback_status']=="N") {
                $s .= "<cell>No</cell>";
            }elseif ($row['feedback_status']=="Y") {
                $s .= "<cell>Yes</cell>";
            }
            $s .= "<cell>". $row['session']."</cell>";        
            $s .= "</row>";
        }
    }elseif ($table=="student_reg") {
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
            $s .= "<row id='". $row['no']."'>";            
            $s .= "<cell>". $row['no']."</cell>";
            $s .= "<cell>". $row['roll_No']."</cell>";
            $s .= "<cell>". $row['student_id']."</cell>";
            $s .= "<cell>". $row['course_id']."</cell>";
            $s .= "<cell>". $row['academic_year']."</cell>";
            $s .= "<cell>". $row['session']."</cell>";
            $s .= "<cell>". $row['semester']."</cell>";
            $s .= "</row>";
        }
    }elseif($table=='studentgroups'){
        while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
                $s .= "<row id='". $row['group_No']."'>";            
                $std = get_row_from_table("student","std_id='".$row['student_id']."' AND institute_id='$institute_id'");
                $rowz=mysql_fetch_array($std);
                $s .= "<cell>". $row['group_No']."</cell>";
                $s .= "<cell>". $row['group_name']."</cell>";
                $s .= "<cell>". $rowz['student_name']."</cell>";
                $s .= "<cell>". $rowz['email_id']."</cell>";
                $s .= "<cell>".$rowz['roll_no']."</cell>";
                $s .= "</row>";
                
        }
    }
    
    $s .= "</rows>"; 
     
    echo $s;
?>