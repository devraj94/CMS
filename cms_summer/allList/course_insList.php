<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Course Instructor List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="css/dark-hive/jquery-ui.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />

		<style type="text/css">
			html, body { margin:0; padding:0; } .ui-widget{font-size: 70%;}
		</style>

		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(function () {
				$("#list").jqGrid({
			        url: 'list_POST.php?table=course_instructor',
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No","Course-Name","Program","Department", "Instructor", "Academic Year","Semester","Feedback-status","Session"],
			        colModel: [
			            { name: "tblid", index:"tblid", width: 12, search:true, align: "center", hidden:true, editable:false },
			            { name: "course_id", index:"course_id", width: 70, search:true, align: "center", editable:false,
			            	formatter:function(cellvalue, options, rowObject){
			            		return "<a href='#' class='myLink0' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            	}
			        	},
			        	{ name: "program", index:"program", search:true, width: 30, align: "center", editable: true},
			            { name: "department", index:"department", search:true, width: 30, align: "center", editable: true},
			            { name: "instructor_id", index:"instructor_id", width: 43, search:true, align: "center", editable:false,
			            	formatter:function(cellvalue, options, rowObject){
			            		return "<a href='#' class='myLink' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            	}
			            },
			            { name: "academic_year", index:"academic_year", search:true, width: 30, align: "center" ,editable:true},
			            { name: "semester", index:"semester", width: 17, align:"center",editable:true},
			            { name: "feedback_status", index:"feedback_status", search:true, width: 40, align: "center", editable: true},
						{ name: "session", index:"session", search:true, width: 20, align: "center", editable: true}
                               ],
			        pager: "#pager",
			        loadonce:false,
			        pgbuttons: true,
			        beforeRequest: function(){
						$("#list").jqGrid('setGridParam',{
							postData:{
								academic_year: $("#Acd_Year").val(),
								program_id:$("#prog").val(),
								department_id:$("#dep").val()
							}
						});
					},
			        rowNum:10,
				   	rowList: [10, 20, 30, 50],
			        sortname: "tblid",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        height: 250,
			        multiselect: true,
			        rownumbers: true,
			        caption: "Course Instructor List",
			        editurl: "../course_instructor/course_ins_edit_del.php"
			    });
				// Option & Property for 'Navigation Bar' in JQGrid
		  	jQuery("#list").jqGrid(
	            'navGrid',
	            '#pager',
	            {del:true, add:false, edit:false, search:false, refresh:true,view:true},
	            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
	            {/*reloadAfterSubmit:false, closeAfterAdd:true*/}, // default settings for add
	            {},// 
	            {closeAfterSearch:true}, // search options
	            {} // view parameters
	        );
	        //Add custom button for adding new records..
		  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
		  			caption:"", 
				    buttonicon:"ui-icon-plus", 
				    onClickButton: function(){ 
				    	window.parent.$("h4").html('Assign A Course to Instructor');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"course_instructor/course_instructor.php",
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
				    }, 
				    position:"first",
				}
		  	); 

		  	//
	        jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
	  			caption:"", 
			    buttonicon:"ui-icon-search", 
			    onClickButton: function(){ 
			    	$( "#list_toppager" ).toggle( "shake" );
			    }, 
				position:"lsat",
			});

		  	$('.myLink').live('click', function() { 
			    var data = $(this).attr('data');
	        	window.parent.$("#subList_iframe").attr({
				    				"src":"allList/courseList.php?mix_id="+data,
				    				"height":"430"
				});
				window.parent.$("#my_modal_without_header").css('width', '705px');
				window.parent.$("#my_modal_without_header").modal("show");
			});

			$('.myLink0').live('click', function() { 
			    var data = $(this).attr('data');
	        	window.parent.$("#subList_iframe").attr({
				    				"src":"allList/instructorList.php?mix_id="+data,
				    				"height":"430"
				});
				window.parent.$("#my_modal_without_header").css('width', '705px');
				window.parent.$("#my_modal_without_header").modal("show");
			});

			$("#list_toppager").hide();
			//
			$("#search_button").click(function(){
				$(".loading").css("display", "block"); 
				$("#list").jqGrid('setGridParam',{
					postData:{
						searchField:$("#searchField").val(),
						searchString:$("#searchString").val() ,
						searchOper:$("#searchOper").val(),
						academic_year: $("#Acd_Year").val(),
						program_id:$("#prog").val(),
						department_id:$("#dep").val()
					}, search:true
				});
				$("#list").trigger('reloadGrid');
			});

			//
			$("#showAll").click(function(){ 
				$(".loading").css("display", "block"); 
				$("#list").jqGrid('setGridParam',{ postData:{rows:"10",page:"1", sidx:"course_id", sord:"asc"}, search:false});
				$("#list").trigger("reloadGrid",[{page:1}]); 
			});

			// change function 
			$("#Acd_Year").change(function(){ reload_Grid_Data(); });
			$("#prog").change(function(){ 
				$(".loading").css("display", "block");
				$.ajax({
					type:"POST",
					url:"../student/get_department_for_list.php",
					data:{ prog_id: $("#prog").val() },
					success:function(data){
						$("#dep").html(data);
						reload_Grid_Data();
					}
				});
				 
			});
			$("#dep").change(function(){ reload_Grid_Data(); });

			//function
			function reload_Grid_Data() {
				$("#list").jqGrid('setGridParam',{
					postData:{
						academic_year: $("#Acd_Year").val(),
						program_id:$("#prog").val(),
						department_id:$("#dep").val()
					}
				});
				$("#list").trigger('reloadGrid');
			}

		}); 
	</script>
