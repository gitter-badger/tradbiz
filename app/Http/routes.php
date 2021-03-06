<?php
/* Routes file
 *
 * Declare Route::get's before Route::resource and the like.
 */

/* ROUTES */
Route::group(['middleware' => ['web']], function () {
	// STATIC PAGES
	Route::get('/', ['as' => 'home', 'uses' => 'PageController@index']);
	Route::get('about', ['as' => 'about', 'uses' => 'PageController@about']);
	Route::get('proof', 'PageController@proof');
	Route::get('donate', 'PageController@donate');

	// Documentation
	Route::get('help', 'HelpController@index');
	Route::get('help/customers', 'HelpController@customers');
	Route::get('help/businesses', 'HelpController@businesses');


	// SESSION-RELATED
	Route::get('login', ['as' => 'login', 'uses' => 'SessionController@create']);
	Route::get('logout', ['as' => 'logout', 'uses' => 'SessionController@destroy']);
	Route::get('register', ['as' => 'register', 'uses' => 'UserController@create']);
	Route::resource('sessions', 'SessionController');


	// USERS
	Route::get('activate/{id}/{token}', 'UserController@activate');

	Route::post('resendlookup', 'UserController@activationLookupEmail');
	Route::get('resend', 'UserController@resendActivationEmailForm');
	Route::get('resend/{id}', 'UserController@resendActivationEmail');

	Route::get('profile', ['as' => 'profile', 'middleware' => 'auth', 'uses' => 'UserController@profile']);
	Route::get('dashboard', ['as' => 'dashboard', 'middleware' => 'auth', 'uses' => 'UserController@dashboard']);

	Route::controller('password', 'RemindersController');
	Route::resource('users', 'UserController');


	// BUSINESSES (rudimentary authentication here, more in controller)
	Route::group(['middleware' => 'auth'], function() {
		Route::resource('businesses', 'BusinessController', ['only' => ['create', 'destroy', 'store', 'edit', 'update']]);
	});

	Route::resource('businesses', 'BusinessController', ['only' => ['index', 'show']]);
	Route::get('businesses/{businesses}/flag', ['as' => 'businesses.flag', 'middleware' => 'auth', 'uses' => 'BusinessController@flag']);

	// REVIEWS
	Route::resource('reviews', 'ReviewController');



	// My test route
	Route::get('test', function() {
		return Redirect::route('businesses.show', 'a-cool-biz');
	});
});
