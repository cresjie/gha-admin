<head>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>@section('title') GigHubApp @show</title>

	@section('stylesheets')
		<?=HTML::style('css/bootstrap.min.css')?>
		<?=HTML::style('css/font-awesome.min.css')?>
		<?=HTML::style('css/library/gha-admin/gha-admin-framework.css')?>
		<?=HTML::style('css/plugins/bsbox/bsbox.css')?>
		
		<?=Head::renderStyles()?>
	@show


	@section('scripts')
		<?=HTML::script('js/library/jquery/jquery-1.10.1.min.js')?>
		<?=HTML::script('js/library/angular/angular.min.js')?>

		<?=HTML::script('js/library/angular/angular-route.min.js')?>

		<?=HTML::script('js/library/bootstrap/bootstrap.min.js')?>
		<?=HTML::script('js/plugins/bsbox/bsbox2-bundle.js')?>
		<?=HTML::script('js/library/gha-admin/main-script.js')?>

		<?=HTML::script('js/library/gha-admin/app.js')?>
		
		<?=Head::renderScripts()?>
		<script>
			var url = {
				api: '<?=URL::to('api')?>',
				sites: <?=json_encode(Config::get('gha.link'))?>
			}
		</script>
		
	@show
</head>