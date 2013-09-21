<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta content="charset=utf-8" />
		<title>Student List</title>
		 
		<link rel="stylesheet" type="text/css" media="screen" href="css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
		

		<style type="text/css">
		html, body {
		    margin: 100;
		    padding: 100;
		    font-size: 75%;
		}
		</style>

		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function(){ 
			// JQGrid Option and method goes here
		  	$("#list").jqGrid({
				url:'list_POST.php?table=student_reg',
				datatype: 'xml',
				mtype: 'GET',
				colNames:['No','Roll No','Student','Course','Academic Year','Session','Semester'],
				colModel :[ 
				  {name:'no', index:'no',width:20, align:'center',editoptions:{readonly:'readonly'}, editable:true}, 
				  {name:'roll_no', index:'roll_no', align:'center',editoptions:{readonly:'readonly'},editable:true},
				  {name:'student_id', index:'student_id', align:'center',editoptions:{readonly:'readonly'},editable:true}, 
				  {name:'course_id', index:'course_id', width:80, align:'center',editoptions:{readonly:'readonly'},editable:true},
				  {name:'academic_year', index:'academic_year', width:100,editoptions:{readonly:'readonly'}, align:'center',editable:true}, 
				  {name:'session', index:'session', width:60, align:'center',editoptions:{readonly:'readonly'},editable:true},
				  {name:'semester', index:'semester', width:60, align:'center',editoptions:{readonly:'readonly'},editable:true}				  
				],
				pager: '#pager',
				loadonce: false,
				rowNum:13,
				rowList:[10,20,30],
				sortname: 'no',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: true,
				height: 300,
				multiselect: true,
				gridview: true,
				caption: 'Student-Course List',
		  	}); 
		  	// Option & Property for 'Navigation Bar' in JQGrid
		  	jQuery("#list").jqGrid(
	            'navGrid',
	            '#pager',
	            {del:false, add:false, edit:true, search:true, refresh:true,view:true},
	            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
	            {/*reloadAfterSubmit:false, closeAfterAdd:true*/}, // default settings for add
	            {},// 
	            {closeAfterSearch:true}, // search options
	            {} // view parameters
	        );
		}); 
		</script>
	</head>
	<body>
		<table id="list"><tr><td/></tr></table> 
		<div id="pager"></div>
	</body>
</html>