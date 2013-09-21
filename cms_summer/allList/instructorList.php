<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>My First Grid</title>

		<link rel="stylesheet" type="text/css" media="screen" href="css/dark-hive/jquery-ui.custom.css" />
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
				var my_url;
				var course_id = "<?php echo isset($_GET['id'])? $_GET['id']:''; ?>"; // when we view instructor of a course (id=course_id)
				var mix_id = "<?php echo isset($_GET['mix_id'])? $_GET['mix_id']:''; ?>";
				condition=true;
				rev_condition=false;
				width=1147;
				if (course_id!="") {
					my_url="sub_list_POST.php?table=instructor_m_details&course_id="+course_id;
					condition=false;
					rev_condition=true;
					width=700;
				}else if (mix_id!="") {
					my_url="sub_list_POST.php?table=instructor_m_details&mix_id="+mix_id;
					condition=false;
					rev_condition=true;
					width=700;
				}else{
					my_url="list_POST.php?table=instructor_m_details";
				};
				// JQGrid Option and method goes here
			    $("#list").jqGrid({
			        url: my_url,
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No", "Name", "Email", "Address", "Contact No","Status"],
			        colModel: [
			            { name: "instructor_id", index:"instructor_id", hidden:true, width: 20, align: "center",editable: false  },
			            { name: "instructor_name", index:"instructor_name", width: 70, search:true, align: "center",editable: true,
			            	formatter:function(cellvalue, options, rowObject){
			            		if (condition) {
			            			return "<a href='#' class='myLink' data='"+options["rowId"]+"'>"+cellvalue+"</a>";
			            		}else{
			            			return cellvalue;
			            		};
			            	},
			            	unformat:function(cellvalue, options, rowObject){
			            		return cellvalue;
			            	}
			        	},
			            { name: "email_id", index:"email_id", search:true, width: 60, align: "center",editable: false},
			            { name: "address", index:"address", search:true, width: 150, align: "center",editable: true},
			            { name: "contactNo", index:"contactNo", search:true, width:50, sortable: true,align: "center",editable: true},
			            { name: "status", index: "status",width: 40, align: "center", editable: false, hidden:rev_condition,
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
			        rowNum:10,
				   	rowList: [10, 20, 30],
			        sortname: "instructor_id",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        width: width,
			        height: 300,
			        multiselect: true,
			        rownumbers: true,
			        editurl: "../instructor/instructorList_edit_del.php",
			        caption: "instructor List"
			    });
				jQuery("#list").jqGrid(
		            'navGrid',
		            '#pager',
		            {del:condition,add:false,edit:false, search: true, refresh: true,refreshtitle:"Reload List" },
		            {}, // default settings for edit
		            {},   // default settings for add
		            {top:"130", left:"300"},   // 
		            {closeAfterSearch:true},   // search options
		            {}                         // view parameters
		        );
		        if (condition) {
		        	// Add custom button for adding new records..
				  	jQuery("#list").navGrid("#pager").navButtonAdd("#pager",{
			  			caption:"", 
			  			title: "Add New Instructor",
					    buttonicon:"ui-icon-plus", 
					    onClickButton: function(){ 
					    	window.parent.$("h4").html('Add New Instructor');
					    	window.parent.$("#bts_iframe").attr({
					    									"src":"instructor/new_instructor_form.php",
					    									"width":"500",
					    									"height":"350"
					    								});
					    	window.parent.$("#my_modal").css('width', '520px');
					    	window.parent.$("#my_modal").modal("show");
					    }, 
						position:"first",
					});

					//
					jQuery("#list").inlineNav("#pager", {add:false, edit:true,
						editParams:{

						    successfunc: function(data){ 
						   		//alert(data.responseText);
						    	window.parent.showDialog("SUCCESS!","Instructor successfully updated.",0,0);
						    	return true;
						    },
						    aftersavefunc:function(rowid){
								jQuery("#list").saveRow(rowid);
								return true;
							}
					    }//editParams
					});
		        };
		        
				
			  	$('.statusLink').live('click', function() { 
			  		$(".loading").css("display", "block");
				    var data = $(this).attr('data');
				    var array = data.split("*");
				    $.ajax({
				    	type:"POST",
				    	url: "ajax_change_data.php",
						data: { row_id: array[0], status: array[1], table: "instructor_m_details",id_column:"instructor_id", },
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

				$('.myLink').live('click', function() { 
				    var data = $(this).attr('data');
		        	window.parent.$("#subList_iframe").attr({
					    				"src":"allList/courseList.php?instructor_id="+data,
					    				"height":"430"
					});
					window.parent.$("#my_modal_without_header").css('width', '705px');
					window.parent.$("#my_modal_without_header").modal("show");
				});

				$("#click").click(function(){
					window.parent.showDialog("message");
				});
			});

		</script>
</head>
	<body>
	    <table id="list"><tr><td></td></tr></table> 
	    <div id="pager"></div> 
	</body>
</html>