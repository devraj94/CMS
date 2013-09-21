<?php 
    include(dirname(dirname(dirname(__FILE__)))."./user_session.php");
    include(dirname(dirname(dirname(__FILE__)))."./function.php");
    
    $institute_No=$_SESSION["institute_id"];
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
        $value = mysql_real_escape_string($_REQUEST["searchString"]);
        $searchOper = mysql_real_escape_string($_REQUEST["searchOper"]);
        $searchField = mysql_real_escape_string($_REQUEST["searchField"]);
        $where = sprintf(" %s = '%s'", $searchField, $value);
    }
    
    $my_sql = "";

    if ($table=="course") {
        $student_id = mysql_real_escape_string($_GET["student_id"]);
        // Query to count total no. of row
        $my_sql = "SELECT COUNT(*) AS count FROM course t1 INNER JOIN student_reg t2 
                ON (t1.course_No=t2.course_id AND t2.student_id='$student_id')";
    }elseif ($table=="assignment") {
        $student_id = get_column_from_table("std_id","student","user_id='".$_SESSION["user_id"]."'");
        $course_No = mysql_real_escape_string($_GET["course_id"]);
        $instructor_id = mysql_real_escape_string($_GET["instructor_id"]);
        $session = get_session();
        $academic_year = get_academic_year();
        //echo $academic_year;
        $semester = get_column_from_table("semester","student_reg","student_id='$student_id' AND course_id='$course_No' AND institute_No='$institute_No' AND academic_year='$academic_year' AND session='$session'");
        $my_sql = "SELECT COUNT(*) AS count FROM assignment 
                WHERE (course_id='$course_No' AND institute_No='$institute_No' AND academic_year='$academic_year' AND 
                        session='$session' AND semester='$semester' AND instructor_id='$instructor_id'
                    )";
    }
    //echo $my_sql;
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
    if ($table=="course") {
        $SQL = "SELECT t1.course_No,t1.course_id,t1.name,t1.description,t2.academic_year,t2.session,t2.semester
            FROM course t1 INNER JOIN student_reg t2
            ON (t1.course_No=t2.course_id AND t2.student_id='$student_id') ORDER BY $sidx $sord LIMIT $start , $limit";
    }elseif ($table=="assignment") {
        $SQL = "SELECT * FROM assignment 
                WHERE (course_id='$course_No' AND institute_No='$institute_No' AND academic_year='$academic_year' AND 
                        session='$session' AND semester='$semester' AND instructor_id='$instructor_id'
                    ) ORDER BY $sidx $sord LIMIT $start , $limit";
    }
    //echo $SQL;
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
     
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");
     
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .=  "<rows>";
    $s .= "<page>".$page."</page>";
    $s .= "<total>".$total_pages."</total>";
    $s .= "<records>".$count."</records>";
     
    // be sure to put text data in CDATA
    if ($table=="course") {
       while($row = mysql_fetch_array($result)) {
            $s .= "<row id='". $row['course_No']."'>";
            $s .= "<cell>". $row['course_No']."</cell>";
            $s .= "<cell>". $row['course_id']."</cell>";
            $s .= "<cell>". $row['name']."</cell>";
            
            # Sql to get details of the instructor who is teaching the course to the student in current sesssion and current academic year
            $ins_sql = "SELECT t1.instructor_id,t1.name
                        FROM instructor t1 INNER JOIN course_instructor t2 
                        ON (t1.instructor_id=t2.instructor_id AND t2.academic_year='".$row["academic_year"]."' AND 
                            t2.course_id='".$row["course_No"]."' AND t2.session='".$row["session"]."' AND 
                            t2.semester='".$row["semester"]."'
                            )
                        ";
            $ins_result = mysql_query($ins_sql) or die("Couldn't execute query.".mysql_error());

            $str = "";
            while ($data = mysql_fetch_array($ins_result)) {
                $str.=$data["instructor_id"]."*".$data["name"]."**";
            }
            
            $s .= "<cell>". $str."</cell>";
            $s .= "<cell>". $row['description']."</cell>";
            $s .= "</row>";
        }
    }elseif ($table=="assignment") {
        while ($row = mysql_fetch_array($result)) {
            $s .= "<row id='". $row['id']."'>";
            $s .= "<cell>". $row['id']."</cell>";
            $s .= "<cell>". $row['course_id']."</cell>";
            $s .= "<cell>". $row['name']."</cell>";
            $s .= "</row>";
        }
    }
    $s .= "</rows>"; 
     
    echo $s;
?>