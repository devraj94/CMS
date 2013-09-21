<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title>My First Grid</title>

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
			        url: "instituteList_POST.php",
			        datatype: "xml",
			        mtype: "GET",
			        colNames: ["No", "Name", "Email", "Domain","Location","City","PinCode","State","Phone_No","Fax_No", "Status", "Admin"],
			        colModel: [
			            { name: "institute_id", index:"institute_id", width: 20, search:true, align: "center" },
			            { name: "name", index:"name", width: 90, search:true, align: "center" },
			            { name: "email_id", index:"email_id", search:true, width: 80, align: "center" },
			            { name: "url", index:"url", search:true, width: 80, align: "center" },
			            { name: "institute_address",index:"institute_address",align:"center"},
			            { name: "city",index:"city", width: 90,align:"center"},
			            { name: "pin_code",index:"pin_code", width: 90,align:"center"},
			            { name: "state",index:"state", width: 100,align:"center"},
			            { name: "institute_phone",index:"institute_phone",align:"center"},
			            { name: "institute_fax",index:"institute_fax",align:"center"},
			            { name: "status", index:"status", search:true, edittype:"select", 
			            		editoptions: { value: "active:active; inactive:inactive" },
			            		 width: 100, align: "center", editable: true 
			            },
			            { name: "instAdmin", index:"instAdmin", search:true, width: 100, sortable: true,align: "center" }
			        ],
			        pager: "#pager",
			        loadonce:false,
			        rowTotal: 2000,
			        pgbuttons: true,
			        //rowNo:50,
				   	rowList: [10, 20, 30],
			        sortname: "institute_id",
			        sortorder: "asc",
			        viewrecords: true,
			        gridview: true,
			        autowidth: true,
			        height: 300,
			        multiselect: true,
			        cellEdit: true,
			        cellurl:"edit_InstituteList.php",
			        caption: "institute List"
			    });
				jQuery("#list").jqGrid(
		            'navGrid',
		            '#pager',
		            {del:false,add:false,edit:true, search: true, refresh: true },
		            {},                        // default settings for edit
		            {},                        // default settings for add
		            {},                        // 
		            {closeAfterSearch:true},   // search options
		            {}                         // view parameters
		        );
			});

		</script>
</head>
<body>
    <table id="list"><tr><td></td></tr></table> 
    <div id="pager"></div> 
</body>
</html>