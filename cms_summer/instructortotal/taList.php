<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>TA List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/ui.jqgrid.css" />

		<style type="text/css">
		html, body {
		    margin: 100;
		    padding: 100;
		    font-size: 75%;
		}
		</style>
        
		<?php 
   include(dirname(dirname(__FILE__))."./user_session.php");
	include(dirname(dirname(__FILE__))."./db_config.php");
    include(dirname(dirname(__FILE__))."./instructortotal/function.php");

	$instName = $_SESSION["instName"];
	$username = $_SESSION["username"];


	# Connecting to database
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
	mysql_select_db($dbname , $connection);

	# Getting 'user_id' from 'users' table
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 		
		$user_id=$row["user_id"];
		break;
	}

	# Getting details from 'instructor' table
	$sql = "SELECT * FROM instructor_m_details WHERE user_id = '$user_id'";
	$result = mysql_query($sql, $connection) or die(mysql_error());
	while($row = mysql_fetch_array($result))
	{ 
		$institute_id = $row["institute_id"];
		$instructorid = $row["instructor_id"];
	}
		?>
		
		<script src="../allList/js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
				// JQGrid Option and method goes here
				var taid='';
			    $("#list").jqGrid({
				    url:"list_POST.php?table=ta_instructor_course&ins=1",
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No", "Name", "Email", "Address", "Contact No","Course","Status"],
			        colModel: [
			            { name: "ta_id", index:"ta_id",editoptions:{readonly: 'readonly'},hidden:true, width: 20, search:true, align: "center",editable: true  },
			            { name: "name", index:"name", width: 90, search:true, align: "center",editable: true},
			            { name: "email_id", index:"email_id", search:true, width: 60, align: "center",editable: false},
			            { name: "address", index:"address", search:true, width: 100, align: "center",editable: true},
			            { name: "contactNo", index:"contactNo", search:true, width:50, sortable: true,align: "center",editable: true},
						{ name: "course", index:"course", search:true, width:50, sortable: true,align: "center",editable: true},
			            { name: "status", index:"status", search:true, width: 100, align: "center", editable: false,
			            	formatter:function(cellvalue, options, rowObject){
			            		if (cellvalue=="1") {
				  					return "<mm style='color:green;'><b>Active</b></mm> &nbsp; <a href='#' class='statusLink' data='"+options["rowId"]+"*0'>Inactive</a>";
					  			}else if(cellvalue=="0"){
					  				return " <a href='#' class='statusLink' data='"+options["rowId"]+"*1'>Active</a> &nbsp; <mm style='color:red;'><b>Inactive</b></mm>";
					  			};
			            	}
			        	}			        
						],
			        pager: "#pager",
			        loadonce:false,
			        pgbuttons: true,
					rownumbers:true,
			        rowNum:12,
				   	rowList: [10, 20, 30],
			        sortname: "ta_id",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        height: 300,
			        multiselect: true,
			        editurl: "ta/taList_edit_del.php?taid="+taid,
			        caption: "T.A. List"
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
		        // Add custom button for adding new records..
				// Adding custom search button to pager
				    jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
					    buttonicon:"ui-icon-search", 
					    onClickButton: function(){ 
					    	$( "#list_toppager" ).toggle( "blind" );
					    }, 
						position:"lsat",
					});
					// Initially Hide the search bar at the bottom of the navigation bar
				$("#list_toppager").hide();
				     
				   
			  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title: "Add New TA",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){
						window.parent.$("h4").html('New T.A');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/ta/new_ta_form.php?ins=1",
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
					    }, 
					    position:"first",
					}
			  	);
				
				$("#search_button").click(function(){
				$("#list").jqGrid('setGridParam',{
					postData:{
						searchField:$("#searchField").val(),
						searchString:$("#searchString").val() ,
						searchOper:"eq",
						academic_year: $("#Acd_Year").val(),
						program_id:$("#prog").val()
					}, search:true
				});
				$("#list").trigger('reloadGrid');
			});
			$("#showAll").click(function(){ 
				$("#list").jqGrid('setGridParam',{ postData:{rows:"10",page:"1", sidx:"course_No", sord:"asc"}, search:false});
				$("#list").trigger("reloadGrid",[{page:1}]); 
			});
				// inline navigation bar
				jQuery("#list").inlineNav("#pager", {add:false, edit:true});
				$('.statusLink').live('click', function() { 
				    var data = $(this).attr('data');
				    var array = data.split("*");
				    $.ajax({
				    	type:"POST",
				    	url: "ajax_change_data.php",
						data: { row_id: array[0], status: array[2],courseid:array[1], instituteno:<?php echo $institute_id;?>, table: "ta_instructor_course",id_column:"course_id", },
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
			});

		</script>
</head>
	<body>
	    <table id="list"><tr><td></td></tr></table> 
	    <div id="pager"></div> 
		<!-- Search Bar at the bottom of grid-->
		<div id="list_toppager" style="background-color:#C0C0C0;">
			<table style="font-size:100%;">
				<tr>
					<td>
						<label for="searchString">Search-Value : </label>
						<input id="searchString" type="text" size="40">
					</td>
					<td>
						<select id="searchField">
							<option value="name">Name</option>
							<option value="email_id">Email id</option>
						</select>
					</td>
					<td><button id="search_button">Search</button></td>
					<td><button id="showAll">Show All</button></td>
				</tr>
			</table>
		</div>
	</body>
</html>