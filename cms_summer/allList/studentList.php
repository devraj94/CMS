<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta content="charset=utf-8" />
		<title>Student List</title>
		 
		<link rel="stylesheet" type="text/css" media="screen" href="css/dark-hive/jquery-ui.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
		

		<style type="text/css">
			html, body { margin: 0; padding: 0; } .ui-widget{font-size: 75%;}
		</style>

		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function(){ 
			var id = "<?php echo isset($_GET['id'])? $_GET['id']:''; ?>"; // when we view student of a course (id=course_id)
			var mix_id = "<?php echo isset($_GET['mix_id'])? $_GET['mix_id']:''; ?>";
			var q="<?php echo isset($_GET['q'])? $_GET['q']:''; ?>";
			var condition=true;
			var rev_condition=false;
			var width=700;
			if (id=='' && mix_id=='' && q=='') {
				width=1147;
				condition = false;
				rev_condition=true;
				my_url = 'list_POST.php?table=student_m_details';
			}else if (id!="") {
				
				my_url = 'sub_list_POST.php?table=student_m_details&course_id='+id;
			};
			var lastSel = -1;
			// JQGrid Option and method goes here
		  	$("#list").jqGrid({
				url:my_url,
				datatype: 'xml',
				mtype: 'GET',
				colNames:['ID','Name','Roll_No','Email_id','Program','Department','Status'],
				colModel :[ 
				  	{name:'student_id', index:'student_id',hidden:true, width:30, align:'center',editable:false}, 
				  	{name:'student_name', index:'student_name', align:'center', editoptions:{size:25, maxlength: 25}, editable:true,
				  		formatter:function(cellvalue, options, rowObject){
				  			return "<a href='#' class='myLink' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            },
			            unformat:function(cellvalue, options, rowObject){
			           		return cellvalue;
			            }
				  	}, 
				  	{name:'roll_no', index:'roll_no', width:80, align:'center', editable:false},
				  	{name:'email_id', index:'email_id', width:100, align:'center',editable:false}, 
				  	{name:'program_id', index:'program_id', width:60, align:'center', editable:false},
				  	{name:'department_id', index:'department_id', width:60, align:'center', editable:false},	
				  	{name:'status', index:'status', align:'center',width:60, editable:false,
				  		formatter:function(cellvalue, options, rowObject){
		            		if (cellvalue=="1") {
			  					return "<mm style='color:green;'><b>Active</b></mm> &nbsp; <a href='#' class='statusLink' data='"+options["rowId"]+"*0'>Inactive</a>";
				  			}else if(cellvalue=="0"){
				 				return " <a href='#' class='statusLink' data='"+options["rowId"]+"*1'>Active</a> &nbsp; <mm style='color:red;'><b>Inactive</b></mm>";
					  		};
			            },
			            hidden:condition
				  	}
				  
				],
				onSelectRow: function (id) {
			        if (id && id !== lastSel) {
			            if (lastSel !== -1) {
			                jQuery("#list").jqGrid('restoreRow', lastSel);
			            }
			            lastSel = id;
			        };
			    },
				pager: '#pager',
				loadonce: false,
				rowNum:10,
				rowList:[10,20,30],
				beforeRequest: function(){
					if (mix_id=='') {
						$("#list").jqGrid('setGridParam',{
							postData:{
								academic_year: $("#Acd_Year").val(),
								program_id:$("#prog").val(),
								department_id:$("#dep").val()
							}
						});
					};
				},
				sortname: 'student_id',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: false,
				width: width,
				height: 295,
				multiselect: true,
				gridview: true,
				rownumbers: true,
				caption: 'Student List',
				editurl:'../student/studentList_edit_del.php',
				onPaging: function(pgButton){
					var newUserValue = $('input.ui-pg-input', "#pg_pager").val();
				    var newValue = 0;
				    var currentValue = $("#list").getGridParam('page');
				    if (pgButton.indexOf("next") >= 0)
				        newValue = ++currentValue;
				    else if (pgButton.indexOf("prev") >= 0)
				        newValue = --currentValue;
				    else if (pgButton.indexOf("last") >= 0)
				        newValue = $("#list").getGridParam('lastpage');
				    else if (pgButton.indexOf("first") >= 0)
				        newValue = 1;
				    else if (pgButton.indexOf("user") >= 0)
				        newValue = newUserValue;
				    $("#list").jqGrid('setGridParam',{page:newUserValue});
				}
		  	}); 
		  	
			// Option & Property for 'Navigation Bar' in JQGrid
		  	jQuery("#list").jqGrid(
	            'navGrid',
	            '#pager',
	            {del:rev_condition, add:false, edit:false, search:false, refresh:true,view:true},
	            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
	            {/*reloadAfterSubmit:false, closeAfterAdd:true*/}, // default settings for add
	            {},// 
	            {closeAfterSearch:true}, // search options
	            {} // view parameters
	        );
	        
	        if (rev_condition || (id!='' && mix_id=='' && q!='')) {
	        	// Inline Navigation Button
		        jQuery("#list").inlineNav("#pager", {add:false, edit:rev_condition, save:rev_condition, cancel:rev_condition});
	        	//Add custom button for adding new records..
			  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  		caption:"", 
				    buttonicon:"ui-icon-plus", 
				    onClickButton: function(){ 
				    	//window.parent.$("#iframe_Div").dialog('option', 'title', 'Add New Student');
				    	window.parent.$("h4").html('Add New Student');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"student/new_student_form.php",
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
				    }, 
				    position:"first",
				});
	        }

	        //
	        jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
	  			caption:"", 
			    buttonicon:"ui-icon-search", 
			    onClickButton: function(){ 
			    	$( "#list_toppager" ).toggle( "shake" );
			    }, 
				position:"lsat",
			});

	        //
	        $('.myLink').live('click', function() { 
	        	var data = $(this).attr('data');
	        	window.parent.$("#subList_iframe").attr({
				    				"src":"allList/courseList.php?student_id="+data,
				    				"height":"430"
				});
				window.parent.$("#my_modal_without_header").css('width', '705px');
				window.parent.$("#my_modal_without_header").modal("show");
			});

	        //
	        $('.statusLink').live('click', function() {
	        	$(".loading").css("display", "block"); 
			    var data = $(this).attr('data');
			    var array = data.split("*");
			    $.ajax({
			    	type:"POST",
			    	url: "ajax_change_data.php",
					data: { row_id: array[0], status: array[1], table: "student_m_details",id_column:"student_id", },
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

			//
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
			$("#showAll").click(function(){ 
				$(".loading").css("display", "block");
				$("#list").jqGrid('setGridParam',{ postData:{rows:"10",page:"1", sidx:"student_id", sord:"asc"}, search:false});
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
			if (!isset($_GET['id']) && !isset($_GET["mix_id"])) {
				include(dirname(dirname(__FILE__))."./function.php");

				$institute_id = $_SESSION["institute_id"];

				$sql = "SELECT DISTINCT academic_year FROM student_course WHERE institute_id='$institute_id'";
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
			}
		?>

		<!-- Table for Grid-->
		<table id="list"><tr><td/></tr></table> 
		<!-- Pager for Grid-->
		<div id="pager"></div>

		<!-- Search Bar at the bottom of grid-->
		<div id="list_toppager" style="background-color:#C0C0C0;">
			<table style="font-size:100%;">
				<tr>
					<td>
						<select id="searchField">
							<option value="student_name">Name</option>
							<option value="roll_no">Roll No.</option>
							<option value="email_id">Email id</option>
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