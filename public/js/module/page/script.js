//Register Routers

app.config(function($routeProvider){

	$routeProvider.when('/page', {
			templateUrl: 'template/module/page/index.html',
			controller: 'PageIndexController',
			//scripts:[{src: 'js/library/datetime/moment.js'}]
			styles: ['css/module/page/index.css']
		})
		.when('/page/create',{
			templateUrl: 'template/module/page/create.html',
			controller: 'PageCreateController',
			//scripts: ['js/library/froala/froala_editor.min.js','js/plugins/froala/colors.min.js', 'js/plugins/froala/font_size.min.js'],
			//styles: ['css/library/froala/froala_editor.min.css']
		})
		.when('/page/:id',{
			templateUrl: 'template/module/page/show.html',
			controller: 'PageShowController'
		})
		.when('/page/:id/edit',{
			templateUrl: 'template/module/page/create.html',
			controller: 'PageEditController'
		});
});


/**
 * Controllers
 */

app.controller('PageIndexController', function($scope, $http){
	$scope.sites = {};
	angular.extend($scope.sites, url.sites);

	$http.get(url.api+'/page')
		.success(function(res){
			$scope.pages = res;
		});

	$scope.delete = function(page) {
		bsbox.confirm('Delete '+page.title+'?', function(confirmed){
			if(confirmed) {
				$http.delete(url.api+'/page/'+page.id)
					.success(function(res){
						if(res.success){
							var i = $scope.pages.data.indexOf(page);
							$scope.pages.data.splice(i, 1);
						}
					});
			}
		});
	}

	$scope.datetimeFormat = function(date, format){
		return new moment(date).format(format);
	}
});

app.controller('PageCreateController', function($scope, $http, $rootScope){
	
	$scope.page = {};
	$scope.sites = {};
	angular.extend($scope.sites, url.sites);

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
						window.location.href = '#/page';
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

app.controller('PageEditController', function($scope, $http, $rootScope, $routeParams, $location){
	$scope.page = {};
	$scope.sites = {};
	angular.extend($scope.sites, url.sites);
	
	$http.get(url.api+'/page/'+ $routeParams.id)
		.success(function(res){
			if(res.success){
				angular.extend($scope.page, res.data);
				editor.editable('setHTML', $scope.page.content);
				$rootScope.$emit('slug.set', $scope.page.slug);
			} else {
				bsbox.alert(res.error_msg);
				$location.path('page');
			}	
			
		});

	$scope.setSlug = function(e, val){
		$http.post(url.api+'/slug/page',{q: val, except: $scope.page.id})
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

		$http.put(url.api+'/page/'+$scope.page.id, $scope.page)
			.success(function(res){
				if(res.success){
					if(res.redirect)
						window.location.href = '#/page';
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