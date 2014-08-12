<?php namespace Angel\Faqs;

use Angel\Core\AdminCrudController;
use App, Input, View, Validator, Config;

class AdminFaqController extends AdminCrudController {

	protected $Model	= 'Faq';
	protected $uri		= 'faqs';
	protected $plural	= 'faqs';
	protected $singular	= 'faq';
	protected $package	= 'faqs';
	protected $slug 	= 'question';
	protected $reorderable = true;

	protected $log_changes = true;
	protected $searchable = array(
		'question',
		'slug',
		'answer_plaintext'
	);

	// Columns to update on edit/add
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
	
	public function after_save($faq, &$changes = array())
	{
		$faq->answer_plaintext = strip_tags($faq->answer);
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

	/**
	 * Validate all input when adding or editing a faq.
	 *
	 * @param array &$custom - This array is initialized by this function.  Its purpose is to
	 * 							exclude certain columns that require intervention of some kind (such as
	 * 							checkboxes because they aren't included in input on submission)
	 * @param int $id - (Optional) ID of faq beind edited
	 * @return array - An array of error messages to show why validation failed
	 */
	public function validate(&$custom, $id = null)
	{
		$errors = array();
		$rules = array(
			'question' => 'required',
			'answer' => 'required'
		);
		
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			foreach($validator->messages()->all() as $error) {
				$errors[] = $error;
			}
		}
		
		$custom = array();

		return $errors;
	}
}