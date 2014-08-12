@extends('core::template')

@section('title','FAQ')

@section('content')
	<div class="row">
		<h1>FAQ</h1>
		<ul class="faq-menu">
		@foreach($faqs as $faq) 
			<li class="faq-menu-item"><a href="#faq-{{ $faq->id }}">{{ $faq->question }}</a></li>
		@endforeach
		</ul>
		<hr />
	</div>
	<div class="row">
		@foreach($faqs as $faq) 
		<div class="faq-item">
			<a name="faq-{{ $faq->id }}"></a>
			<h2 class="faq-question">{{ $faq->question }}</h2>
			<div class="faq-answer">
				{{ $faq->answer }}
			</div>
			<hr />
		</div>
		@endforeach
	</div>
@stop