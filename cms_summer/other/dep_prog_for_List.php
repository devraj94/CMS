<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");

    $institute_No=$_SESSION["institute_id"];
    if (isset($_POST["get_all_data"])) {
    	$response = "";
    	$result = get_row_from_table("program","institute_No='$institute_No'");
    	if (mysql_num_rows($result) > 0) {
    		$i=0;
    		while ($array = mysql_fetch_array($result)) {
    			$i++;
    			if ($i==mysql_num_rows($result)) {
    				$response.=$array["program_id"].":".$array["program_name"];
    			}else{
    				$response.=$array["program_id"].":".$array["program_name"].";";
    			}
    		}

            # To get all department
            $dep_result = get_row_from_table("department","institute_No='$institute_No'");
            $departments = "";
            if (mysql_num_rows($dep_result) > 0) {
                $i=0;
                while ($array = mysql_fetch_array($dep_result)) {
                    $i++;
                    if ($i==mysql_num_rows($dep_result)) {
                        $departments.=$array["department_id"].":".$array["department_code"];
                    }else{
                        $departments.=$array["department_id"].":".$array["department_code"].";";
                    }
                }
                echo $response."**".$departments;
            }
    		
    	}
    }elseif (isset($_POST["get_department"])) {
    	$program_id = mysql_real_escape_string($_POST["program_id"]);
    	$result = get_row_from_table("department","institute_No='$institute_No' AND program_id='$program_id' AND status='1'");
    	if (mysql_num_rows($result) > 0) {
    		$str ="";
    		while ($array = mysql_fetch_array($result)) {
    			$str.="<option role='option' value='".$array["department_id"]."'>".$array["department_code"]."</option>";
    		}
    		echo $str;
    	}
    }
?>