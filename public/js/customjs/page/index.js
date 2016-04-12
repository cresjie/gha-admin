var app = angular.module('App',['GHAFramework']);


app.controller('PageController', function($scope, $http){
	$http.get(url.api+'/page')
		.success(function(res){
			$scope.pages = res;
		});


	$scope.datetimeFormat = function(date, format){
		return new moment(date).format(format);
	}
});


angular.element(document).ready(function(){
	angular.bootstrap(document, ['App']);
});