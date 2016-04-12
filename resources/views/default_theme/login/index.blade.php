@extends('layout.plain')

@section('stylesheets')
	@parent
	<?=HTML::style('css/customcss/login/index.css')?>
@endsection

@section('content')
	<div class="login-form-wrapper">
		<div class="text-center">
		<img class="main-logo" height="100" src="<?=asset('images/logo/main-logo.png')?>">
		</div>
		
		<?=Form::open()?>
			@if( $errors->has('error_msg') )
				<div class="alert alert-danger">
					<?=$errors->first('error_msg')?>
				</div>
			@endif
			<div class="form-group has-feedback">
				<?=Form::email('email',null,['class' => 'form-control', 'placeholder' => 'Email'])?>
				<i class="glyphicon glyphicon-envelope form-control-feedback"></i>
			</div>

			<div class="form-group has-feedback">
				<?=Form::password('password',['class' => 'form-control', 'placeholder' => 'Password'])?>
				<i class="glyphicon glyphicon-lock form-control-feedback"></i>
			</div>
			
			<div class="text-right">
				<button class="btn btn-primary">Login</button>
			</div>
		<?=Form::close()?>
	</div>
@endsection