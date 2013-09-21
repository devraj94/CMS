<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Course Instructor List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/ui.jqgrid.css" />

		<style type="text/css">
		html, body {
		    margin: 100;
		    padding: 100;
		    font-size: 75%;
		}
		</style>

		<script src="../allList/js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(function () {
			var con="<?php echo isset($_GET['q'])? $_GET['q']:''; ?>";
			var group="<?php echo isset($_GET['group'])? $_GET['group']:''; ?>";
			var myurl='';
			var title1='';
			if(group!='' && con==''){
			        $("#list").jqGrid({
			        url: "list_POST.php?con=1",
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["Course ID","Course Code","Course", "No Of Groups","Manage Groups","Description"],
			        colModel: [
			            { name: "course_id", index:"course_id", width: 12, search:true, align: "center",editable:true },
						{ name: "course_code", index:"course_code", width: 12, search:true, align: "center",editable:true },
			            { name: "name", index:"name", width: 90, search:true, align: "center",editable:true,
			            	formatter:function(cellvalue, options, rowObject){
			            		return "<a href='#' class='myLink' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            	},
			            	unformat:function(cellvalue, options, rowObject){
			            		return cellvalue;
			            	}
			            },
						{ name: "no_of_groups", index:"no_of_groups", search:true, width: 30, align: "center" ,editable:false},
						{ name: "manage", index:"manage", search:true, width: 30, align: "center" ,editable:false,
						    formatter:function(cellvalue, options, rowObject){
			            		return "<a href='#' class='myLinkgroups' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            	},
			            	unformat:function(cellvalue, options, rowObject){
			            		return cellvalue;
			            	}
						},
			            { name: "description", index:"description", width: 17, align:"center",editable:true}
                               ],
			       pager: '#pager',
				loadonce: false,
				rowNum:13,
				rowList:[10,20,30],
				sortname: 'course_id',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: true,
				height: 300,
				multiselect: true,
				gridview: true,
				rownumbers: true,
			        caption: "Course Instructor List"
			    });
			}else{
			    $("#list").jqGrid({
			        url: "list_POST.php",
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["Course ID","Course", "Course Code", "Description"],
			        colModel: [
			            { name: "course_id", index:"course_id", width: 12, search:true, align: "center",editable:true },
			            { name: "name", index:"name", width: 90, search:true, align: "center",editable:true,
			            	formatter:function(cellvalue, options, rowObject){
			            		return "<a href='#' class='myLink' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            	},
			            	unformat:function(cellvalue, options, rowObject){
			            		return cellvalue;
			            	}
			            },
			            { name: "course_code", index:"course_code", width: 12, search:true, align: "center",editable:true },
			            { name: "description", index:"description", width: 17, align:"center",editable:true}
                               ],
			        pager: '#pager',
				loadonce: false,
				rowNum:13,
				rowList:[10,20,30],
				sortname: 'course_id',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: true,
				height: 300,
				multiselect: true,
				gridview: true,
				rownumbers: true,
			        caption: "Course Instructor List"
			    });
				
			}
				 $('.myLink').live('click', function() { 
				 if(con=='' && group==''){
				  myurl="instructortotal/studentList.php?q=1&id=";
				  title1="STUDENTS";
				  var row_i = $(this).attr('data');
					 var rowd="";
					  rowd=row_i.split(",");
					  var row_id=rowd[0];
				  }else if(con!='' && group==''){
				  var row_i = $(this).attr('data');
				  var rowd="";
				  rowd=row_i.split(",");
				  var row_id=rowd[0];
				  var sem = rowd[1];
				  myurl="instructortotal/assignmentlist.php?sem="+sem+"&id=";
				  title1="ASSIGNMENTS";
				  
				  }else if(group!='' && con==''){
				  myurl="instructortotal/groups_list.php?id=";
				  title1="GROUPS";
				   var row_i = $(this).attr('data');
					 var rowd="";
					  rowd=row_i.split(",");
					  var row_id=rowd[0];
				  };
				    window.parent.$("#subList_iframe").attr({
					    				"src":myurl+row_id,
					    				"height":"430"
					});
					window.parent.$("#my_modal_without_header").css('width', '705px');
					window.parent.$("#my_modal_without_header").modal("show");
				});
				if(group!='' && con==''){
				$('.myLinkgroups').live('click', function() { 
				    var row_i = $(this).attr('data');
					 var rowd="";
					  rowd=row_i.split(",");
					  var row_id=rowd[0];
					   window.parent.$("#subList_iframe").attr({
					    				"src":"instructortotal/group/manage_groups_main.php?id="+row_id,
					    				"height":"430"
					});
					window.parent.$("#my_modal_without_header").css('width', '705px');
					window.parent.$("#my_modal_without_header").modal("show");
				});
				
				}
				
           
		}); 
			

		</script>
</head>
<body>
    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
</body>
</html>