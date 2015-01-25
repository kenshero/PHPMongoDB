angular.module('todoApp.service', [])
  .factory('Member', ['$http', function($http){

  	return{
  		
  		getData : function(callback)
		{
			$http.get('/phpmongo/getdata')
			  .success(function(data){
			  	callback(data);
			  })
			  .error(function(data){

			  })
		},

		addData : function(name,phone,callback)
		{
			var data = {

				Name  : name,
				Phone : phone
 
			};

			$http.post('/phpmongo/adddata',{params : data})
			  .success(function(data){
			  	callback(data);
			  })
			  .error(function(data){

			  })	
		},

		delData : function(id,callback)
		{
			$http.post('/phpmongo/deldata/'+id)
			  .success(function(data){
			  	callback(data);
			  })
			  .error(function(data){

			})
		},

		editData : function(data,callback)
		{
			console.log(data);
			$http.post('/phpmongo/editdata',{params : data})
			  .success(function(data){
			  	callback(data);
			  })
			  .error(function(data){

			})
		}

  	}

  }]);