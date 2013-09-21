<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Assignment</title>

		<link rel="stylesheet" type="text/css" media="screen" href="../../allList/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../../allList/css/ui.jqgrid.css" />

		<style type="text/css">
			html, body { margin: 0;padding: 0;} .ui-widget{font-size: 75%;}
		</style>

		<script src="../../allList/js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(function () {
				var course_id="<?php echo $_GET['course_id']; ?>";
				var instructor_id="<?php echo $_GET['instructor_id']; ?>";
				var URL = "";
				if (course_id!='' && instructor_id!='')  URL="student_list_POST.php?table=assignment&course_id="+course_id+"&instructor_id="+instructor_id;
			    $("#list").jqGrid({
			        url: URL,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["ID","Topic", "Due Date", "AcademicYear","Session","Assignment"],
			        colModel: [
			        	{ name: "id", index:"id", width: 90, search:true, align: "center", hidden:true },
			            { name: "topic", index:"topic", width: 90, search:true, align: "center" },
			            { name: "due_date", index:"due_date", search:true, width: 80, align: "center" },
			            { name: "academic_year", index:"academic_year", search:true, width: 80, align: "center" },
			            { name: "session",index:"session",align:"center"},
			            { name: "filename",index:"filename", width: 90,align:"center",
						   formatter:function(cellvalue, options, rowObject){
			            		return "<mm style='color:green;'><a href='../"+cellvalue+"' target='_blank' >View Assignment</a>";
			            	}
					    }
			        ],
			        pager: "#pager",
			        sortname: "id",
			        sortorder: "asc",
			        loadonce:false,
			        rowTotal: 2000,
			        pgbuttons: true,
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        height: 300,
			        cellEdit: true,
					rownumbers:true,
			        caption: "Assignment List"
			    });
				jQuery("#list").jqGrid(
		            'navGrid',
		            '#pager',
		            {del:false,add:false,edit:true, search: true, refresh: true },
		            {},                        // default settings for edit
		            {},                        // default settings for add
		            {},                        // 
		            {closeAfterSearch:true},   // search options
		            {}                         // view parameters
		        );
				jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title: "Upload New Assignment",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){ 
					    	window.parent.$("#course_of_a_instructor_frame").attr({
				    									"scrolling": "no", 
				    									"src":"assignment/upload.php?id="+id,
				    									"width":"400",
				    									"height":"250"
				    								});
					    	window.parent.$("#course_of_a_instructor_div").dialog({title:"Upload New Assignment"});
				             window.parent.$("#course_of_a_instructor_div").dialog("open");
					    }, 
					    position:"first",
					}
			  	);
			});

		</script>
</head>
<body>
    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
</body>
</html>