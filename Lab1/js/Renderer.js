var Renderer = {
	renderLandingPage : function(data){
		var source = Templates.landing;
		var template = Handlebars.compile(source);

		$("#pageContainer").html(template(data));
	},
	
	renderLoginPage : function(data){
		var source = Templates.login;
		var template = Handlebars.compile(source);

		$("#pageContainer").html(template(data));
	},

	renderUserDashboardPage : function(data) {
		var source = Templates.userDashboard;
		var template = Handlebars.compile(source);

		$("#pageContainer").html(template(data));
	},
	
	renderNonAuthenticatedUserPage : function(data){
		var source = Templates.otherUserPage;
		var template = Handlebars.compile(source);
		
		$("#pageContainer").html(template(data));
	},
	
	renderUserPage : function(userEmail){
		Util.isUserAuthenticated();
		if(Util.isset(AppData.User)){
			if(AppData.User.userEmail == userEmail){
				Renderer.renderUserDashboardPage();
			}
			else{
				data = {
					'userEmail' : userEmail
				};
				Renderer.renderNonAuthenticatedUserPage(data);
			}
		}
		else{
			data = {
				'userEmail' : userEmail
			};
			Renderer.renderNonAuthenticatedUserPage(data);
		}
	}
}