var Util = {
	ajax : function(callData, callback){
		$.ajax({
			type: "POST",
			url : "api/index.php",
			async: false,
			data : callData
		}).done(function(data){
			var retData = $.parseJSON(data);
			callback(retData);
		});
	},
	
	isset : function(item){
		if(typeof item != 'undefined'){
			return true;
		}
		else{
			return false;
		}
	},
	
	isUserAuthenticated : function(){
		Util.ajax({
			cmd : "isAuthenticated"
		},
		function(response){
			if(response.status == "OK"){
				AppData.User = response.data;
			}
			else{
				AppData.User = undefined;
			}
		});
	}

}