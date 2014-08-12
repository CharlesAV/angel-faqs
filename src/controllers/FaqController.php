<?php namespace Angel\Faqs;

use App, View;

class FaqController extends \Angel\Core\AngelController {
	
	public function __construct()
	{
		$this->Faq = $this->data['Faq'] = App::make('Faq');

		parent::__construct();
	}
	
	function index()
	{
		// Query
		$this->data['faqs'] = $this->Faq
			->orderBy('order','asc')
			->get();
			
		// Return
		return View::make('faqs::faqs.index',$this->data);
	}

	public function show($slug)
	{
		// Item
		$faq = $this->Faq->where('slug', $slug)->first();
		if (!$faq) App::abort(404);
		$this->data['faq'] = $faq;
		
		// Return
		return View::make('faqs::faqs.show', $this->data);
	}
}