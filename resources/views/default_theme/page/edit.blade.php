@extends('layout.2columns')

@section('stylesheets')
	@parent
	<?=HTML::style('css/library/froala/froala_editor.min.css')?>
	<?=HTML::style('css/library/froala/froala_content.min.css')?>
@endsection


@section('scripts')
	@parent
	<?=HTML::script('js/library/froala/froala_editor.min.js')?>
	<?=HTML::script('js/plugins/froala/colors.min.js')?>
	<?=HTML::script('js/plugins/froala/font_size.min.js')?>

	<?=HTML::script('js/customjs/page/edit.js')?>
	<script>
		@if( isset($page) )
			GlobalStorage.store('page',<?=$page->toJson()?>);
		@endif
	</script>
@endsection

@section('content')
	<h2>Create Page</h2>

	<div style="max-width:900px" ng-controller="PageController">

		<?=Form::open(['route' => 'page.create', 'method' => 'post'])?>
			<div class="form-group" ng-class="{'has-error': errors.title}">
				<label class="control-label">Title</label>
				<?=Form::text('title',null,['class' => 'form-control', 'ng-model' => 'page.title', 'ng-blur' => 'setSlug($event, page.title)'])?>
				<p class="help-block" ng-repeat="msg in errors.title">@{{msg}}</p>
			</div>
			<div class="form-group slug-wrapper" ng-controller="SlugController" ng-class="{'has-error': errors.slug}">
				<label class="control-label">Link</label>
				<div>
					<span><?=Config::get('gha.link.gighubapp')?>/page/</span><span ng-hide="slug_editing">@{{slug}}</span>
					<input type="text" size="20" name="slug" class="slug-input" ng-model="page.slug" ng-show="slug_editing" ng-focus-this="slug_editing" ng-blur="doneEdit()" ng-keydown="changeWidth($event)">
					<a href="#" class="btn-edit" ng-click="slugEdit()" ng-hide="slug_editing"><i class="glyphicon glyphicon-pencil"></i></a>
				</div>
				<p class="help-block" ng-repeat="msg in errors.slug">@{{msg}}</p>
			</div>
			<div class="form-group" ng-class="{'has-error': errors.content}">
				<label class="control-label">Content</label>
				<textarea id="content_editor" class="form-control" name="content" ng-model="page.content"></textarea>
				<p class="help-block" ng-repeat="msg in errors.content">@{{msg}}</p>
			</div>
			
			<div class="form-group">
				<button type="button" class="btn btn-primary" name="publish" value="0" ng-click="publish(false)">Draft</button>
				<button type="button" class="btn btn-success" name="publish" value="1" ng-click="publish(true)">Publish</button>
			</div>

		<?=Form::close()?>

	</div>
	
@endsection