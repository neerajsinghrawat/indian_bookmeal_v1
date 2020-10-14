<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => ['web']], function() {
 
// Login Routes...
    Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
    Route::get('login/{slug}','Auth\LoginController@showLoginForm');
    //Route::get('', ['as' => 'login', 'uses' => 'Auth\LoginController@facebook_login']);
    Route::get('/facebook-login', 'Auth\LoginController@facebook_login');
    Route::post('login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);
   
    Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

    Route::get('/redirect', 'Auth\LoginController@redirectToProvider');
    Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

    Route::get('/twitterredirect', 'Auth\LoginController@twitterRedirect');
    Route::get('/twitter/callback', 'Auth\LoginController@TwitterCallback');

    Route::get('/facebookRedirect', 'Auth\LoginController@facebookRedirect');
    Route::get('/facebook/callback', 'Auth\LoginController@facebookCallback');
    
 
// Registration Routes...
    Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
    Route::post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
    Route::get('activation_key/{id}', 'Auth\ActivationKeyController@activateKey');
 
// Password Reset Routes...
    Route::get('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('password/reset/{token}', ['as' => 'password.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
    Route::post('password/reset', ['as' => 'password.reset.post', 'uses' => 'Auth\ResetPasswordController@reset']);

//product routes
    Route::get('/product/{slug}', 'Front\ProductsController@detail');
    Route::get('/search-postal', 'Front\ProductsController@search_postalcode');
    Route::get('/products/autocomplete_postcode/', 'Front\ProductsController@autocomplete_postcode');
    Route::post('/products/search_postalcode',  ['as' => 'products.search_postalcode.post',   'uses' => 'Front\ProductsController@search_postalcode']);
    Route::post('/products/ajax_search_postalcode', 'Front\ProductsController@ajax_search_postalcode');

//Cart routes
    Route::post('/products/add_to_cart', 'Front\ProductsController@add_to_cart');
    Route::post('/products/update-cart', 'Front\ProductsController@update_cart');

    Route::post('/products/cart-step',  ['as' => 'products.cart-step.post',   'uses' => 'Front\ProductsController@shopping_cart_step']);

    Route::get('/shopping-cart', 'Front\ProductsController@cart_detail')->middleware('auth');
    Route::post('/delete-cart', 'Front\ProductsController@delete_cart')->middleware('auth');
    

    
//category routes
    Route::get('/category/{slug}', 'Front\ProductsController@index');
    Route::get('/sub-category/{slug}', 'Front\ProductsController@sub_categoryindex');

    Route::get('payments/pay', 'Front\PaymentsController@pay');
    Route::get('/payments/success', 'Front\PaymentsController@getPaymentStatus');
    Route::post('/payments/paypal',  ['as' => 'payments.paypal.post',   'uses' => 'Front\PaymentsController@paypal']);
    Route::get('/payments/cancel', 'Front\PaymentsController@cancel');
	
	Route::get('/cart-thankyou', 'Front\PaymentsController@thankyou_cart');
	Route::get('/dashboard', 'Front\UsersController@index');

    Route::post('/create_newsletter', ['as' => 'pages.create_newsletter.post', 'uses' => 'Front\PagesController@create_newsletter']);
   
    
    //kz 18 dec 2018
    Route::post('/save_complaint', 'Front\UsersController@save_complaint');
	Route::post('/users/saveResolvedOrderComplaints', 'Front\UsersController@saveResolvedOrderComplaints');
	Route::get('/users/setDashboardTabSession', 'Front\UsersController@setDashboardTabSession');
	Route::get('/order/{order_number}', 'Front\OrdersController@order_detail');

    Route::get('/about-us', 'Front\PagesController@about_us');
    Route::put('/users/edit_profile/{id}', 'Front\UsersController@edit_profile');

    Route::post('/users/change_password',  ['as' => 'users.change_password.post',   'uses' => 'Front\UsersController@change_password']);
    Route::get('/contact-us', 'Front\PagesController@contact_us');
    Route::post('/pages/contactus_save',  ['as' => 'pages.contactus_save.post',   'uses' => 'Front\PagesController@contactus_save']);
    Route::get('/page-detail/{slug}','Front\PagesController@page_detail');
    //kz 19 dec 2018
	Route::post('/save_product_review', 'Front\ProductsController@save_product_review');
	
	Route::get('/product-tag/{slug}','Front\ProductsController@product_tag_list');

    Route::put('/users/user_address/{id}', 'Front\UsersController@user_address');

    Route::post('/users/delete_ajax_address/', 'Front\UsersController@delete_ajax_address');

    Route::post('/products/ajaxSelectDeliveryAddress/', 'Front\ProductsController@ajaxSelectDeliveryAddress');
    Route::get('/client', 'Front\PagesController@client_list');

    Route::get('/forgot-password', 'Front\UsersController@forgot_password_view');
    Route::post('forgot_password', ['as' => 'forgot_password', 'uses' => 'Front\UsersController@forgot_password']);


});




Route::get('/',  ['as' => 'front.pages.home',   'uses' => 'Front\PagesController@getHome']);

Route::get('/products', 'Front\ProductsController@index');
 /**/

 Auth::routes();

 Route::prefix('admin')->group(function() {

    Route::get('/', 'Admin\AdminController@index')->name('admin.dashboard');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    //Route::get('/categories', 'Admin\CategoriesController@index');

    Route::get('/groups', 'Admin\GroupsController@index');
    Route::get('/groups/add', 'Admin\GroupsController@add');
    Route::post('/groups/add',  ['as' => 'admin.groups.add.post',   'uses' => 'Admin\GroupsController@create']);
    Route::get('/groups/edit/{id}', 'Admin\GroupsController@edit');
    Route::put('/groups/edit/{id}', 'Admin\GroupsController@update');
    //Route::get('/groups/delete/{id}', 'Admin\GroupsController@destroy');


    Route::get('/users', 'Admin\UsersController@index');
    Route::get('/users/add', 'Admin\UsersController@add');
    Route::post('/users/add',  ['as' => 'admin.users.add.post',   'uses' => 'Admin\UsersController@create']);
    Route::get('/users/edit/{id}', 'Admin\UsersController@edit');
    Route::put('/users/edit/{id}', 'Admin\UsersController@update');
    Route::get('/users/delete/{id}', 'Admin\UsersController@destroy');



    Route::get('/categories',  ['as' => 'admin.categories.index',   'uses' => 'Admin\CategoriesController@index']);
    Route::get('/categories/add',  ['as' => 'admin.categories.add',   'uses' => 'Admin\CategoriesController@add']);
    Route::post('/categories/add',  ['as' => 'admin.categories.add.post',   'uses' => 'Admin\CategoriesController@create']);
    Route::get('/categories/edit/{id}', 'Admin\CategoriesController@edit');
    Route::put('/categories/edit/{id}', 'Admin\CategoriesController@update');
    Route::get('/categories/delete/{id}', 'Admin\CategoriesController@destroy');



    Route::get('/pages',  ['as' => 'admin.pages.index',   'uses' => 'Admin\PagesController@index']);
    Route::get('/pages/add',  ['as' => 'admin.pages.add',   'uses' => 'Admin\PagesController@add']);
    Route::post('/pages/add',  ['as' => 'admin.pages.add.post',   'uses' => 'Admin\PagesController@create']);
    Route::get('/pages/edit/{id}', 'Admin\PagesController@edit');
    Route::put('/pages/edit/{id}', 'Admin\PagesController@update');
    Route::get('/pages/delete/{id}', 'Admin\PagesController@destroy');

    Route::get('/products', 'Admin\ProductsController@index');
    Route::get('/products/add', 'Admin\ProductsController@add');
    Route::post('/products/add',  ['as' => 'admin.products.add.post',   'uses' => 'Admin\ProductsController@create']);
    Route::get('/products/edit/{id}', 'Admin\ProductsController@edit');
    Route::put('/products/edit/{id}', 'Admin\ProductsController@update');
    Route::get('/products/delete/{id}', 'Admin\ProductsController@destroy');

    Route::post('/products/delete_images/', 'Admin\ProductsController@delete_images');
    Route::get('/products/add_more_image/{id}', 'Admin\ProductsController@add_more_image');

    Route::get('/products/add_feature/{id}', 'Admin\ProductsController@add_feature');
    Route::post('/products/save_feature_value',  ['as' => 'admin.products.save_feature_value.post',   'uses' => 'Admin\ProductsController@save_feature_value']);
    
    Route::post('/products/save_more_image',  ['as' => 'admin.products.save_more_image.post',   'uses' => 'Admin\ProductsController@save_more_image']);

    Route::post('/products/getAjaxsubcategoryList/', 'Admin\ProductsController@getAjaxsubcategoryList');


    Route::get('/features', 'Admin\FeaturesController@index');
    Route::get('/features/add', 'Admin\FeaturesController@add');
    Route::post('/features/add',  ['as' => 'admin.features.add.post',   'uses' => 'Admin\FeaturesController@create']);
    Route::get('/features/edit/{id}', 'Admin\FeaturesController@edit');
    Route::put('/features/edit/{id}', 'Admin\FeaturesController@update');
    Route::get('/features/add_feature_value/{id}', 'Admin\FeaturesController@add_feature_value');
    Route::post('/features/add_value',  ['as' => 'admin.features.add_value.post',   'uses' => 'Admin\FeaturesController@add_value']);
    Route::post('/features/delete_value/', 'Admin\FeaturesController@delete_value');

    Route::post('/features/getAjaxFeatureGroupList/', 'Admin\FeaturesController@getAjaxFeatureGroupList');

    //Route::get('/features/getAjaxFeatureGroupList/', 'Admin\FeaturesController@getAjaxFeatureGroupList');



    Route::get('/featureGroups', 'Admin\FeatureGroupsController@index');
    Route::get('/featureGroups/add', 'Admin\FeatureGroupsController@add');
    Route::post('/featureGroups/add',  ['as' => 'admin.featureGroups.add.post',   'uses' => 'Admin\FeatureGroupsController@create']);
    Route::get('/featureGroups/edit/{id}', 'Admin\FeatureGroupsController@edit');
    Route::put('/featureGroups/edit/{id}', 'Admin\FeatureGroupsController@update');


    Route::get('/franchises', 'Admin\FranchisesController@index');
    Route::get('/franchises/add', 'Admin\FranchisesController@add');
    Route::post('/franchises/add',  ['as' => 'admin.franchises.add.post',   'uses' => 'Admin\FranchisesController@create']);
    Route::get('/franchises/edit/{id}', 'Admin\FranchisesController@edit');
    Route::put('/franchises/edit/{id}', 'Admin\FranchisesController@update');
    Route::get('/franchises/delete/{id}', 'Admin\FranchisesController@destroy');



    Route::get('/postcodes', 'Admin\PostcodesController@index');
    Route::get('/postcodes/add', 'Admin\PostcodesController@add');
    Route::post('/postcodes/add',  ['as' => 'admin.postcodes.add.post',   'uses' => 'Admin\PostcodesController@create']);
    Route::get('/postcodes/edit/{id}', 'Admin\PostcodesController@edit');
    Route::put('/postcodes/edit/{id}', 'Admin\PostcodesController@update');
    Route::get('/postcodes/delete/{id}', 'Admin\PostcodesController@destroy');
    
    Route::get('/payments/pay', 'Admin\PaymentsController@pay');
    Route::get('/payments/success', 'Admin\PaymentsController@getPaymentStatus');
    Route::post('/payments/paypal',  ['as' => 'admin.payments.paypal.post',   'uses' => 'Admin\PaymentsController@paypal']);

    
    Route::get('/products/cancel', 'Admin\ProductsController@cancel');
    Route::get('/products/notify', 'Admin\ProductsController@notify');
    Route::get('/products/success', 'Admin\ProductsController@success');


    Route::get('/settings', 'Admin\SettingsController@edit');
    Route::put('/settings/edit/{id}', 'Admin\SettingsController@update');


    Route::get('/couponcodes', 'Admin\CouponcodesController@index');
    Route::get('/couponcodes/add', 'Admin\CouponcodesController@add');
    Route::post('/couponcodes/add',  ['as' => 'admin.couponcodes.add.post',   'uses' => 'Admin\CouponcodesController@create']);
    Route::get('/couponcodes/edit/{id}', 'Admin\CouponcodesController@edit');
    Route::put('/couponcodes/edit/{id}', 'Admin\CouponcodesController@update');
    Route::get('/couponcodes/delete/{id}', 'Admin\CouponcodesController@destroy');
    Route::post('/couponcodes/getAjaxcodeunique/', 'Admin\CouponcodesController@getAjaxcodeunique');



    Route::get('/sliders', 'Admin\SlidersController@index');
    Route::get('/sliders/add', 'Admin\SlidersController@add');
    Route::post('/sliders/add',  ['as' => 'admin.sliders.add.post',   'uses' => 'Admin\SlidersController@create']);
    Route::get('/sliders/edit/{id}', 'Admin\SlidersController@edit');
    Route::put('/sliders/edit/{id}', 'Admin\SlidersController@update');
    Route::get('/sliders/delete/{id}', 'Admin\SlidersController@destroy');


    Route::get('/testimonials', 'Admin\TestimonialsController@index');
    Route::get('/testimonials/add', 'Admin\TestimonialsController@add');
    Route::post('/testimonials/add',  ['as' => 'admin.testimonials.add.post',   'uses' => 'Admin\TestimonialsController@create']);
    Route::get('/testimonials/edit/{id}', 'Admin\TestimonialsController@edit');
    Route::put('/testimonials/edit/{id}', 'Admin\TestimonialsController@update');
    Route::get('/testimonials/delete/{id}', 'Admin\TestimonialsController@destroy');




    Route::get('/popups', 'Admin\PopupsController@index');
    Route::get('/popups/add', 'Admin\PopupsController@add');
    Route::post('/popups/add',  ['as' => 'admin.popups.add.post',   'uses' => 'Admin\PopupsController@create']);
    Route::get('/popups/edit/{id}', 'Admin\PopupsController@edit');
    Route::put('/popups/edit/{id}', 'Admin\PopupsController@update');
    Route::get('/popups/delete/{id}', 'Admin\PopupsController@destroy');


    Route::get('/news_letters', 'Admin\PagesController@newsletter_list');
    
    // kz 18 dec 2018
    Route::get('/orders', 'Admin\OrdersController@index');
	Route::get('/orders/{order_number}', 'Admin\OrdersController@order_detail');
	
	Route::get('/users/view/{id}', 'Admin\UsersController@view');
	Route::post('/users/save_complaint', 'Admin\UsersController@save_complaint');

	
	Route::get('/products/view_reviews/{id}', 'Admin\ProductsController@viewProductReviews');

    //Route::put('admin/categories/', 'Admin\CategoriesController@update');
    //Route::get('admin/categories/edit/{id}', ['as' => 'admin.categories.edit',   'uses' => 'Admin\CategoriesController@edit']);
    //Route::get('admin', 'Admin\AdminController@dashboard');
    
   Route::get('/contact_us', 'Admin\PagesController@contact_us');


    Route::get('/emailTemplates',  ['as' => 'admin.emailTemplates.index',   'uses' => 'Admin\EmailTemplatesController@index']);
    Route::get('/emailTemplates/add',  ['as' => 'admin.emailTemplates.add',   'uses' => 'Admin\EmailTemplatesController@add']);
    Route::post('/emailTemplates/add',  ['as' => 'admin.emailTemplates.add.post',   'uses' => 'Admin\EmailTemplatesController@create']);
    Route::get('/emailTemplates/edit/{id}', 'Admin\EmailTemplatesController@edit');
    Route::put('/emailTemplates/edit/{id}', 'Admin\EmailTemplatesController@update');
    Route::get('/emailTemplates/delete/{id}', 'Admin\EmailTemplatesController@destroy');


    Route::get('/openHours', 'Admin\OpenHoursController@index');
    Route::get('/openHours/add', 'Admin\OpenHoursController@add');
    Route::post('/openHours/add',  ['as' => 'admin.openHours.add.post',   'uses' => 'Admin\OpenHoursController@create']);
    Route::get('/openHours/edit/{id}', 'Admin\OpenHoursController@edit');
    Route::put('/openHours/edit/{id}', 'Admin\OpenHoursController@update');
    Route::get('/openHours/delete/{id}', 'Admin\OpenHoursController@destroy');

    Route::post('/products/delete_ajax_tag/', 'Admin\ProductsController@delete_ajax_tag');


    Route::get('/clients', 'Admin\ClientsController@index');
    Route::get('/clients/add', 'Admin\ClientsController@add');
    Route::post('/clients/add',  ['as' => 'admin.clients.add.post',   'uses' => 'Admin\ClientsController@create']);
    Route::get('/clients/edit/{id}', 'Admin\ClientsController@edit');
    Route::put('/clients/edit/{id}', 'Admin\ClientsController@update');
    Route::get('/clients/delete/{id}', 'Admin\ClientsController@destroy');    


    Route::get('/blogs', 'Admin\BlogsController@index');
    Route::get('/blogs/add', 'Admin\BlogsController@add');
    Route::post('/blogs/add',  ['as' => 'admin.blogs.add.post',   'uses' => 'Admin\BlogsController@create']);
    Route::get('/blogs/edit/{id}', 'Admin\BlogsController@edit');
    Route::put('/blogs/edit/{id}', 'Admin\BlogsController@update');
    Route::get('/blogs/delete/{id}', 'Admin\BlogsController@destroy');    


    Route::get('/staffs', 'Admin\StaffsController@index');
    Route::get('/staffs/add', 'Admin\StaffsController@add');
    Route::post('/staffs/add',  ['as' => 'admin.staffs.add.post',   'uses' => 'Admin\StaffsController@create']);
    Route::get('/staffs/edit/{id}', 'Admin\StaffsController@edit');
    Route::put('/staffs/edit/{id}', 'Admin\StaffsController@update');
    Route::get('/staffs/delete/{id}', 'Admin\StaffsController@destroy');

    Route::post('/orders/update_delivery_satff', 'Admin\OrdersController@update_delivery_satff');

  });

/*******************************    franchise    ***************************************/
 Route::prefix('franchise')->group(function() {

    Route::get('/', 'Franchise\FranchiseController@index')->name('franchise.dashboard');
    Route::get('/login', 'Auth\FranchiseLoginController@showLoginForm')->name('franchise.login');
    Route::post('/login', 'Auth\FranchiseLoginController@login')->name('franchise.login.submit');
    Route::post('/logout', 'Auth\FranchiseLoginController@logout')->name('franchise.logout');
    
 }); 



 Route::prefix('staff')->group(function() {

    Route::get('/', 'Staff\StaffController@index')->name('staff.dashboard');
    Route::get('/login', 'Auth\StaffLoginController@showLoginForm')->name('staff.login');
    Route::post('/login', 'Auth\StaffLoginController@login')->name('staff.login.submit');
    Route::post('/logout', 'Auth\StaffLoginController@logout')->name('staff.logout');


    Route::get('/orders', 'Staff\OrdersController@index');
    Route::get('/orders/{order_number}', 'Staff\OrdersController@order_detail');
    Route::post('/orders/update_delivery_satff/', 'Staff\OrdersController@update_delivery_satff');
    
 });


