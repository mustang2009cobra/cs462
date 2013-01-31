
var AppData = { }

/**
 * Main entry point to application
 */
$(document).ready(function(){
	$.ajax({
		type: "POST",
		url: "api/index.php",
		data : {
			cmd : "getTemplates"
		},
		async: false,
		success: function(data){
			Templates = $.parseJSON(data);
		}
	});

	Util.isUserAuthenticated();
	if(Util.isset(AppData.User)){
		Renderer.renderUserDashboardPage();
	}
	else{
		Renderer.renderLandingPage();
	}
});