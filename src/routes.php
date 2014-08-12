<?php

Route::group(array('prefix' => 'faq'), function() {

	$controller = 'FaqController';

	Route::get('/', $controller . '@index');
	Route::get('{slug}', $controller . '@show');
});

Route::group(array('prefix' => admin_uri('faqs'), 'before' => 'admin'), function() {

	$controller = 'AdminFaqController';

	Route::get('/', $controller . '@index');
	Route::get('add', $controller . '@add');
	Route::post('add', array(
		'before' => 'csrf',
		'uses' => $controller . '@attempt_add'
	));
	Route::get('edit/{id}', $controller . '@edit');
	Route::post('edit/{id}', array(
		'before' => 'csrf',
		'uses' => $controller . '@attempt_edit'
	));
	Route::post('delete/{id}', array(
		'before' => 'csrf',
		'uses' => $controller . '@delete'
	));
	Route::post('copy', array(
		'before' => 'csrf',
		'uses' => $controller . '@copy'
	));
	Route::post('order', $controller . '@order');
});