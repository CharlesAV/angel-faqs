@extends('core::admin.template')

@section('title', 'FAQs')

@section('js')
	{{ HTML::script('packages/angel/core/js/jquery/jquery-ui.min.js') }}
	<script>
		$(function() {
			$("tbody").sortable(sortObj);
		});
	</script>
@stop


@section('content')
	<div class="row pad">
		<div class="col-sm-8 pad">
			<h1>FAQs</h1>
			<a class="btn btn-sm btn-primary" href="{{ admin_url('faqs/add') }}">
				<span class="glyphicon glyphicon-plus"></span>
				Add
			</a>
		</div>
		<div class="col-sm-4 well">
			{{ Form::open(array('role'=>'form', 'method'=>'get')) }}
				<div class="form-group">
					<label>Search</label>
					<input type="text" name="search" class="form-control" value="{{ $search }}" />
				</div>
				<div class="text-right">
					<input type="submit" class="btn btn-primary" value="Search" />
				</div>
			{{ Form::close() }}
		</div>
	</div>
	@if (Config::get('core::languages') && !$single_language)
		{{ Form::open(array('url'=>admin_uri('faqs/copy'), 'role'=>'form', 'class'=>'noSubmitOnEnter')) }}
	@endif

	<div class="row">
		<div class="col-sm-9">
			<table class="table table-striped">
				<thead>
					<tr>
						<th style="width:80px;"></th>
						@if (Config::get('core::languages') && !$single_language)
							<th style="width:60px;">Copy</th>
						@endif
						<th>Question</th>
					</tr>
				</thead>
				<tbody data-url="faqs/order">
				@if(count($faqs))
					@foreach ($faqs as $faq)
						<tr data-id="{{ $faq->id }}">
							<td>
								<input type="hidden" class="orderInput" value="{{ $faq->order }}" />
								<a href="{{ $faq->link_edit() }}" class="btn btn-xs btn-default">
									<span class="glyphicon glyphicon-edit"></span>
								</a>
								<button type="button" class="btn btn-xs btn-default handle">
									<span class="glyphicon glyphicon-resize-vertical"></span>
								</button>
							</td>
							<td>{{ $faq->question }}</td>
						</tr>
					@endforeach
				@else 
					<tr>
						<td colspan="4" align="center">
							No FAQs Found.
						</td>
					</tr>
				@endif
				</tbody>
			</table>
		</div>
	</div>
@stop