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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\Admin\EmailSettingController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TodoController;
use App\Http\Controllers\Admin\CommonThingsController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\SwaggerGeneratorController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\Admin\Auth\GoogleController;

use Spatie\Health\Http\Controllers\HealthCheckResultsController;




//Breeze Start
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return redirect('admin/login');
});

Route::get('/user/login', function () {    //temporary
    Auth::loginUsingId(1);
    if(env('USER_ONE_DEVICE_LOGIN'))
    {
        Auth::logoutOtherDevices('password');
    }
    return redirect(url('/'));
});
Route::get('/user/logout', function () {    //temporary
    Auth::logout();
    return redirect(url('/'));
});


require __DIR__.'/auth.php';

//Breeze End





//admin group
Route::prefix('admin')->group(function () {
    Route::controller(AdminLoginController::class)->group(function () {
        Route::get('/login','showLoginForm')->name('admin.login');
        Route::post('/login','login')->name('admin.login.submit');
        Route::get('/','showLoginForm')->name('admin');
        Route::get('/logout','logout')->name('admin.logout.get');    
        Route::post('/logout','logout')->name('admin.logout');    
    });

    Route::controller(AdminForgotPasswordController::class)->group(function () {
        Route::post('/password/email','sendResetLinkEmail')->name('admin.password.email');
        Route::get('/password/reset','showLinkRequestForm')->name('admin.password.request');
    });

    Route::controller(AdminResetPasswordController::class)->group(function () {
        Route::post('/password/reset','reset')->name('admin.password.update');
        Route::get('/password/reset/{token}','showResetForm')->name('admin.password.reset');
    });

    Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('admin.login.google');
    Route::get('callback/google', [GoogleController::class, 'handleGoogleCallback'])->name('admin.callback.google');
});



Route::group(['middleware' => ['auth:admin']], function () {
    Route::get('/language/{locale}', function ($locale) 
    {
        Session::put('locale', $locale);
        return redirect()->back();
    });
});



