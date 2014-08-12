@extends('core::template')

@section('title', $faq->title)

@section('content')
	<div class="row">
		<h1 class="faq-question">{{ $faq->question }}</h1>
		<div class="faq-answer">
			{{ $faq->answer }}
		</div>
	</div>
@stop