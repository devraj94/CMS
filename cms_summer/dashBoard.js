// increase the default animation speed to exaggerate the effect
$.fx.speeds._default = 150;
$(function() {
	$("#webwidget_vertical_menu").webwidget_vertical_menu({
		menu_width: '180',
		menu_height: '25',
		menu_margin: '1',
		menu_text_size: '15',
		menu_text_color: '#CCC',
		menu_background_color: '#666',
		menu_border_size: '2',
		menu_border_color: '#000',
		menu_border_style: 'solid',
		menu_background_hover_color: '#999',
		directory: 'sidebar'
	});

	$('#iframe_Div').dialog({
		autoOpen:false, modal:true, width: "auto", height: "auto", show: "blind", hide: "blind", 
		buttons: {
			Add: function(){
				$('#iframe').contents().find('#submit').click();
	  		},
	 		Reset: function(){
	  			$('#iframe').contents().find('#reset').click();
	  		},
	  		Close: function(){
	 			$('#iframe').contents().find('#reset').click();
	 			$(this).dialog("close");
	  		},
	  	}
	});

	$('#course_of_a_instructor_div').dialog({
		autoOpen:false, width: "auto", height: "auto", show: "blind", hide: "blind"
	});
	$("#course_of_a_instructor_div.ui-dialog-titlebar").hide();
	
	// Dialog for congratulation
	$("#cong").dialog({ autoOpen: false,modal: true,closeOnEscape: true});
	$("#error").dialog({ autoOpen: false,modal: true,closeOnEscape: true});
	// after closing pop-up dialog registration form (iframe1) will also close
	$('div#cong').bind('dialogclose', function(event) {
		$("#iframe_Div").dialog("close");
		window.frames[0].$("#list").trigger("reloadGrid",[{page:1}]);
	});
	//
	$('#my_modal').on('hidden', function () {
		window.frames[0].$("#list").trigger("reloadGrid",[{page:1}]);
		
	});
	
});

function open_program_dialog() {
	$("#iframe_Div").dialog('option', 'title', 'Add New Program');
	$("#iframe").attr({
				    	"scrolling": "no", 
				    	"src":"other/add_program.php",
				    	"width":"300",
				    	"height":"100"
				    });
	$('#iframe_Div').dialog("open");
}
function open_department_dialog() {
	$("#iframe_Div").dialog('option', 'title', 'Add New Department');
	$("#iframe").attr({
				    	"scrolling": "no", 
				    	"src":"other/add_department.php",
				    	"width":"350",
				    	"height":"100"
				    });
	$('#iframe_Div').dialog("open");
}

	function showDialog(title,message,reloadGrid,closeIframe) {
	    $('<div id="dialog" title="'+title+'">' + message + '</div>').dialog(
	        {
	            modal: true,
	            buttons: {
	                Ok: function () {
	                	$(this).dialog("close");
	                    if (closeIframe==1 || closeIframe=="1") {
	                    	$("#iframe_Div").dialog("close");
	                    };
	                    if (reloadGrid==1 || reloadGrid=="1") {
	                    	window.frames[0].$("#list").trigger("reloadGrid",[{page:1}]);
	                    };
	                }
	            }
	        }
	    );
	}