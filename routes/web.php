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


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ],
    function()
    {

        Route::get('/redirect', 'SocialAuthFacebookController@redirect');
        Route::get('/callback', 'SocialAuthFacebookController@callback');

        Route::get('google-login',array('as'=>'glogin','uses'=>'UserController@googleLogin')) ;
        Route::get('google-user',array('as'=>'user.glist','uses'=>'UserController@listGoogleUser')) ;


        Route::post('/add-to-favourite', 'UserController@add_to_favourite')->name('add_to_favourite');
        Route::post('remove-from-cart', 'UserController@remove_from_favourite')->name('remove_from_favourite');
        Route::get('remove-from-favourite', 'UserController@remove_from_favourite_2')->name('remove_from_favourite_2');
        Route::post('show_image', 'UserController@show_image')->name('show_image');
        //use in this site
        Route::get('/products','site\HomeController@all_products')->name('all_product');
        Route::get('/about-us','site\HomeController@about')->name('about_index');
        Route::get('/contact','site\HomeController@contact')->name('contact');
        Route::post('/add-to-cart2', 'UserController@addToCart')->name('add_to_cart2');
        Route::post('/update-cart2', 'UserController@update_cart')->name('update_cart_2');
        Route::get('/delete-cart2', 'UserController@delete_cart')->name('delete_cart_2');
        Route::get('/favourite', 'UserController@favourite')->name('favourite');
        Route::get('/update-cart2_from_favourite', 'UserController@add_to_cart_from_favourite')->name('add_to_cart_from_favourite');

        Route::get('/foregetpassowrd', 'UserAuth\forgetpasswordController@index')->name('user.forgetpassword');
        Route::post('/resetpasssword', 'UserAuth\forgetpasswordController@store')->name('user.restpassword');
        Route::get('/restpassword/{token}', 'UserAuth\forgetpasswordController@dirctRestPasswordPage')->name('user.RestPassword');
        Route::post('/updatepasword', 'UserAuth\forgetpasswordController@RestPassword')->name('user.updatepassword');
        Route::get('/resetmessage/{token}', 'UserAuth\forgetpasswordController@RestMessage')->name('user.restmessage');




        Route::post('/save_contact','site\HomeController@save_contact')->name('save_contact');
        Route::post('/save_subscripe','site\HomeController@save_subscripe')->name('save_subscripe');

        Route::get('/blogs','site\BlogController@blogs')->name('blogs');
        Route::get('/archived-blogs','site\BlogController@archived_blogs')->name('archived_blogs');
        Route::get('/blog/{id}','site\BlogController@blog')->name('blog');
        Route::post('/comment','site\BlogController@comment')->name('comment_blog');



        Route::get('/search-blogs','site\BlogController@search_blogs')->name('search_blogs');
        Route::get('/search-archived-blogs','site\BlogController@search_archived_blogs')->name('search_archived_blogs');

        Route::get('/search','site\HomeController@search')->name('search');

        Route::get('/all-products/{id?}','site\HomeController@all_products')->name('all_products');
        Route::get('/all_products/{id?}','site\HomeController@all_products_2')->name('all_products_2');











        Route::get('/product','HomeController@product')->name('product');
        Route::get('/','HomeController@indexeco')->name('indexeco');



        Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'permission_dashboard']], function () {

            Route::resource('translators', 'TranslatorController');
            Route::resource('contacts', 'ContactController');
            Route::get('/contact_info-edit', 'HelpController@edit_contact_info')->name('edit_contact_info');
            Route::PUT('/save_contact_info', 'HelpController@save_contact_info')->name('save_contact_info');

            Route::get('/edit-coverPages', 'HelpController@edit_coverPages')->name('edit_coverPages');
            Route::PUT('/save-coverPages', 'HelpController@save_coverPages')->name('save_coverPages');

            Route::resource('subscripes', 'SubscripeController');


            Route::get('/edit_general_setting', 'HelpController@edit_general_setting')->name('edit_general_setting');
            Route::put('/save_general_setting', 'HelpController@save_general_setting')->name('save_general_setting');

            Route::get('/about', 'HelpController@about')->name('about');
            Route::put('/save_about', 'HelpController@save_about')->name('save_about');


            Route::post('/create-helps', 'HelpController@create_helps')->name('create_helps');
            Route::post('/save_help', 'HelpController@save_help')->name('save_help');
            Route::post('/delete_help/{id}', 'HelpController@delete_helps')->name('delete_helps');
            Route::post('/edit_helps/{id}', 'HelpController@edit_helps')->name('edit_helps');
            Route::PUT('/save_edit_helps/{id}', 'HelpController@save_edit_helps')->name('save_edit_helps');

            Route::get('/', 'HomeController@dashboard')->name('dashboard');
            Route::get('/home-section-1','SettingController@home_section_1')->name('home_section_1');
            Route::get('/create-home-section-1','SettingController@create_home_section_1')->name('create_home_section_1');
            Route::put('/save-home-section-1','SettingController@save_home_section_1')->name('save_home_section_1');
            Route::delete('/delete_home_1/{id}', 'SettingController@destroy_homesection1s')->name('delete_home_1');

            Route::get('/create-home-section-2','SettingController@create_home_section_2')->name('create_home_section_2');
            Route::put('/save-home-section-2','SettingController@save_home_section_2')->name('save_home_section_2');
            Route::delete('/delete_home_2/{id}', 'SettingController@destroy_homesection2s')->name('delete_home_2');

            Route::get('/edit-home-section-1/{id}','SettingController@edit_home_section_1')->name('edit_home_section_1');
            Route::put('/save-edit-home-section-1/{id}','SettingController@save_edit_home_section_1')->name('save_edit_home_section_1');

            Route::get('/home-section-2','SettingController@home_section_2')->name('home_section_2');
            Route::get('/edit-home-section-2/{id}','SettingController@edit_home_section_2')->name('edit_home_section_2');
            Route::put('/save-edit-home-section-2/{id}','SettingController@save_edit_home_section_2')->name('save_edit_home_section_2');

            Route::resource('/roles', 'RoleController');
            Route::resource('/users', 'dashboard\UserController');

            Route::get('/all-quantities/{id}', 'dashboard\AggregationController@show_quantities')->name('aggregations.show_quantities');


            Route::get('/all-suspend-quantities', 'dashboard\AggregationController@all_pending_quantities')->name('all_pending_quantities');
            Route::post('/all-suspend-quantities/{id}', 'dashboard\AggregationController@change_status_0f_quantity')->name('change_status_0f_quantity');
            Route::get('pending-aggregation', 'dashboard\AggregationController@pending_aggregation_in_dash')->name('pending_aggregation_in_dash');
            Route::get('/pending-order-aggregations', 'dashboard\AggregationController@pending_order_aggregations')->name('pending_order_aggregations');
            Route::get('/archived-order-aggregations', 'dashboard\AggregationController@archived_order_aggregations')->name('archived_order_aggregations');

            Route::resource('/cities', 'dashboard\CityController');
            Route::resource('social_settings', 'SettingSocialController');


            Route::resource('/categories', 'dashboard\CategoryController');
            Route::resource('/subcategories', 'dashboard\SubcategoryController');
            Route::resource('/blogs', 'dashboard\BlogController');
            Route::get('/all-suspend-comments', 'dashboard\BlogController@all_suspend_comments')->name('all_suspend_comment');
            Route::post('/all-suspend-comments/{id}', 'dashboard\BlogController@change_status_0f_comment')->name('change_status_0f_comment');

            Route::get('/all-suspend-prices', 'dashboard\AucationController@all_suspend_prices')->name('all_suspend_prices');
            Route::post('/all-suspend-prices/{id}', 'dashboard\AucationController@change_status_0f_prices')->name('change_status_0f_prices');

            Route::resource('/subsubcategories', 'dashboard\SubsubcategoryController');
            Route::post('/subsubcategories.subcategories', 'dashboard\SubsubcategoryController@subcategories')->name('subsubcategories.subcategories');
            Route::post('/subsubcategories-subsubcategories', 'dashboard\SubsubcategoryController@subsubcategories')->name('subsubsubcategories.subsubcategories');



            Route::resource('/products', 'dashboard\ProductController');
            Route::get('/all-suspend-products', 'dashboard\ProductController@all_suspend_products')->name('all_suspend_products');
            Route::get('/all-sold-products', 'dashboard\ProductController@all_sold_products')->name('all_sold_products');
            Route::get('/change-status-of-order/{id}', 'dashboard\ProductController@change_status_of_order')->name('change_status_of_order');

            Route::get('/all-pending-review', 'dashboard\ProductController@all_pending_review')->name('all_pending_review');
            Route::get('/all-archived-review', 'dashboard\ProductController@all_archived_review')->name('all_archived_review');
            Route::post('/all-suspend-review/{id}', 'dashboard\ProductController@change_status_0f_review')->name('change_status_0f_review');

        });
        Route::get('images/{filename?}', 'HomeController@image_show')->name('image_show');
        Route::get('files/{filename?}', 'HomeController@file_show')->name('file_show');



        Auth::routes();
        Route::get('change-currency/{id}', 'UserController@change_currency')->name('change_currency');

        Route::post('find-product/', 'UserController@find_product')->name('find_product');

        Route::post('registeruser', 'UserController@register')->name('register_home');

        Route::get('pending-orders-products', 'UserController@pending_orders_out_products')->name('pending_orders_out_products');
        Route::get('archived-orders-products', 'UserController@archived_orders_out_products')->name('archived_orders_out_products');

        Route::get('register-user', 'UserController@register_user')->name('register_user');
        Route::post('/create-user','UserController@store_user')->name('store_user');

        Route::get('product-details/{id}', 'site\HomeController@product_details')->name('product_details');
        Route::get('cart', 'CartController@cart')->name('cart');

        Route::group(['middleware' => ['auth']], function () {

            Route::get('/checkout', 'CheckoutController@checkout')->name('checkout');
            Route::post('/cash_on_delevery', 'CheckoutController@cash_on_delevery')->name('cash_on_delevery');

            Route::get('user/cart', 'UserController@cart_profile_user')->name('cart_profile_user');
            Route::get('user/favourite', 'UserController@favourite_profile_user')->name('favourite_profile_user');
            Route::PUT('/change-photo','UserController@change_photo')->name('change_photo');
            Route::PUT('/change_details','UserController@change_details')->name('change_details');

            Route::post('/changePassword','UserController@changePassword')->name('changePassword');
            Route::get('profile', 'UserController@profile_user')->name('profile_user');
            Route::post('add_review/{id}', 'UserController@add_review')->name('add_review');

            Route::post('/site/subsubcategories.subcategories', 'site\AucationController@subcategories')->name('site.subsubcategories.subcategories');
            Route::post('/site/subsubcategories-subsubcategories', 'site\AucationController@subsubcategories')->name('site.subsubsubcategories.subsubcategories');

            Route::get('create-product', 'site\CompanyController@create_product')->name('create_product_company');
            Route::post('save-product', 'site\CompanyController@save_product')->name('save_product_company');
            Route::get('all-products', 'site\CompanyController@products')->name('suspend_products');


            Route::get('product-details/{id}/edit', 'site\CompanyController@edit_product')->name('edit_product');
            Route::put('product-details/{id}/save', 'site\CompanyController@save_edit_product')->name('save_edit_product_company');

            Route::post('all-subcategories', 'site\CompanyController@all_subcategories')->name('all_subcategories');


            Route::post('add-to-cart', 'CartController@add_to_cart')->name('add_to_cart');
            Route::post('update-cart/{id}', 'CartController@update_cart')->name('update_cart');
            Route::post('delete-cart/{id}', 'CartController@delete_cart')->name('delete_cart');

            Route::post('create-order', 'CartController@create_order')->name('create_order');


            //payment form

// route for processing payment
Route::post('paypal', 'PaymentController@payWithpaypal')->name('paypal');
Route::get('status', 'PaymentController@getPaymentStatus');

        });
    });