//admin group, login required
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
 
        Route::post('/broadcasting/auth', [App\Http\Controllers\Admin\BroadcastAuthController::class,'authenticate']);
    
        Route::get('/health', HealthCheckResultsController::class);
    

        Route::controller(ArtisanController::class)->group(function () {
            
            Route::get('/artisan/migrate','artisanMigrate')->name('artisan.migrate');
            Route::get('/artisan/migrate/{file}','artisanMigrateFile')->name('artisan.migrate');
            Route::get('/artisan/migrate-seed','artisanMigrateSeed')->name('artisan.migrate.seed');
            Route::get('/artisan/seed/{class}','seedClass')->name('artisan.seed.class');
            Route::get('/artisan/iseed/{table}','generateSeeder')->name('artisan.iseed.table');
            
            Route::get('/artisan/backup/run','backupRun')->name('artisan.backup.run');
            Route::get('/artisan/backup/clean','backupClean')->name('artisan.backup.clean');
            Route::get('/artisan/backup/list','backupList')->name('artisan.backup.list');
            Route::get('/artisan/backup/monitor','backupMonitor')->name('artisan.backup.monitor');
            Route::get('/artisan/health-check','healthCheck')->name('artisan.health.check');
            

            Route::get('/artisan/storage-link','artisanStorageLink')->name('artisan.storage.link');
            Route::get('/artisan/optimize-clear','artisanOptimizeClear')->name('artisan.optimize.clear');
            Route::get('/artisan/cache-clear','artisanCacheClear')->name('artisan.cache.clear');

            Route::post('/artisan/submit','artisanSubmit')->name('artisan.submit');
        });
    



        Route::controller(SwaggerGeneratorController::class)->group(function () {
            Route::get('/swagger/sync','sync')->name('swagger.sync');
        });
    


    //Language Route
    Route::controller(LangController::class)->group(function () {
        Route::get('/language/{locale?}','change')->name('changeLang');
    });


    Route::resource('roles', RoleController::class);
    
    Route::group(['as' => 'ajax.', 'prefix' => 'ajax'], function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/add-user-role','AddUserRole')->name('add-user-role');
            Route::get('/delete-user-role','DeleteUserRole')->name('delete-user-role');
            Route::post('/update-permissions/{role_id}','UpdatePermissions')->name('update-permissions');
            Route::get('/admins-by-role/{role_id}','AdminsByRole')->name('admins-by-role');
            Route::get('/admins-except-role/{role_id}','AdminsExceptThisRole')->name('admins-except-role');
            Route::get('/permissions-by-role/{role_id}','PermissionsByRole')->name('permissions-by-role');
        });
    });

    Route::resource('admins', AdminController::class);
    Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

    
    //Profile Setting
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile','index');
        Route::post('/profile/update','update')->name('profile.update');
    });



    Route::controller(DashboardController::class)->group(function () {
        Route::get('/dashboard','index')->name('dashboard');
        Route::get('/countries-analytics','countriesAnalytics')->name('countries.analytics');
        Route::get('/top-pages-analytics','topPagesAnalytics')->name('top-pages.analytics');
        Route::get('/visitors-pages-analytics','visitorPagesAnalytics')->name('visitors-pages.analytics');
        Route::get('/top-devicec-analytics','topDeviceAnalytics')->name('visitors-pages.analytics');
    });


    Route::resource('users', UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::get('/user-frontend-login/{user_id?}','userLogin')->name('users.frontend.login');
        Route::get('/users-api/{userId}/login-history','getUserLoginHistory')->name('users-api.login-history');
        Route::post('/users-api/logout-session','logoutFromSpecificSession')->name('users-api.logout.session');
        Route::post('/users-api/logout-all-sessions','logoutFromAllSessions')->name('users-api.logout.all.session');
        Route::get('/import-test','import');

    });



    Route::resource('admin-menus', AdminMenuController::class);
    Route::controller(AdminMenuController::class)->group(function () {
        Route::post('/save-nested-admin-menus','saveNestedMenus')->name('save-nested-admin-menus');
        Route::get('/sync-admin-menu','syncAdminMenu')->name('sync.admin.menu');
    });

    //Activity
    Route::controller(ActivityController::class)->group(function () {
        Route::get('/all-activities','index')->name('all-activities');
    });

    
    
    //todo
    Route::resource('todos', TodoController::class)->only(['store']);    
    Route::controller(TodoController::class)->group(function () {
        Route::post('/todos/toggle','toggle')->name('todos.complete');
        Route::post('/todos/delete','delete')->name('todos.delete');
    });

    Route::resource('settings', SettingController::class);
    Route::controller(SettingController::class)->group(function () {
        Route::put('/policy-settings','policyUpdate')->name('policy.settings.update');
        Route::put('/company-info-settings','companyInfoUpdate')->name('company.info.settings.update');
        Route::put('/theme-settings','themeUpdate')->name('theme.settings.update');
    });

    Route::resource('website-settings', WebsiteSettingController::class);
    Route::controller(WebsiteSettingController::class)->group(function () {
        Route::put('/website-policy-settings','policyUpdate')->name('website-policy.settings.update');
        Route::put('/website-theme-settings','themeUpdate')->name('website-theme.settings.update');
    });


    Route::resource('email-settings', EmailSettingController::class)->only(['index', 'store']);
    Route::controller(EmailSettingController::class)->group(function () {
        Route::get('/email-setting-ajax-data','ajaxFilter');
        Route::post('/email-send','emailSend')->name('email.send');
    });

    Route::resource('file-managers', FileManagerController::class);
    Route::controller(FileManagerController::class)->group(function () {
        Route::post('/file-upload/{id}','fileUpload')->name('file-upload');
        Route::get('/share-uploads/{id}','share');
    });

    //status route
    Route::controller(CommonThingsController::class)->group(function () {
        Route::post('/toggle/switch/status','toggleSwitchStatus')->name('toggle.switch.status');
    });

    Route::resource('blog-categories', \App\Http\Controllers\Admin\BlogCategoryController::class);
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class);
    Route::resource('blog-comments', \App\Http\Controllers\Admin\BlogCommentController::class);
    Route::resource('media-library', \App\Http\Controllers\Admin\MediaLibraryController::class);
    

    Route::get('create-token/{user_id}',function($user_id) {

        $user=\App\Models\User::find($user_id);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    });
    Route::get('test-pusher/{user_id}',function($user_id) {

        pushAdminNotify($user_id);
    });

});








