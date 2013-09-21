<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta content="charset=utf-8" />
		<title>Student List</title>
		 
		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/smoothness/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="../allList/css/ui.jqgrid.css" />
		

		<style type="text/css">
		html, body {
		    margin: 0;
		    padding: 0;
		    font-size: 75%;
		}
		</style>
         
		 
		<?php 
    include(dirname(dirname(__FILE__))."./user_session.php");
    include(dirname(dirname(__FILE__))."./function.php");
    include(dirname(dirname(__FILE__))."./db_config.php");
    
    $institute_id=$_SESSION["institute_id"];
		?> 
		 
		<script src="../allList/js/jquery.js" type="text/javascript"></script>
		<script src="jquery.jqGrid.js" type="text/javascript"></script>
		<script type="text/javascript">
		$(function(){ 
			var id = "<?php echo isset($_GET['id'])? $_GET['id']:''; ?>";
			var q="<?php echo isset($_GET['q'])? $_GET['q']:''; ?>";
			    my_url = "sub_list_POST.php?table=student&q=2&myid="+id;  //Students
			id=<?php $id=$_GET['id'];
			         $re=get_column_from_table("course_id","course_m_details","course_code='$id' AND institute_id='$institute_id'");
			         echo $re;?>;
			// JQGrid Option and method goes here
		  	$("#list").jqGrid({
				url:my_url,
				datatype: 'xml',
				mtype: 'GET',
				colNames:['ID','Name','Roll_No','Email_id','Status'],
				colModel :[ 
				  {name:'std_id', index:'std_id',hidden:true, width:30, align:'center',editoptions:{readonly:'readonly'}, editable:false}, 
				  {name:'student_name', index:'student_name', align:'center',editoptions:{size:25, maxlength: 25}, editable:true}, 
				  {name:'roll_no', index:'roll_no', width:80, align:'center',editable:true},
				  {name:'email_id', index:'email_id', width:100,editoptions:{readonly:'readonly'}, editrules:{email:true}, align:'center',editable:false}, 
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
				  loadComplete:function(){ $("#edit_button").addClass('ui-state-disabled'); },
				    onSelectAll: function(){ $("#edit_button").addClass('ui-state-disabled'); },
				pager: '#pager',
				loadonce: false,
				rowNum:8,
				rowList:[10,20,30],
				sortname: 'std_id',
				sortorder: 'asc',
				viewrecords: true,
				autowidth: true,
				height: 300,
				multiselect: true,
				gridview: true,
				rownumbers: true,
			    editurl: "studentList_edit_del.php?id1="+id,
				caption: 'Student List'
		  	}); 
			if (id=='' || (id!='' && q!='')) {
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
				//inline edit
		  	jQuery("#list").inlineNav("#pager", {add:false, edit:true});
	        	//Add custom button for adding new records..
			  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  		caption:"", 
				    buttonicon:"ui-icon-plus",
                    onClickButton: function(){ 
				    	//window.parent.$("#iframe_Div").dialog('option', 'title', 'Add New Student');
						window.parent.$('#my_modal_without_header').modal('hide');
				    	window.parent.$("h4").html('Add New Student');
				    	window.parent.$("#bts_iframe").attr({
				    									"src":"instructortotal/new_student_form.php?id="+id,
				    									"width":"600",
				    									"height":"450"
				    								});
				    	window.parent.$("#my_modal").css('width', '620px');
				    	window.parent.$("#my_modal").modal("show");
				    }, 					
				    
				    position:"first",
				});
	        }else{
	        	// Option & Property for 'Navigation Bar' in JQGrid
			  	jQuery("#list").jqGrid(
		            'navGrid',
		            '#pager',
		            {del:true, add:false, edit:false, search:false, refresh:true,view:true},
		            {}, // default settings for edit
		            {/*reloadAfterSubmit:false, closeAfterAdd:true*/}, // default settings for add
		            {},// 
		            {closeAfterSearch:true}, // search options
		            {} // view parameters
		        );
	        };
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
			$('.statusLink').live('click', function() { 
				    var data = $(this).attr('data');
				    var array = data.split("*");
				    $.ajax({
				    	type:"POST",
				    	url: "ajax_change_data.php",
						data: { row_id: array[0], status: array[1],instituteno:<?php echo $institute_id;?>, table: "student_m_details",id_column:"course_id", },
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
		<table id="list"><tr><td/></tr></table> 
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
							<option value="student_name">Name</option>
							<option value="roll_no">Roll No.</option>
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