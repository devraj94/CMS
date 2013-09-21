<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>Assignment</title>

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
			var sem="<?php echo $_GET['sem']; ?>";
			    $("#list").jqGrid({
			        url: "assignment/assignmentlistpost.php?sem="+sem+"&id="+id,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["Topic", "Due Date","Permission Date", "AcademicYear","Session","Assignment"],
			        colModel: [
			            { name: "topic", index:"topic", width: 90, search:true, align: "center" },
			            { name: "due_date", index:"due_date", search:true, width: 80, align: "center" },
						{ name: "permission_date", index:"permission_date", search:true, width: 80, align: "center" },
			            { name: "academic_year", index:"academic_year", search:true, width: 80, align: "center" },
			            { name: "session",index:"session",align:"center"},
			            { name: "filename",index:"filename", width: 90,align:"center",
						   formatter:function(cellvalue, options, rowObject){
			            		return "<mm style='color:green;'><a href='../"+cellvalue+"' target='_blank' >View Assignment</a>";
			            	}
					    }
			        ],
			        pager: "#pager",
			        loadonce:false,
			        rowTotal: 2000,
			        pgbuttons: true,
			        viewrecords: true,
					multiselect:true,
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
		            {del:true,add:false,edit:false, search: false, refresh: true },
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
				$("#list").jqGrid('setGridParam',{ postData:{rows:"10",page:"1", sidx:"session", sord:"asc"}, search:false});
				$("#list").trigger("reloadGrid",[{page:1}]); 
			});
				jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title: "Upload New Assignment",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){ 
						window.parent.$("#my_modal_without_header").modal("hide");
						window.parent.$("h4").html('Uload New Assignment');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/assignment/upload.php?sem="+sem+"&id="+id,
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
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
							<option value="topic">Topic</option>
							<option value="academic_year">Academic Year</option>
						</select>
					</td>
					<td><button id="search_button">Search</button></td>
					<td><button id="showAll">Show All</button></td>
				</tr>
			</table>
		</div>
</body>
</html>