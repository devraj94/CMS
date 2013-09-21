<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./db_config.php");
    
    //include the information needed for the connection to MySQL data base server. 
    // we store here username, database and password 
    ######include("dbconfig.php");
     
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
     
    // connect to the MySQL database server 
    $db = mysql_connect($dbhost, $dbuser, $dbpass) or die("Connection Error: " . mysql_error()); 
     
    // select the database 
    mysql_select_db($dbname) or die("Error connecting to db."); 
     
    // calculate the number of rows for the query. We need this for paging the result 
    $result = mysql_query("SELECT COUNT(*) AS count FROM institute_m_details WHERE".$where); 
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
    $SQL = "SELECT * FROM institute_m_details WHERE".$where." ORDER BY $sidx $sord LIMIT $start , $limit"; 
    $result = mysql_query( $SQL ) or die("Couldn't execute query.".mysql_error()); 
     
    // we should set the appropriate header information. Do not forget this.
    header("Content-type: text/xml;charset=utf-8");
     
    $s = "<?xml version='1.0' encoding='utf-8'?>";
    $s .=  "<rows>";
    $s .= "<page>".$page."</page>";
    $s .= "<total>".$total_pages."</total>";
    $s .= "<records>".$count."</records>";
     
    // be sure to put text data in CDATA
    while($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
        $s .= "<row id='". $row['institute_id']."'>";            
        $s .= "<cell>". $row['institute_id']."</cell>";
        $s .= "<cell>". $row['institute_name']."</cell>";
        $s .= "<cell>". $row['email_id']."</cell>";
        $s .= "<cell>". $row['institute_domain']."</cell>";
        $s .= "<cell>". $row['institute_address']."</cell>";
        $s .= "<cell>". $row['city']."</cell>";
        $s .= "<cell>". $row['pin_code']."</cell>";
        $s .= "<cell>". $row['state']."</cell>";
        $s .= "<cell>". $row['landline_no']."</cell>";
        $s .= "<cell>". $row['institute_fax']."</cell>";        
        $s .= "<cell>". $row['status']."</cell>";
        $s .="<cell>".$row['admin_name']."</cell>";
        $s .= "</row>";
        
    }
    $s .= "</rows>"; 
     
    echo $s;
?>