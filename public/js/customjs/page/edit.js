var app = angular.module('App',['GHAFramework']);

app.controller('PageController', function($scope, $http, $rootScope){
	
	$scope.page = GlobalStorage.get('page');

	$scope.setSlug = function(e, val){
		$http.post(url.api+'/slug/page',{q: val})
			.success(function(res){
				$scope.page.slug = res.slug;
				$rootScope.$emit('slug.set', res.slug);
			});
	}

	$rootScope.$on('slug.change', $scope.setSlug);
	$scope.publish = function(publish) {
		$scope.errors = {};

		$scope.page.publish = publish;
		$scope.page.content = angular.element('#content_editor').val();

		$http.post(url.api+'/page', $scope.page)
			.success(function(res){
				if(res.success){
					if(res.redirect)
						window.location.href = res.redirect;
				}else{
					$scope.errors = res.error_msg;
				}
			})
			.error(function(res){
				console.log(res);
				bsbox.alert({type: 'danger', message: 'Something went wrong.'});
			});
		console.log($scope.page);
	}
});

angular.element(document).ready(function(){
	angular.bootstrap(document, ['App']);
});

$(function(){
	var editor = $('#content_editor').editable({
		inlineMode:false,
		useFrTag:false,
		imageUploadURL: url.api + '/upload/page-img',
		imageUploadParam: 'img'
	}).on('editable.imageError',function(e,m,res){
		bsbox.dialog({type:'danger',title:'Upload Error',message:'Error occured while uploading'})
		console.log(res);
	}).on('imageDeleteSuccess', function(e, f){
		console.log(e, f)
	});
	
	
});