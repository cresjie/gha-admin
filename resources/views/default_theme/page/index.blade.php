@extends('layout.2columns')

@section('scripts')
	@parent
	<?=HTML::script('js/library/datetime/moment.js')?>
	<?=HTML::script('js/customjs/page/index.js')?>
@endsection


@section('content')
	<div ng-controller="PageController">
		<h2>Page</h2>
		<a class="btn btn-success btn-xs" href="<?=URL::route('page.create')?>">Add Page</a>

		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th width="80%">Title</th>
						<th width="10%">Author</th>
						<th width="10%">Publish</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="page in pages.data">
						<td><a href="<?=URL::route('page.index')?>/@{{page.id}}/edit">@{{page.title}}</a></td>
						<td>@{{page.author.first_name}}</td>
						<td>@{{page.published_at ? datetimeFormat(page.published_at, 'MMMM D, YYYY') : ''}}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
@endsection