</head>
<body>
			<?php
				include(dirname(dirname(__FILE__))."./function.php");

				$institute_id = $_SESSION["institute_id"];

				$sql = "SELECT DISTINCT academic_year FROM course_instructor WHERE institute_id='$institute_id'";
				$result = mysql_query($sql) or die("Couldn't execute query.".mysql_error());

				$prog_query = "SELECT * FROM program_m_details WHERE institute_id='$institute_id'";
				$prog_result = mysql_query($prog_query) or die("Couldn't execute query.".mysql_error());

				$dep_query = "SELECT * FROM department_m_details WHERE institute_id='$institute_id'";
				$dep_result = mysql_query($dep_query) or die("Couldn't execute query.".mysql_error());

				echo 
				"
					<table>
						<tr>
							<td> &nbsp; &nbsp; Selcect <b>Academic-Year</b> & <b>Program</b> & <b>Department</b> :</td> 
							<td>
								<select id='Acd_Year'>
									<option value='all'>All</option>";
									if (mysql_num_rows($result) > 0) {
										while ($row = mysql_fetch_array($result)) {
											echo "<option value='".$row["academic_year"]."'>".$row["academic_year"]."</option>";
										}
									}
									echo "
								</select>
							</td>
							<td>
								<select id='prog'>
									<option value='all'>All</option>";
									if (mysql_num_rows($prog_result) > 0) {
										while ($row = mysql_fetch_array($prog_result)) {
											echo "<option value='".$row["program_id"]."'>".$row["program_name"]."</option>";
										}
									}
									echo "	
								</select>
							</td>
							<td>
								<select id='dep'>
									<option value='all'>All</option>";
									if (mysql_num_rows($dep_result) > 0) {
										while ($row = mysql_fetch_array($dep_result)) {
											echo "<option value='".$row["department_id"]."'>".$row["department_code"]."</option>";
										}
									}
									echo "	
								</select>
							</td>
						</tr>
					</table>
				";
			?>

    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
    <div id="list_toppager" style="background-color:#C0C0C0;">
		<table style="font-size:100%;">
			<tr>
				<td>
					<select id="searchField">
						<option value="course_title">Course-Name</option>
						<option value="instructor_name">Instructor</option>
						<option value="semester">Semester</option>
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