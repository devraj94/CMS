<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Course List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="../../allList/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../../allList/css/ui.jqgrid.css" />

		<style type="text/css">
			html, body { margin: 0;padding: 0;} .ui-widget{font-size: 75%;}
		</style>

		<script src="../../allList/js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(function () {
				var student_id = "<?php echo $_GET['std_id']; ?>"; // student_id from student table
				$("#list").jqGrid({
			        url: "student_list_POST.php?table=course&student_id="+student_id,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No","Course ID", "Course Name", "Instructor Name(s)", "Description"],
			        colModel: [
			            { name: "course_No", index:"course_No",hidden:true, width: 20, search:true, align: "center", editable:false},
			            { name: "course_id", index:"course_id", width: 50, search:true, align: "center", editable:false},
			            { name: "name", index:"name", width: 90, search:true, align: "center", editable:false},
			            { name: "instructor_Name", index: "instructor_Name", search:true, width: 50, align: "center",editable:false,
			            	formatter:function(cellvalue, options, rowObject){
			            		var str = "";
			            		var data = cellvalue.split("**");
			            		for (var i = 0; i < data.length; i++) {
			            			if (data[i]!="") {
			            				var array = data[i].split("*");
			            				str+="<a href='#' class='ins_link' data='"+array[0]+"*"+array[1]+"*"+options["rowId"]+"'>"+array[1]+"</a>";
			            			};
			            		};
			            		return str;
			            	}
			        	},
			            { name: "description", index:"description", search:true, width: 100, align: "center",editable:false}
			        ],
			        pager: "#pager",
			        loadonce:false,
			        pgbuttons: true,
			        rowNum:10,
				   	rowList: [10, 20, 30, 50],
			        sortname: "course_No",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        height: 295,
			        multiselect: true,
			        caption: "Course List",
			        toppagger:true,
			        rownumbers: true
			    });
				
				// Option & Property for 'Navigation Bar' in JQGrid
				jQuery("#list").jqGrid(
			        'navGrid',
		            '#pager',
		            {del:false, add:false, edit:false, search:false, refresh:true,view:true},
		            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
		            {},{},{},{} 
			    );

			    // When clicked on any course, this function will be called
				$('.ins_link').live('click',function() { 
					var data = $(this).attr('data');
				    var array = data.split("*");
				    window.parent.$("#course_of_a_instructor_frame").attr({
						"scrolling": "no", 
						"src":"student/list/view_assignment_List.php?instructor_id="+array[0]+"&course_id="+array[2],
						"width":"760",
						"height":"400"
					});
				    window.parent.$("#course_of_a_instructor_div").dialog({title:"ASSIGNMENTS By "+array[1]});
				    window.parent.$("#course_of_a_instructor_div").dialog("open"); 
				});
			}); 
		</script>
	</head>
<body>
	<table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
</body>
</html>