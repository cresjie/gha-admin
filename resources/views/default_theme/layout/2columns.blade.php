<html @yield('html-attrs')>
	
	@include('html.head')

	<body class="@yield('body-class')" @yield('body-attrs') ng-controller="MainController">

		<div class="main-container">

			<div class="pull-left main-sidebar transition-400">
				 <div class="main-header">
					<a class="main-logo" href="">
						<img class="sidebar-collapse-show hide" src="<?=asset('images/logo/logo-50.png')?>">
						<img class="sidebar-collapse-hide" src="<?=asset('images/logo/main-logo-horizontal.png')?>">
					</a>
				</div> 
				 <div class="main-navigation">
					<div class="clearfix pad-10">
						<div class="profile-img circle pull-left">

							<img class="img-responsive" src="<?=App\Helpers\Upload\Image::getImage(Auth::user()->profile_img,'user_profile_img',50)?>">
						</div>
						<div class="pad-5 text-ellipsis sidebar-collapse-hide">
							<?=Auth::user()->first_name?> <?=Auth::user()->last_name?>
						</div>
					</div>
					<div class="main-navigation-header sidebar-collapse-hide">
						MAIN NAVIGATION
					</div>
					<?=Menu::renderChildren()?>
				</div> 
			</div> 

			
			
			<div class="main-content-wrapper clearfix transition-400">
				
				<div class="navbar-menu">
					
					<div class="pull-left">
						<ul class="nav navbar-nav">
							<li>
								<a id="main_sidebar_toggle" href="#"><i class="fa fa-bars"></i>&nbsp</a>
							</li>
						</ul>
					</div>
					
					<div class="pull-right">
						<ul class="nav navbar-nav">
							
							<li class="dropdown">
								<a class="dropdown-toggle" href="#" data-toggle="dropdown">
									<i class="glyphicon glyphicon-user"></i> <?=Auth::user()->first_name?> <strong class="caret"></strong>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?=URL::to('logout')?>"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
								</ul>	
							</li>
							<li><p></p></li>
						</ul>

					</div>
				</div>
				
				<div class="content">
					<div ng-view></div>
					
					@yield('content')
				</div>
				
			</div>
		</div>

		@include('html.footer')
	</body>

</html>