<!DOCTYPE html PUBLIC "-//W3C//DTD//XHTML 1.0
Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml"
xml : lang="en" lang="en">
<head>
 <?php
 include(dirname(dirname(__FILE__))."./../user_session.php");
	include(dirname(dirname(__FILE__))."./../db_config.php");

    $institute_No=$_SESSION['institute_id'];
	$instructor_id=$_SESSION['instructor_id'];
 $id=$_GET['id'];
 
 ?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 
<title>radioButtons</title>
 
<script type="text/javascript">
/* <![CDATA[ */
function sub1() {
                    var row_id=<?php echo $id; ?>;
					window.parent.$("#my_modal_without_header").modal("hide");
					window.parent.$("h4").html('Auto Grouping');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/group/grouping.php?group=1&id="+row_id,
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
}  
function sub2() {
                    var row_id=<?php echo $id; ?>;
					window.parent.$("#my_modal_without_header").modal("hide");
					window.parent.$("h4").html('Auto Grouping');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/group/grouping.php?group=1&empty=1&id="+row_id,
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
}
function sub3() {
         var id="<?php echo $id; ?>";
		 window.parent.$("#my_modal_without_header").modal("hide");
					window.parent.$("h4").html('Grouping');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/manage_groups_add.php?id="+id,
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
}
/* ]]> */
</script>
 
</head>
 
<body>
    <form  name="frmSite">
        <input type="radio" name="site" onchange="if(this.checked){sub1()}"/>Auto Generate Groups<br/>
        <input type="radio" name="site" onchange="if(this.checked){sub2()}"/>Create Empty Groups<br/>
        <input type="radio" name="site" onchange="if(this.checked){sub3()}"/>Add Students To Groups<br/>
    </form>
</body>
 
</html>