<?php
	include(dirname(dirname(__FILE__))."./function.php");
	session_start();
	$user_id = $_SESSION["user_id"];
	$current_a_id = get_column_from_table("admin_id","admin_m_details","user_id='$user_id'");
	$type = "";
	if (row_exist("users_role","user_id='$user_id' AND role_id='2'")) {
		$type = "Primary";
	}else $type = "Secondary";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta content="charset=utf-8" />
		<title>Admin List</title>
		 
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
		$(function(){ 
			var CAI = "<?php echo $current_a_id; ?>";
			var type = "<?php echo $type; ?>";
			var true_false = true;
			if (type=="Secondary") { 
				true_false=false;
			};
			// JQGrid Option and method goes here
		  	$("#list").jqGrid({
				url:'list_POST.php?table=admin_m_details',
				datatype: 'xml',
				mtype: 'GET',
				colNames:['ID','Name', 'Email-id','Designation','Role','Status'],
				colModel :[ 
				  	{name:'admin_id', index:'admin_id',hidden:true}, 
				  	{name:'admin_name', index:'admin_name', width:90, edittype:'text', align:'center',editable:true}, 
				  	{name:'email_id', index:'email_id', width:80, align:'center',editable:false},  
				  	{name:'admin_designation', index:'admin_designation', width:80, align:'center',editable:true}, 
				 	{name:'type', index:'type', width:50, align:'center',
				  		editoptions: { value: "2:Primary; 3:Secondary" }, edittype:"select", 
				            		editable:true},
				  	{name:'status', index:'status', align:'center',editable:false,
				  		formatter:function(cellvalue, options, rowObject){
				  			if (cellvalue=="1" && CAI!=options["rowId"] && type=="Primary") {
				  				return "<mm style='color:green;'><b>Active</b></mm> &nbsp; <a href='#' class='myLink' data='"+options["rowId"]+"*0'>Inactive</a>";
				  			}else if(cellvalue=="0" && CAI!=options["rowId"] && type=="Primary"){
				  				return " <a href='#' class='myLink' data='"+options["rowId"]+"*1'>Active</a> &nbsp; <mm style='color:red;'><b>Inactive</b></mm>";
				  			}else if ((CAI==options["rowId"] && type=="Primary") || type=="Secondary") {
				  				if (cellvalue=="1") {
				  					return "<mm style='color:green;'><b>Active</b></mm>";
				  				}else{
				  					return "<mm style='color:red;'><b>Inactive</b></mm>";
				  				};
				  			};
			           		
			            }
				  	}
				],
				onSelectRow: function(id){ 
					var selRowIds = jQuery('#list').jqGrid('getGridParam', 'selarrrow');
					if (selRowIds.indexOf(CAI) > -1) {
						$("#del_list").addClass('ui-state-disabled');
					}else {
						$("#del_list").removeClass('ui-state-disabled');
					};
			      	
			   	},
				pager: '#pager',
				loadonce: false,
				rowNum:13,
				rowList:[10,20,30],
				sortname: 'admin_id',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: true,
				height: 300,
				multiselect: true,
				gridview: true,
				rownumbers: true,
				caption: 'Admin List',
				editurl:'../admin/adminList_edit_del.php'
		  	}); 
			
			
		  	// Option & Property for 'Navigation Bar' in JQGrid
		  	jQuery("#list").jqGrid(
	            'navGrid',
	            '#pager',
	            {del:true_false, add:false, edit:false, search:false, refresh:true,view:true},
	            {reloadAfterSubmit:true, closeAfterEdit:true},{},{
	            	top:"130", left:"300"
	            },{},{
	            	top:"130", left:"300"
	            } 
	        );

	        if (true_false) {
	        	//Add custom button for adding new records..
			  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title: "Add New Admin",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){ 
					    	window.parent.$("#iframe_Div").dialog('option', 'title', 'Add New Admin');
					    	window.parent.$("#iframe").attr({
					    									"scrolling": "no", 
					    									"src":"admin/admin_add.php",
					    									"width":"400",
					    									"height":"170"
					    								});
					    	window.parent.$('#iframe_Div').dialog("open");
					    }, 
					    position:"first",
					}
			  	); 
	        };
	        
		  	// Option & Property for 'Navigation Bar' in JQGrid
		  	jQuery("#list").inlineNav("#pager", 
		  		{
		  			add:false, edit:true_false, save:true_false, cancel:true_false,
		  			editParams:{
					    oneditfunc: function() {
					        //alert("onedit"); 
					    },
					    successfunc: function(data){ 
					    	var message = data.responseText;
					    	window.parent.$("#cong").dialog('option', 'title', 'Response');
							window.parent.$("#cong").html(message);
							window.parent.$('#cong').dialog("open");
					    }
				    }//editParams
		  		}
		  	);
		  	$('.myLink').live('click', function() { 
		  		$(".loading").css("display", "block");
			    var data = $(this).attr('data');
			    var array = data.split("*");
			    $.ajax({
			    	type:"POST",
			    	url: "ajax_change_data.php",
					data: { row_id: array[0], status: array[1], table: "admin_m_details",id_column:"admin_id", },
					success:function(data){
						if (data=="success") {
							$("#list").trigger("reloadGrid",[{page:1}]);
						};
					},
					failure:function(){
						$(".loading").css("display", "none");
						window.parent.$("#cong").dialog('option', 'title', 'ERROR!');
						window.parent.$("#cong").html("Error during ajax call.");
						window.parent.$('#cong').dialog("open");
					}
			    });
			});

		}); 
		</script>
	</head>
	
	<body>
		<table id="list"><tr><td/></tr></table> 
		<div id="pager"></div>
	</body>
</html>