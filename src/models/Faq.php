<?php namespace Angel\Faqs;

use App, Config, Angel\Core\LinkableModel;

class Faq extends LinkableModel {
	public $slugSeed = 'question';
	
	public static function columns()
	{
		$columns = array(
			'question',
			'slug',
			'answer'
		);
		if (Config::get('core::languages')) $columns[] = 'language_id';
		return $columns;
	}

	public function validate_rules()
	{
		return array(
			'question' => 'required',
			'answer' => 'required'
		);
	}
	
	///////////////////////////////////////////////
	//                  Events                   //
	///////////////////////////////////////////////
	public static function boot()
	{
		parent::boot();

		static::saving(function($faq) {
			$faq->answer_plaintext = strip_tags($faq->answer);
		});
	}

	///////////////////////////////////////////////
	//               Menu Linkable               //
	///////////////////////////////////////////////
	// Menu link related methods - all menu-linkable models must have these
	// NOTE: Always pull models with their languages initially if you plan on using these!
	// Otherwise, you're going to be performing repeated queries.  Naughty.
	public function link()
	{
		$language_segment = (Config::get('core::languages')) ? $this->language->uri . '/' : '';

		return url($language_segment . 'faq/' . $this->slug);
	}
	public function link_edit()
	{
		return admin_url('faqs/edit/' . $this->id);
	}
	
	public function search($terms)
	{
		return static::where(function($query) use ($terms) {
			foreach ($terms as $term) {
				$query->orWhere('question', 'like', $term);
				$query->orWhere('answer_plaintext',  'like', $term);
			}
		})->get();
	}
}