<?php namespace Angel\Faqs;

use Angel\Core\AdminCrudController;
use App, View, Config;

class AdminFaqController extends AdminCrudController {

	protected $Model	= 'Faq';
	protected $uri		= 'faqs';
	protected $plural	= 'faqs';
	protected $singular	= 'faq';
	protected $package	= 'faqs';
	protected $reorderable = true;
	protected $slug = 'question';

	protected static function columns()
	{
		$columns = array(
			'question',
			'slug',
			'answer'
		);
		if (Config::get('core::languages')) $columns[] = 'language_id';
		return $columns;
	}

	public function validate_rules($id = null)
	{
		return array(
			'question' => 'required',
			'answer' => 'required'
		);
	}
	
	public function after_save($faq, &$changes = array())
	{
		$faq->answer_plaintext = strip_tags($faq->html);
		$faq->save();
	}
	
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