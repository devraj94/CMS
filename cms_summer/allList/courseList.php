<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Course List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="css/dark-hive/jquery-ui.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />

		<style type="text/css">
			html, body { margin: 0;padding: 0;} .ui-widget{font-size: 75%;}
			#std,#ins{padding-top: 2px;padding-bottom: 2px;padding-left: 4px; padding-right: 4px;}
		</style>

		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		
		<script type="text/javascript">
			$(function () {
				var instructor_id = "<?php echo isset($_GET['instructor_id'])? $_GET['instructor_id']:''; ?>"; // instructor_id from instructorList
				var student_id = "<?php echo isset($_GET['student_id'])? $_GET['student_id']:''; ?>"; // student_id from student table
				var mix_id = "<?php echo isset($_GET['mix_id'])? $_GET['mix_id']:''; ?>";
				var condition = true;
				var rev_condition = false;
				width=700;

				if (instructor_id=='' && student_id=='' && mix_id=='') {
					width = 1147;
					condition = false;
					rev_condition = true;
					my_url = 'list_POST.php?table=course_m_details';
				}else if (instructor_id!='') {
					my_url = 'sub_list_POST.php?table=course_m_details&instructor_id='+instructor_id;
				}else if (student_id!="") {
					my_url = 'sub_list_POST.php?table=course_m_details&student_id='+student_id;
				}else if (mix_id!='') {
					my_url = 'sub_list_POST.php?table=course_m_details&mix_id='+mix_id;
				};

				var lastSel = -1;
				var description = "";

			    $("#list").jqGrid({
			        url: my_url,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No","Course-Code", "Course-Title", "View", "Description", "Description-File", "Status"],
			        colModel: [
			            { name: "course_id", index:"course_id",hidden:true, width: 20, search:true, align: "center",editable:false},
			            { name: "course_code", index:"course_code", width: 30, search:true, align: "center",editable:true},
			            { name: "course_title", index:"course_title", width: 90, search:true, align: "center",editable:true},
			            { name: "view", index:"view", width: 90, search:false, align: "center", editable:false, hidden:condition,
			            	formatter:function(cellvalue, options, rowObject){
			            		if (rev_condition) {
			            			return  "<a href='#' class='fm-button ui-state-default ui-corner-all' id='std' data='"+options["rowId"]+"'>Student</a>"+
			            					"&nbsp;"+
			            					"<a href='#' class='fm-button ui-state-default ui-corner-all' id='ins' data='"+options["rowId"]+"'>Instructors</a>";
			            		}else{
			            			return cellvalue;
			            		};
			            	}
			        	},
			            { name: "description", index:"description", search:true, width: 100, align: "center", editable: true},
			        	{ name:"description_file_path", index:"description_file_path", search:false, width:40, align: "center", editable:false,
			        		formatter:function(cellvalue, options, rowObject){
			        			if (cellvalue==0 || cellvalue=="0" || cellvalue=="" || cellvalue==null) {
			        				return "Not Available";
			        			}else{
			        				return '<a href="../'+cellvalue+'" target="_tab"><img src="../img/PDF-icon.png" width="18" height="18"></a>';
			        			};
			        		}
			        	},
			            { name: "status", index:"status", search:true, width: 50, align: "center", editable: false, hidden: condition,
			            	formatter:function(cellvalue, options, rowObject){
			            		if (cellvalue=="1") {
				  					return "<mm style='color:green;'><b>Active</b></mm> &nbsp; <a href='#' class='statusLink' data='"+options["rowId"]+"*0'>Inactive</a>";
					  			}else if(cellvalue=="0"){
					  				return " <a href='#' class='statusLink' data='"+options["rowId"]+"*1'>Active</a> &nbsp; <mm style='color:red;'><b>Inactive</b></mm>";
					  			};
			            	}
			        	}
			        ],
			        onSelectRow: function (id) {
			        	var selRows = $(this).jqGrid('getGridParam','selarrrow');
			        	if (selRows.length===1) {
			        		$("#edit_button").removeClass('ui-state-disabled');
			        	}else{
			        		$("#edit_button").addClass('ui-state-disabled');
			        	};
				    },
				    loadComplete:function(){ $("#edit_button").addClass('ui-state-disabled'); },
				    onSelectAll: function(){ $("#edit_button").addClass('ui-state-disabled'); },
			        pager: "#pager",
			        loadonce:false,
			        pgbuttons: true,
			        rowNum:10,
				   	rowList: [10, 20, 30, 50],
			        sortname: "course_id",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        width: width,
			        height: 295,
			        multiselect: true,
			        caption: "Course List",
			        toppagger:true,
			        rownumbers: true,
					editurl:'../course/courselist_edit.php'
			    });
				
				// Option & Property for 'Navigation Bar' in JQGrid
				jQuery("#list").jqGrid(
			        'navGrid',
		            '#pager',
		            {del:rev_condition, add:false, edit:false, search:false, refresh:true,view:false},
		            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
		            {},{},{},{} 
			    );
				
				if (rev_condition) {
					//Add custom button for adding new records..
				  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title:"Add New Course",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){ 
					    	window.parent.$("h4").html('Add New Course');
					    	window.parent.$("#bts_iframe").attr({
					    									"src":"course/course_add.php",
					    									"width":"600",
					    									"height":"450"
					    								});
					    	window.parent.$("#my_modal").css('width', '620px');
					    	window.parent.$("#my_modal").modal("show");
					    }, 
					    position:"first",
					});

					//Add custom button for edit records..
				  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title:"Edit Selected Course",
					    buttonicon:"ui-icon-pencil", 
					    onClickButton: function(){ 
					    	var grid = $("#list");
					    	var sel_id = grid.jqGrid ('getGridParam', 'selrow');
					    	var code = grid.jqGrid('getCell', sel_id, 'course_code');
					    	var title = grid.jqGrid('getCell', sel_id, 'course_title');
					    	var des = grid.jqGrid('getCell', sel_id, 'description');
					    	window.parent.$("h4").html("Edit Course");
					    	window.parent.$("#bts_iframe").attr({
					    				"src":"course/course_edit.php?edit=1&id="+sel_id+"&code="+code+"&title="+title+"&des="+des,
					   					"width":"600",
	 									"height":"450"
					    	});
					    	window.parent.$("#my_modal").css('width', '620px');
					    	window.parent.$("#my_modal").modal("show");
					    }, 
					    id:"edit_button"
					});

					// Adding custom search button to pager
				    jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
					    buttonicon:"ui-icon-search", 
					    onClickButton: function(){ 
					    	$( "#list_toppager" ).toggle( "blind" );
					    }, 
						position:"lsat",
					});
				};

				// To see student list in a course
			    $("#std").live('click',function(){
			    	var data = $(this).attr('data');
			    	//alert(data);
			    	window.parent.$("#subList_iframe").attr({
					    				"src":"allList/studentList.php?id="+data,
					    				"height":"430"
					});
					window.parent.$("#my_modal_without_header").css('width', '705px');
					window.parent.$("#my_modal_without_header").modal("show");
			    });

			    // For instructors List in a course
			    $("#ins").live('click',function(){
			    	var data = $(this).attr('data');
			    	//alert(data);
			    	window.parent.$("#subList_iframe").attr({
					    				"src":"allList/instructorList.php?id="+data
					});
					window.parent.$("#my_modal_without_header").css('width', '705px');
					window.parent.$("#my_modal_without_header").modal("show");
			    });

				// When clicked on any course, this function will be called
				$('.myLink').live('click', function() { 
				    var data = $(this).attr('data');
				    var array = data.split("*");

				    window.parent.$("#course_of_a_instructor_frame").attr({
								    									"scrolling": "no", 
								    									"src":"allList/studentList.php?id="+array[0],
								    									"width":"760",
								    									"height":"400"
								    								});
				    window.parent.$("#course_of_a_instructor_div").dialog({title:"STUDENTS in "+array[1]});
				    window.parent.$("#course_of_a_instructor_div").dialog("open");
				});

				// To change the status of the course
				$('.statusLink').live('click', function() { 
					$(".loading").css("display", "block"); 
				    var data = $(this).attr('data');
				    var array = data.split("*");
				    $.ajax({
				    	type:"POST",
				    	url: "ajax_change_data.php",
						data: { row_id: array[0], status: array[1], table: "course_m_details",id_column:"course_id", },
						success:function(data){
							if (data=="success") {
								$("#list").trigger("reloadGrid",[{page:1}]);
							};
						},
						failure:function(){
							alert("Error occured.");
						}
				    });
				});

				// Initially Hide the search bar at the bottom of the navigation bar
				$("#list_toppager").hide();

				// When we click on button 'search' at the bottom search-bar
				$("#search_button").click(function(){
					$(".loading").css("display", "block"); 
					$("#list").jqGrid('setGridParam',{
						postData:{
							searchField:$("#searchField").val(),
							searchString:$("#searchString").val() ,
							searchOper:$("#searchOper").val()
						}, search:true
					});
					$("#list").trigger('reloadGrid');
				});

				// To show all records for the list
				$("#showAll").click(function(){ 
					$(".loading").css("display", "block"); 
					$("#list").jqGrid('setGridParam',{ postData:{rows:"10",page:"1", sidx:"course_id", sord:"asc"}, search:false});
					$("#list").trigger("reloadGrid",[{page:1}]); 
				});
			}); 
		</script>
	</head>
<body>
    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 

    <div id="list_toppager" style="background-color:#C0C0C0;">
		<table style="font-size:100%;">
			<tr>
				<td>
					<select id="searchField">
						<option value="course_code">Course Code</option>
						<option value="course_title">Course Title</option>
					</select>
				</td>
				<td>
					<select id="searchOper">
						<option value="eq">Equal</option>
						<option value="ne">Not equal</option>
						<option value="">Less than</option>
						<option value="le">Less than or equal</option>
						<option value="gt">Greater than</option>
						<option value="ge">Greater or equal</option>
						<option value="bw">Begins With</option>
						<option value="bn">Does not begin with</option>
						<option value="in">In</option>
						<option value="ni">Not in</option>
						<option value="ew">Ends with</option>
						<option value="en">Does not end with</option>
						<option value="cn">Contains</option>
						<option value="nc">Does not contain</option>
						<option value="nu">Is null</option>
						<option value="nn">Is not null</option>
					</select>
				</td>
				<td>
					<input id="searchString" type="text" size="40">
				</td>
				<td><button id="search_button">Search</button></td>
				<td><button id="showAll">Show All</button></td>
			</tr>
		</table>
	</div>
</body>
</html>