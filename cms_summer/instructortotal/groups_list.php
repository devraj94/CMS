<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>GROUPS</title>

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
			var id="<?php echo $_GET['id']; ?>";
			    $("#list").jqGrid({
			        url: "list_POST.php?table=group_t_details&id="+id,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["Group Name", "Student Name", "Email Id","Roll No"],
			        colModel: [
						{ name: "group_name", index:"group_name", width: 90, search:true, align: "center" },
			            { name: "name", index:"name", search:true, width: 90, align: "center" },
			            { name: "email_id", index:"email_id", search:true, width: 100, align: "center" },
			            { name: "roll_no",index:"roll_no",align:"center"}
			        ],
			        pager: "#pager",
			        loadonce:false,
			        pgbuttons: true,
			        rowNum:5,
				   	rowList: [10, 20, 30, 50],
			        sortname: "group_No",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        autoheight: true,
			        multiselect: true,
			        caption: "Students List",
			        rownumbers: true
			    });
				jQuery("#list").jqGrid(
		            'navGrid',
		            '#pager',
		            {del:false,add:false,edit:true, search: false, refresh: true },
		            {},                        // default settings for edit
		            {},                        // default settings for add
		            {},                        // 
		            {closeAfterSearch:true},   // search options
		            {}                         // view parameters
		        );
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
							<option value="group_name">Group Name</option>
							<option value="group_No">Group No.</option>
							<option value="name">Student Name</option>
						</select>
					</td>
					<td><button id="search_button">Search</button></td>
					<td><button id="showAll">Show All</button></td>
				</tr>
			</table>
		</div>
</body>
</html>