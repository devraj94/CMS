<?php
	include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./function.php");
    
    $institute_id=$_SESSION["institute_id"];

    if (isset($_POST["get_dep"])) {
    	$program_id = mysql_real_escape_string($_POST["program_id"]);
    	$sql = "SELECT t1.department_id,t1.department_code,t1.department_name FROM department_m_details t1 INNER JOIN program_department t2
    			ON (t2.institute_id='$institute_id' AND t1.department_id=t2.department_id AND t2.program_id='$program_id')";
    	$result = mysql_query($sql) or die(mysql_error()."<br><br>".$sql);

    	if ($result) {
    		$str = "choose*Choose department**";
    		while ($row=mysql_fetch_array($result)) {
    			//$str.="<option value='".$row["department_id"]."'>".$row["department_name"]." (".$row["department_code"].")</option>";
                $str.=$row["department_id"]."*".$row["department_name"]." (".$row["department_code"].")**";
    		}
    		echo "1***".$str;
    	}else{
    		echo "0***";
    	}
    }
?>