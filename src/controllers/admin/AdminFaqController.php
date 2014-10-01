<?php namespace Angel\Faqs;

use Angel\Core\AdminCrudController;
use App, View;

class AdminFaqController extends AdminCrudController {

	protected $Model	= 'Faq';
	protected $uri		= 'faqs';
	protected $plural	= 'faqs';
	protected $singular	= 'faq';
	protected $package	= 'faqs';
	protected $reorderable = true;

	public function edit($id)
	{
		$Faq = App::make($this->Model);

		$faq = $Faq::withTrashed()->find($id);
		$this->data['faq'] = $faq;
		$this->data['changes'] = $faq->changes();
		$this->data['action'] = 'edit';

		return View::make($this->package . '::admin.faqs.add-or-edit', $this->data);
	}
}