var app = angular.module('App',['GHAFramework','ngRoute']);

app.controller('MainController', function($scope, $http, $route, $sce){
	$scope.$on('$routeChangeStart', function(e, next, current){
		angular.element('[data-defer]').remove();
		ghaDeferCss(next.$$route.styles);
		ghaDeferJs(next.$$route.scripts);
	});


})





angular.element(document).ready(function(){
	angular.bootstrap(document, ['App']);
});


