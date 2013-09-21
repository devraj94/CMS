<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>TA List</title>

		<link rel="stylesheet" type="text/css" media="screen" href="css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />

		<style type="text/css">
		html, body {
		    margin: 0;
		    padding: 0;
		    font-size: 75%;
		}
		</style>
   
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(function () {
				$("#list").jqGrid({
				    url:"list_POST.php?table=ta_m_details",
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["ID", "Name", "Address", "Email-id", "Contact No","Status"],
			        colModel: [
			            { name: "ta_id", index:"ta_id",hidden:true, width: 20, align: "center",editable: false  },
			            { name: "ta_name", index:"ta_name", width: 90, search:true, align: "center",editable: true},
			            { name: "address", index:"address", search:true, width: 100, align: "center",editable: true},
			            { name: "email_id", index:"email_id", search:true, width: 60, align: "center",editable: false},
			            { name: "contactNo", index:"contactNo", search:true, width:50, sortable: true,align: "center",editable: true},
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
			        editurl: "../ta/taList_edit_del.php",
			        caption: "T.A. List"
			    });
				// Option & Property for 'Navigation Bar' in JQGrid
				jQuery("#list").jqGrid(
			        'navGrid',
		            '#pager',
		            {del:true, add:false, edit:false, search:true, refresh:true,view:false},
		            {reloadAfterSubmit:true, closeAfterEdit:true}, // default settings for edit
		            {/*reloadAfterSubmit:false, closeAfterAdd:true*/}, // default settings for add
		            {},// 
		            {closeAfterSearch:true}, // search options
		            {} // view parameters
		        );
		       // inline navigation bar
				jQuery("#list").inlineNav("#pager", {add:false, edit:true});
				$('.statusLink').live('click', function() { 
				    var data = $(this).attr('data');
				    var array = data.split("*");
				    $.ajax({
				    	type:"POST",
				    	url: "ajax_change_data.php",
						data: { row_id: array[0], status: array[1], table: "ta_m_details",id_column:"ta_id", },
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
	</body>
</html>