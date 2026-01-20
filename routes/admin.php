<?php

use Illuminate\Support\Facades\Route;
use UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'prefix' => 'admin/server',
    'as'=>'admin::server.',
    'middleware'=>['AdminAuthCheck','can:settings'],
],function (){

    Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs');
    Route::get('info', [\App\Http\Controllers\Admin\ServerController::class, 'InfoPage'])->name('info');

});


Route::group([
    'namespace'=>'App\Http\Controllers\Admin',
    'prefix'=>'admin',
    'as'=>'admin::'
],function (){

    Route::middleware('AdminAuthRedirect')->group(function (){

        Route::get('/','AuthController@LoginPage');
        Route::get('login','AuthController@LoginPage')->name('login');
        Route::post('login','AuthController@Login')->name('login.submit');

    });

    Route::middleware('AdminAuthCheck')->group(function (){

        Route::get('boost-up','DashboardController@BoostUp')->name('boost-up');
        Route::get('logout','AuthController@Logout')->name('logout');

    });


});

/*
|--------------------------------------------------------------------------
| Livewire Routes
|--------------------------------------------------------------------------
*/

Route::group([
    'namespace'=>'App\Livewire\Admin',
    'prefix'=>'admin',
    'as'=>'admin::',
    'middleware' => 'AdminAuthCheck'
],function (){

    Route::get('dashboard','Dashboard\MainDashboardPage')->name('dashboard');

    Route::get('profile','Profile\ProfilePage')->name('profile');

    /* Setting Routes */
    Route::group(['namespace' => 'Setting','prefix' => 'settings','as'=>'settings:','middleware' => 'can:settings'],function (){

        Route::get('website','WebsiteSettingPage')->name('website');
        Route::get('general','GeneralSettingPage')->name('general');
        Route::get('mail','MailSettingPage')->name('mail');
        Route::get('payment','PaymentSettingPage')->name('payment');

        Route::group(['prefix' => 'scripts','as'=>'scripts.'],function (){

            Route::get('third-party','ThirdPartyScriptPage')->name('third-party');
            Route::get('custom','CustomScriptPage')->name('custom');

        });
    });

    /* Users Routes */
    Route::group(['namespace' => 'Users','prefix' => 'users','as'=>'users:','middleware' => 'can:settings'],function (){

        Route::get('list','UsersListPage')->name('list');
        Route::get('list/add','UsersAddEditPage')->name('add');
        Route::get('list/edit/{user_id}','UsersAddEditPage')->name('edit');

        Route::get('admin/list','AdminsListPage')->name('admin.list');
        Route::get('admin/add','AdminAddEditPage')->name('admin.add');
        Route::get('admin/edit/{user_id}','AdminAddEditPage')->name('admin.edit');
        Route::get('admin/manage/{user_id}','RolesAssignPage')->name('admin.manage');

        Route::get('admin/roles','AdminRolePage')->name('admin.roles');

    });

    /* Grouping Routes */
    Route::group(['namespace' => 'Grouping','prefix' => 'grouping','as'=>'grouping:','middleware' => 'can:settings'],function (){

        Route::group(['namespace' => 'Address','as'=>'address.'],function (){

            Route::get('countries','CountryListPage')->name('countries');
            Route::get('states','StateListPage')->name('states');
            Route::get('cities','CityListPage')->name('cities');

        });

    });

    /* Blog Routes */
    Route::group(['namespace' => 'Blog','prefix' => 'blog','as'=>'blog:'],function (){

        Route::get('posts','PostListPage')->name('posts');
        Route::get('post/add','PostAddEditPage')->name('posts.add');
        Route::get('posts/edit/{post_id}','PostAddEditPage')->name('posts.edit');

    });

    /* Blog Category Routes */
    Route::group(['namespace' => 'Blog','prefix' => 'blog-category','as'=>'blog:'],function (){

        Route::get('categories','CategoryPage')->name('category');
        Route::get('category/add','CategoryAddEditPage')->name('category.add');
        Route::get('categories/edit/{category_id}','CategoryAddEditPage')->name('category.edit');

    });

    /* Blog Tags Routes */
    Route::group(['namespace' => 'Blog','prefix' => 'blog-tags','as'=>'blog:'],function (){

        Route::get('tags','TagPage')->name('tags');

    });

    /* Posts Collection Routes */
    Route::group(['namespace' => 'Blog\Collection','prefix' => 'post-collection','as'=>'post-collection:'],function (){

        Route::get('list','PostCollectionListPage')->name('list');
        Route::get('add','PostCollectionAddEditPage')->name('add');
        Route::get('edit/{collection_id}','PostCollectionAddEditPage')->name('edit');
        Route::get('ordering','PostCollectionOrderPage')->name('ordering');

    });

    /* AdsSpace Routes */
    Route::group(['namespace' => 'AdsSpace','prefix' => 'ads-space','as'=>'ads:'],function (){

        Route::get('list','AdsListPage')->name('list');
        Route::get('add','AdsAddEditPage')->name('add');
        Route::get('edit/{ads_id}','AdsAddEditPage')->name('edit');

    });

    /* Blog Routes */
    Route::group(['namespace' => 'Themes','prefix' => 'theme','as'=>'theme:','middleware' => 'can:settings'],function (){

        Route::get('pages/list','PagesListPage')->name('pages.list');
        Route::get('pages/add','PagesAddEditPage')->name('pages.add');
        Route::get('pages/edit/{page_id}','PagesAddEditPage')->name('pages.edit');

    });

    /* Other Routes */

    Route::group(['middleware' => 'can:support::mail'],function (){

        Route::get('subscribers','Support\SubscribersListPage')->name('subscribers');
        Route::get('contact/mails','Other\ContactMailPage')->name('contact.mails');

    });

    /* Insurance Claim Routes */
    Route::group(['namespace' => 'InsuranceClaim','prefix' => 'insurance-claim','as'=>'insurance-claim:'],function (){

        // Route::get('manage','InsuranceClaimListPage')->name('manage')->middleware('can:claim::list');
        Route::get('list','InsuranceClaimManagePage')->name('list')->middleware('can:claim::list');
        Route::get('add','InsuranceClaimAddEditPage')->name('add')->middleware('can:claim::add');
        Route::get('edit/{claim_id}','InsuranceClaimAddEditPage')->name('edit')->middleware('can:claim::update');
        Route::get('view/{claim_id}','ClaimViewPage')->name('view')->middleware('can:claim::update');

    });

    Route::get('insurance-claim-import','InsuranceClaim\ClaimImportPage')
        ->name('insurance-claim:import')
        ->middleware('can:claim::import');

    /* Insurance Grouping Routes */
    Route::group(['namespace' => 'Insurance','prefix' => 'insurance-grouping','as'=>'insurance-grouping:','middleware' => 'can:claim::grouping'],function (){

        Route::get('status/list','StatusListPage')->name('status.list');
        Route::get('status/add','StatusAddEditPage')->name('status.add');
        Route::get('status/edit/{status_id}','StatusAddEditPage')->name('status.edit');
        Route::get('status/questions/{status_id}','StatusQuestionPage')->name('status.questions');

        Route::get('follow-up','FollowUpPage')->name('follow-up');
        Route::get('worked-by','WorkedByPage')->name('worked-by');
        Route::get('eob-dl','EobDlPage')->name('eob-dl');
        Route::get('tlf-excluded','TlfExcludedPage')->name('tlf-excluded');
        Route::get('tasks','TaskListPage')->name('tasks');

    });

    /* Customers Routes */
    Route::group(['namespace' => 'Customers','prefix' => 'customers','as'=>'customers:'],function (){

        Route::get('list','CustomersListPage')->name('list')->middleware('can:client::list');
        Route::get('add','CustomersAddEditPage')->name('add')->middleware('can:client::add');
        Route::get('edit/{customer_id}','CustomersAddEditPage')->name('edit')->middleware('can:client::update');
        Route::get('view/{customer_id}','CustomersViewPage')->name('view')->middleware('can:client::view');

    });

    /* Analytics Routes */
    Route::group(['namespace' => 'Analytics','prefix' => 'analytics','as'=>'analytics:'],function (){

        Route::get('main','MainAnalyticsPage')->name('main')->middleware('can:charts::access');

    });

    /* Tasks Routes */
    Route::group([
        'namespace' => 'Tasks',
        'prefix' => 'customers/tasks',
        'as'=>'tasks:',
        'middleware' => ['can:tasks::access']
    ],function (){

//        Route::get('list','TasksMainPage')
//            ->name('list');

//        Route::get('category/sort','ProjectCategorySortOrderPage')
//            ->name('category.sort');

        Route::get('project/{client_id}','ProjectDetailPage')
            ->name('project.detail');
    });
});


Route::group(['prefix' => 'admin/file-manager', 'middleware' => ['AdminAuthCheck']], function () {
      Lfm::routes();
});

Route::group([
    'namespace' =>'App\Http\Controllers\Admin\Api',
    'prefix' => 'api/admin',
    'as'=>'admin::api.',
    'middleware' => 'ApiAdminAuthCheck'
    ],function (){

    Route::post('upload','FileUploadController@UploadFile')->name('upload');
    Route::post('revert','FileUploadController@RevertFile')->name('revert');

});

