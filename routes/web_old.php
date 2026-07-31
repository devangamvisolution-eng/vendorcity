<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\Ckeditoruploadcontroller;
use App\Http\Controllers\admin\UserPermissionController;
use App\Http\Controllers\admin\DriverController;
use App\Http\Controllers\Auth\VendorAuthController;
use App\Http\Controllers\admin\Admin_userController;
use App\Http\Controllers\admin\ContinentController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\GooglereviewController;
use App\Http\Controllers\admin\StateController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\SubserviceController;
use App\Http\Controllers\admin\CleanersController;
use App\Http\Controllers\admin\VendorsController;
use App\Http\Controllers\admin\CoupanController;
use App\Http\Controllers\admin\Calendarcontroller;
use App\Http\Controllers\admin\ERP_EnquiryController;

use App\Http\Controllers\admin\VendorsProfileController;

use App\Http\Controllers\admin\Pricecontroller;
use App\Http\Controllers\admin\SubscriptionController;
use App\Http\Controllers\admin\Subscriptiondetails_controller;
use App\Http\Controllers\admin\Leadscontroller;
use App\Http\Controllers\admin\AcceptLeadscontroller;
use App\Http\Controllers\admin\RejectLeadscontroller;
use App\Http\Controllers\admin\PaintingLeadscontroller;
use App\Http\Controllers\admin\GardenEnquirycontroller;
use App\Http\Controllers\admin\Vendorinquirycontroller;
use App\Http\Controllers\admin\CmsController;
use App\Http\Controllers\admin\PackageCategoryController;
use App\Http\Controllers\admin\PackagesController;
use App\Http\Controllers\admin\VerifyBuyPackageController;
use App\Http\Controllers\admin\VehicleController;
use App\Http\Controllers\admin\ModelController;
use App\Http\Controllers\admin\WalletController;
use App\Http\Controllers\admin\AdminWalletController;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\HelpController;
use App\Http\Controllers\admin\FrontuserController;
use App\Http\Controllers\admin\EnquiryController;

use App\Http\Controllers\admin\Form_fieldController;
use App\Http\Controllers\admin\Ordercontroller;
use App\Http\Controllers\admin\VendorOrderController;
use App\Http\Controllers\admin\SubscribeController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\Blog_categoryController;
use App\Http\Controllers\admin\SalesReportController;
use App\Http\Controllers\admin\DayReportController;
use App\Http\Controllers\admin\SystemController;
use App\Http\Controllers\admin\Cleaning_PriceController;
use App\Http\Controllers\admin\Time_Slot_PriceController;
use App\Http\Controllers\admin\AdminpassController;
use App\Http\Controllers\admin\AdminacceptLeadscontroller;
use App\Http\Controllers\admin\PaintingPriceController;
use App\Http\Controllers\admin\WoodenFloorLeadsController;
use App\Http\Controllers\admin\EnquiryUsersController;
use App\Http\Controllers\admin\GardenAcceptLeadsController;
use App\Http\Controllers\admin\vendorsubscriptionreport;
use App\Http\Controllers\admin\ErpSurveycontroller;
use App\Http\Controllers\admin\ErpQuotecontroller;
use App\Http\Controllers\admin\ErpAcceptedquotecontroller;
use App\Http\Controllers\admin\ErpRejectedquotecontroller;
use App\Http\Controllers\admin\Vendorquotecontroller;
use App\Http\Controllers\admin\Vendorbookedtimeslotcontroller;
use App\Http\Controllers\admin\Addonscontroller;
use App\Http\Controllers\admin\Erpdescriptionofgoods;
use App\Http\Controllers\admin\EvcharginginstallationLeads;
use App\Http\Controllers\admin\GoogleCalendarController;




use App\Http\Controllers\front\FrontloginregisterController;
use App\Http\Controllers\front\FrontvendorController;
use App\Http\Controllers\front\checkoutcontroller;
use App\Http\Controllers\front\Packagecontroller;
use App\Http\Controllers\front\Automobilecontroller;
use App\Http\Controllers\front\MyaccountController;
use App\Http\Controllers\front\Homecontroller as Fronthomecontroller;

use App\Http\Controllers\front\PaymentfrontController;
use App\Http\Controllers\front\TabbyController;
use App\Http\Controllers\front\Croncontroller;
use App\Http\Controllers\admin\Salespersonreportcontroller;





// Route::get('/', function () {
//     return view('welcome');
// });

//Clear config cache:
Route::get('/config-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    return 'Config cache cleared';
});

Route::get('/run-all-jobs', function () {

    set_time_limit(0);

    Artisan::call('queue:work', [
        '--stop-when-empty' => true,
    ]);

    return 'All jobs completed';
});

// Clear application cache:
// Route::get('/clear-cache', function() {
//     $exitCode = Artisan::call('cache:clear');
//     return 'Application cache cleared';
// });
// // Clear view cache:
// Route::get('/view-clear', function() {
//     $exitCode = Artisan::call('view:clear');
//     return 'View cache cleared';
// });
//  Route::get('/optimize-clear', function() {
//     $exitCode = Artisan::call('optimize:clear');
//     return 'Application cache cleared successfully';
// });



//Route::get('/edit-profile', '\App\Http\Controllers\front\MyaccountController@edit_profile');

// Route::get('/checkout', '\App\Http\Controllers\front\checkoutcontroller@checkout');
// Route::post('/order_place', '\App\Http\Controllers\front\checkoutcontroller@order_place')->name('order_place');
// Route::get('thankyou', [checkoutcontroller::class, 'thankyou'])->name("thankyou");



// Route::match(['get', 'post'], 'vendor-database', [FrontvendorController::class, 'vendor_database'])->name('vendor_database');


/*------End Front routes  ------*/
Route::post('/order-add-tip', [MyaccountController::class, 'order_add_tip'])->name('order-add-tip');
Route::get('/tip-success/{id}', [MyaccountController::class, 'tip_payment_success']);
Route::get('/tip-cancel/{id}', [MyaccountController::class, 'tip_payment_cancel']);
/*------vendors routes start ------*/




Route::get('/vendor/dashboard', function () {
    if (Auth::user()->role_id == 1) {
        return view('admin.dashboard');
    } else {
        return view('admin.vendorsdashboard');
    }
})->middleware(['auth', 'verified'])->name('vendor.dashboard');


Route::prefix('admin')->middleware(['auth', 'verified'])->group(function () {


    Route::get('/', function () {
        // Only admin role_id == 1 can see admin dashboard
        if (Auth::user()->role_id == 1) {
            return view('admin.dashboard');
        }
        return redirect()->route('vendor.dashboard');
    })->name('admin.dashboard');

    Route::get('/dashboard', function () {
        if (Auth::user()->role_id == 1) {
            return view('admin.dashboard');
        }
        return redirect()->route('vendor.dashboard');
    })->name('admin.dashboard.alt');
});

// Route::get('/admin', function () {
//         if (Auth::user()->role_id == 1) {
//             return view('admin.dashboard');
//         } else {
//             return view('admin.vendorsdashboard');
//         }
// })->middleware(['auth', 'verified'])->name('admin.dashboard');


Route::prefix('vendor')->group(function () {
    Route::get('/login', [VendorAuthController::class, 'showLoginForm'])->name('vendor.login');
    Route::post('/login', [VendorAuthController::class, 'login']);
    Route::post('/logout', [VendorAuthController::class, 'logout'])->name('vendor.logout');

    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.vendorsdashboard');
        })->name('vendor.dashboard');
    });
});

Route::get('/dashboard', '\App\Http\Controllers\admin\HomeController@redirectToDashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
// Route::get('/vendor', function () {

//     echo "Welcome Vendor";exit;
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified'])->name('vendor.dashboard');



// Route::middleware(['auth', 'verified'])->group(function () {

//     echo "Welcome vendor";exit;
//     Route::get('/vendor', 'VendorController@index')->name('vendor.dashboard');
//     // Define other vendor-specific routes here
// });





/*------vendors Front routes  ------*/


Route::post('/ckeditor/upload', [Ckeditoruploadcontroller::class, 'upload'])->name('ckeditor.upload');

Route::prefix('admin')->middleware(['auth'])->group(function () {

    Route::get('/google-auth', [GoogleCalendarController::class, 'auth'])
        ->name('admin.google.auth');

    Route::get('/google-callback', [GoogleCalendarController::class, 'callback'])
        ->name('admin.google.callback');

    Route::post('/calendar-sync', [GoogleCalendarController::class, 'sync'])
        ->name('admin.calendar.sync');
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/download-document/{id}', [ProfileController::class, 'company_document_download'])->name('profile.document_download');
    Route::post('/profile/driver-document', [ProfileController::class, 'driver_document_download'])->name('profile.driver_document_download');
    Route::post('/profile/packer-document', [ProfileController::class, 'packer_document_download'])->name('profile.packer_document_download');
    Route::post('/profile/office-staff-document', [ProfileController::class, 'office_staff_document_download'])->name('profile.office_staff_document_download');



    Route::resource('/admin/permission', '\App\Http\Controllers\admin\PermissionController');
    Route::resource('/admin/calendar', '\App\Http\Controllers\admin\Calendarcontroller');

    Route::controller(Calendarcontroller::class)->prefix('vendor')->middleware('auth')->group(function () {

        Route::get('/calendar', 'index')->name('vendor.calander_lists');
    });

    Route::resource('/admin/userpermission', '\App\Http\Controllers\admin\UserPermissionController');
    Route::get('delete_permission', [UserPermissionController::class, 'delete_permission'])->name('delete_permission');
    Route::get('destroyPermission', [UserPermissionController::class, 'destroyPermission'])->name('destroyPermission');

    Route::resource('/admin/adminuser', '\App\Http\Controllers\admin\Admin_userController');
    Route::get('/admin/delete_admin', [Admin_userController::class, 'destroy'])->name('delete_admin');
    Route::post('change_status_adminuser', 'App\Http\Controllers\admin\Admin_userController@change_status_adminuser');

    Route::resource('admin/driver', DriverController::class);
    Route::get('delete-driver', [DriverController::class, 'destroy'])->name('delete-driver');

    Route::resource('admin/continent', 'App\Http\Controllers\admin\ContinentController');
    Route::get('delete_continent', [ContinentController::class, 'destroy'])->name('delete_continent');

    Route::resource('admin/country', 'App\Http\Controllers\admin\CountryController');
    Route::get('delete_country', [CountryController::class, 'destroy'])->name('delete_country');
    // Route::post('admin/upload', [CountryController::class, 'xlsupload'])->name('country.upload');
    Route::match(['get', 'post'], 'upload_country', [CountryController::class, 'xlsupload'])->name('upload_country');

    Route::resource('admin/state', 'App\Http\Controllers\admin\StateController');
    Route::get('delete_state', [StateController::class, 'destroy'])->name('delete_state');
    Route::match(['get', 'post'], 'upload_state', [StateController::class, 'xlsupload'])->name('upload_state');

    Route::resource('admin/city', 'App\Http\Controllers\admin\CityController');
    Route::get('/admin/delete_city', [CityController::class, 'destroy'])->name('delete_city');
    Route::post('state_show', 'App\Http\Controllers\admin\CityController@state_show');
    Route::get('/admin/bulk_upload_city', [CityController::class, 'bulk_upload_city'])->name('bulk_upload_city');
    Route::post('/admin/bulk_upload_city', [CityController::class, 'bulk_upload_city'])->name('bulk_upload_city');


    Route::match(['get', 'post'], 'upload_city', [CityController::class, 'xlsupload'])->name('upload_city');




    Route::resource('admin/service', 'App\Http\Controllers\admin\ServiceController');
    Route::get('delete_service', [ServiceController::class, 'destroy'])->name('delete_service');
    Route::post('set_order_service', '\App\Http\Controllers\admin\ServiceController@set_order_service');
    Route::get('removed_banner_addmore_att/{pid}/{id}', [ServiceController::class, 'removed_banner_addmore_att'])->name('removed_banner_addmore_att');
    Route::get('removed_service_addmore_att/{pid}/{id}', [ServiceController::class, 'removed_service_addmore_att'])->name('removed_service_addmore_att');
    Route::get('removed_service_contain_att/{pid}/{id}', [ServiceController::class, 'removed_service_contain_att'])->name('removed_service_contain_att');
    Route::post('change_status_service', 'App\Http\Controllers\admin\ServiceController@change_status_service');
    Route::post('city_show_new', 'App\Http\Controllers\admin\ServiceController@city_show_new');

    Route::get('service_removed_top_descatt/{pid}/{id}', [ServiceController::class, 'service_removed_top_descatt'])->name('service_removed_top_descatt');


    Route::resource('admin/subservice', 'App\Http\Controllers\admin\SubserviceController');
    Route::get('delete_subservice', [SubserviceController::class, 'destroy'])->name('delete_subservice');
    Route::post('set_order_subservice', '\App\Http\Controllers\admin\SubserviceController@set_order_subservice');
    Route::get('removed_subservice_banner_addmore_att/{pid}/{id}', [SubserviceController::class, 'removed_subservice_banner_addmore_att'])->name('removed_subservice_banner_addmore_att');
    Route::get('removed_subservice_contain_att/{pid}/{id}', [SubserviceController::class, 'removed_subservice_contain_att'])->name('removed_subservice_contain_att');
    Route::get('removed_addmore_att/{pid}/{id}', [SubserviceController::class, 'removed_addmore_att'])->name('removed_addmore_att');
    Route::get('removed_why_choose_att/{pid}/{id}', [SubserviceController::class, 'removed_why_choose_att'])->name('removed_why_choose_att');
    Route::get('removed_description_att/{pid}/{id}', [SubserviceController::class, 'removed_description_att'])->name('removed_description_att');
    Route::get('removed_more_service_att/{pid}/{id}', [SubserviceController::class, 'removed_more_service_att'])->name('removed_more_service_att');
    Route::get('removed_what_else_att/{pid}/{id}', [SubserviceController::class, 'removed_what_else_att'])->name('removed_what_else_att');
    Route::post('change_status_subservice', 'App\Http\Controllers\admin\SubserviceController@change_status_subservice');
    Route::get('subservice_removed_top_descatt/{pid}/{id}', [SubserviceController::class, 'subservice_removed_top_descatt'])->name('subservice_removed_top_descatt');

    Route::resource('admin/cleaners', 'App\Http\Controllers\admin\CleanersController');
    Route::get('delete-cleaners', [CleanersController::class, 'destroy'])->name('delete-cleaners');
    Route::post('cleaners-subservice-show', '\App\Http\Controllers\admin\CleanersController@cleaners_subservice_show');
    Route::post('cleaners-state-show', '\App\Http\Controllers\admin\CleanersController@cleaners_state_show');
    Route::post('cleaners-city-show', '\App\Http\Controllers\admin\CleanersController@cleaners_city_show');

    Route::resource('admin/coupan', 'App\Http\Controllers\admin\CoupanController');
    Route::get('delete-coupan', [CoupanController::class, 'destroy'])->name('delete-coupan');
    Route::post('change_status_coupan', 'App\Http\Controllers\admin\CoupanController@change_status_coupan');
    Route::post('coupan_subservice_change', 'App\Http\Controllers\admin\CoupanController@coupan_subservice_change');



    Route::resource('admin/vendors', 'App\Http\Controllers\admin\VendorsController');
    Route::get('delete_vendors', [VendorsController::class, 'destroy'])->name('delete_vendors');
    Route::get('remove_vendors_att/{pid}/{id}', [VendorsController::class, 'remove_vendors_att'])->name('remove_vendors_att');
    Route::post('change_status_vendors', 'App\Http\Controllers\admin\VendorsController@change_status_vendors');
    Route::post('excel_download_vendors', '\App\Http\Controllers\admin\VendorsController@excel_download_vendors');
    Route::match(['get', 'post'], 'edit_subscription/{id}', [VendorsController::class, 'edit_subscription'])->name('edit_subscription');

    Route::match(['get', 'post'], 'edit_international_subscription/{id}', [VendorsController::class, 'edit_international_subscription'])->name('edit_international_subscription');

    Route::match(['get', 'post'], 'copy_package_subscription/{id}', [VendorsController::class, 'copy_package_subscription'])->name('copy_package_subscription');


    Route::get('admin/vendors/{id}/subscription', 'App\Http\Controllers\admin\VendorsController@subscription')->name('vendors.subscription');


    // routes/web.php
    route::get('/vendor-login/{id}', [VendorsController::class, 'vendor_login'])->name('vendor_login');

    Route::resource('/vendor/vendorsprofile', 'App\Http\Controllers\admin\VendorsProfileController');
    Route::get('remove_vendorsprofile_att/{pid}/{id}', [VendorsProfileController::class, 'remove_vendorsprofile_att'])->name('remove_vendorsprofile_att');


    Route::resource('admin/price', 'App\Http\Controllers\admin\Pricecontroller');
    Route::get('delete_price', [Pricecontroller::class, 'destroy'])->name('delete_price');

    Route::resource('admin/subscription', 'App\Http\Controllers\admin\SubscriptionController');

    Route::get('/delete-subscription', [SubscriptionController::class, 'destroy'])->name('delete_subscription');


    // Route::get('base_on_service_lead',[SubscriptionController::class,'base_on_service_lead'])->name('base_on_service_lead');

    // Route::get('based_on_booking_services',[SubscriptionController::class,'based_on_booking_services'])->name('based_on_booking_services');
    // Route::get('based_on_listing_criteria',[SubscriptionController::class,'based_on_listing_criteria'])->name('based_on_listing_criteria');

    Route::post('session_subs_price_change', 'App\Http\Controllers\admin\SubscriptionController@session_subs_price_change');
    Route::post('state_show_subscription', 'App\Http\Controllers\admin\SubscriptionController@state_show_subscription');
    Route::post('to_country_show_subscription', 'App\Http\Controllers\admin\SubscriptionController@to_country_show_subscription');
    Route::post('city_show', 'App\Http\Controllers\admin\SubscriptionController@city_show');
    Route::post('subservice_change', 'App\Http\Controllers\admin\SubscriptionController@subservice_change');
    Route::post('subservice_table_change', 'App\Http\Controllers\admin\SubscriptionController@subservice_table_change');

    Route::post('subscription_replace', 'App\Http\Controllers\admin\SubscriptionController@subscription_replace');


    Route::match(['get', 'post'], 'base_on_service_lead/{id}', [SubscriptionController::class, 'base_on_service_lead'])->name('base_on_service_lead');
    Route::match(['get', 'post'], 'based_on_booking_services/{id}', [SubscriptionController::class, 'based_on_booking_services'])->name('based_on_booking_services');
    Route::match(['get', 'post'], 'based_on_listing_criteria/{id}', [SubscriptionController::class, 'based_on_listing_criteria'])->name('based_on_listing_criteria');

    Route::match(['get', 'post'], 'international-package/{id}', [SubscriptionController::class, 'international_package'])->name('international-package');

    Route::post('chnage_moving_price', 'App\Http\Controllers\admin\SubscriptionController@chnage_moving_price');
    Route::post('chnage_moving_price_for_int', 'App\Http\Controllers\admin\SubscriptionController@chnage_moving_price_for_int');

    // Route::post('base_on_service_lead',[SubscriptionController::class,'base_on_service_lead'])->name('base_on_service_lead');
    // Route::post('based_on_booking_services',[SubscriptionController::class,'based_on_booking_services'])->name('based_on_booking_services');
    // Route::post('based_on_listing_criteria',[SubscriptionController::class,'based_on_listing_criteria'])->name('based_on_listing_criteria');

    Route::resource('vendor/subscription-details', 'App\Http\Controllers\admin\Subscriptiondetails_controller');

    Route::post('vendor_check_mail', 'App\Http\Controllers\admin\VendorsController@vendor_check_mail');
    Route::post('vendor_edit_check_mail', 'App\Http\Controllers\admin\VendorsController@vendor_edit_check_mail');

    Route::get('admin/vendor-invoice/{id}', 'App\Http\Controllers\admin\Subscriptiondetails_controller@vendor_invoice')->name('vendor-invoice');

    Route::resource('admin/leads', 'App\Http\Controllers\admin\Leadscontroller');
    Route::resource('vendor/acceptleads', 'App\Http\Controllers\admin\AcceptLeadscontroller');
    Route::resource('vendor/rejectleads', 'App\Http\Controllers\admin\RejectLeadscontroller');
    Route::resource('vendor/painting-inquiry', 'App\Http\Controllers\admin\PaintingLeadscontroller');
    Route::resource('vendor/vendorinquiry', 'App\Http\Controllers\admin\Vendorinquirycontroller');
    Route::match(['get', 'post'], '/vendor-enquiry-filter', 'App\Http\Controllers\admin\Vendorinquirycontroller@index')->name('vendor-enquiry-filter');
    Route::get('accept_vendor_inquiry', 'App\Http\Controllers\admin\Vendorinquirycontroller@accept_vendor_inquiry')->name('accept_vendor_inquiry');

    Route::match(['get', 'post'], 'accept_vendor_inquiry/{vendors_id}/{inquiry_id}', 'App\Http\Controllers\admin\Vendorinquirycontroller@accepted_vendor_inquiry')->name('accept_vendor_inquiryy');

    Route::match(['get', 'post'], 'garden_accept_vendor_inquiry', 'App\Http\Controllers\admin\Vendorinquirycontroller@garden_accept_vendor_inquiry')->name('garden_accept_vendor_inquiry');

    Route::get('enquiry_detail/{enquiry_id}', [Vendorinquirycontroller::class, 'enquiry_details'])->name('enquiry_detail');
    Route::get('painting-enquiry-detail/{enquiry_id}', [Vendorinquirycontroller::class, 'painting_enquiry_detail'])->name('painting-enquiry-detail');

    Route::get('/accpet_form/{package_inquiry_id}/{user_id}', [Vendorinquirycontroller::class, 'accpet_form'])->name('accpet_form');
    Route::get('/garden_accpet_form/{package_inquiry_id}/{user_id}', [Vendorinquirycontroller::class, 'garden_accpet_form'])->name('garden_accpet_form');


    Route::get('accept_lead_form', 'App\Http\Controllers\admin\Vendorinquirycontroller@accept_lead_form')->name('accept_lead_form');
    Route::get('accept_lead_form_new', 'App\Http\Controllers\admin\Vendorinquirycontroller@accept_lead_form_new')->name('accept_lead_form_new');
    Route::get('garden_accept_lead_form', 'App\Http\Controllers\admin\Vendorinquirycontroller@garden_accept_lead_form')->name('garden_accept_lead_form');



    Route::post('reason_reject_form', 'App\Http\Controllers\admin\Vendorinquirycontroller@add_reject_reason')->name('reason_reject_form');
    Route::post('garden_reason_reject_form', 'App\Http\Controllers\admin\Vendorinquirycontroller@add_garden_reject_reason')->name('garden_reason_reject_form');
    Route::get('enquiry_details/{enquiry_id}', [Vendorinquirycontroller::class, 'enquiry_detailss'])->name('enquiry_details');





    Route::resource('admin/cms', 'App\Http\Controllers\admin\CmsController');
    Route::get('delete_cms', [CmsController::class, 'destroy'])->name('delete_cms');

    Route::resource('admin/packagecategory', '\App\Http\Controllers\admin\PackageCategoryController');
    Route::post('subservice_show', 'App\Http\Controllers\admin\PackageCategoryController@subservice_show');
    Route::get('delete_packagecategory', [PackageCategoryController::class, 'destroy'])->name('delete_packagecategory');
    Route::post('admin/packagecategory/change_status', [PackageCategoryController::class, 'change_status'])->name('packagecategory.change_status');
    Route::post('admin/packagecategory/set_order', [PackageCategoryController::class, 'set_order'])->name('packagecategory.set_order');


    Route::resource('admin/packages', '\App\Http\Controllers\admin\PackagesController');
    Route::post('subservice_show', 'App\Http\Controllers\admin\PackagesController@subservice_show');
    Route::post('packagecategory_show', 'App\Http\Controllers\admin\PackagesController@packagecategory_show');
    Route::get('delete_packages', [PackagesController::class, 'destroy'])->name('delete_packages');
    Route::get('editimage/{id}', [PackagesController::class, 'editimage'])->name('editimage');
    Route::post('editimage_store', [PackagesController::class, 'editimage_store'])->name('editimage_store');
    Route::get('packages_removeimage/{pid}/{id}', [PackagesController::class, 'packages_removeimage'])->name('packages_removeimage');
    Route::post('set_order_packages', '\App\Http\Controllers\admin\PackagesController@set_order_packages');
    Route::post('admin/packages/change_status', [PackagesController::class, 'change_status'])->name('packages.change_status');

    Route::resource('admin/verifybuy-packages', '\App\Http\Controllers\admin\VerifyBuyPackageController');
    // Route::post('subservice_show', 'App\Http\Controllers\admin\VerifyBuyPackageController@subservice_show');
    // Route::post('packagecategory_show', 'App\Http\Controllers\admin\VerifyBuyPackageController@packagecategory_show');
    Route::get('delete_verifybuy_package', [VerifyBuyPackageController::class, 'destroy'])->name('delete_verifybuy_package');
    // Route::get('editimage/{id}', [VerifyBuyPackageController::class, 'editimage'])->name('editimage');
    // Route::post('editimage_store', [VerifyBuyPackageController::class, 'editimage_store'])->name('editimage_store');
    Route::get('remove_inspection_package_attr/{pid}/{id}', [VerifyBuyPackageController::class, 'remove_attr'])->name('remove_inspection_package_attr');
    Route::post('change_status_inspection_packages', '\App\Http\Controllers\admin\VerifyBuyPackageController@change_status_inspection_packages');

    Route::resource('admin/vehicle', '\App\Http\Controllers\admin\VehicleController');
    Route::post('change_status_vehicle', 'App\Http\Controllers\admin\VehicleController@change_status_vehicle');
    Route::get('delete_vehicle', [VehicleController::class, 'destroy'])->name('delete_vehicle');

    Route::resource('admin/model', '\App\Http\Controllers\admin\ModelController');
    Route::get('delete_model', [ModelController::class, 'destroy'])->name('delete_model');

    Route::resource('vendor/wallet', '\App\Http\Controllers\admin\WalletController');

    Route::get('/paymentSuccess', '\App\Http\Controllers\admin\WalletController@paymentSuccess')->name('paymentSuccess');
    Route::get('/paymentFail', '\App\Http\Controllers\admin\WalletController@paymentFail')->name('paymentFail');

    Route::post('ckeditor/upload', [PackagesController::class, 'upload'])->name('ckeditor.upload');
    Route::get('remove_addmore_att/{pid}/{id}', [PackagesController::class, 'remove_addmore_att'])->name('remove_addmore_att');

    Route::resource('admin/adminwallet', '\App\Http\Controllers\admin\AdminWalletController');
    Route::post('admin_wallet_filter', 'App\Http\Controllers\admin\AdminWalletController@index')->name('admin_wallet_filter');
    Route::get('filter_data_adminwallet', '\App\Http\Controllers\admin\AdminWalletController@filter_data_adminwallet');
    Route::get('vendors_wallet/{vendors_id}', [AdminWalletController::class, 'vendors_wallet'])->name('vendors_wallet');
    Route::post('change_status_wallet', 'App\Http\Controllers\admin\AdminWalletController@change_status_wallet');
    Route::post('vendor_wallet_check', 'App\Http\Controllers\admin\AdminWalletController@vendor_wallet_check');


    Route::resource('admin/faq', '\App\Http\Controllers\admin\FaqController');
    Route::get('delete_faq', [FaqController::class, 'destroy'])->name('delete_faq');

    Route::resource('admin/help', '\App\Http\Controllers\admin\HelpController');
    Route::get('delete_help', [HelpController::class, 'destroy'])->name('delete_help');

    Route::post('appointment-status', [HelpController::class, 'appointment_status'])->name('appointment-status');
    Route::post('ticket-status', [HelpController::class, 'ticket_status'])->name('ticket-status');

    Route::resource('/admin/frontuser', '\App\Http\Controllers\admin\FrontuserController');
    Route::post('change_status_frontuser', 'App\Http\Controllers\admin\FrontuserController@change_status_frontuser');

    Route::get('export-all', [App\Http\Controllers\admin\FrontuserController::class, 'downloadXls'])->name('export-excel');

    Route::resource('/enquiry', '\App\Http\Controllers\admin\EnquiryController');

    Route::get('/admin/add-enquiry', '\App\Http\Controllers\admin\EnquiryController@movingenquiryadd')->name('admin.movingenquiryadd');

    Route::get('/get-subservices/{service_id}', '\App\Http\Controllers\admin\EnquiryController@getSubservices')->name('getSubservices');
    Route::post('/admin/get-dynamic-forms', [EnquiryController::class, 'getDynamicForms'])->name('admin.get.dynamic.forms');
    Route::post('/admin/movingstorageenquirystore', [EnquiryController::class, 'movingstorageenquirystore'])->name('admin.movingstorageenquirystore');




    Route::post('change_status_auto_accept', 'App\Http\Controllers\admin\EnquiryController@change_status_auto_accept');
    Route::post('manual-assign-lead', '\App\Http\Controllers\admin\EnquiryController@manual_assign_lead');
    Route::post('manual-assign-vendor-form', '\App\Http\Controllers\admin\EnquiryController@manual_assign_vendor_form');
    Route::match(['get', 'post'], '/enquiry-filter', 'App\Http\Controllers\admin\EnquiryController@index')->name('enquiry-filter');
    Route::get('filter_data_enquiry', '\App\Http\Controllers\admin\EnquiryController@filter_data_enquiry');
    Route::get('enquiry_page/{enquiry_id}', [EnquiryController::class, 'enquiry_details'])->name('enquiry_page');
    Route::get('painting-lead-detail/{enquiry_id}', [EnquiryController::class, 'painting_enquiry_details'])->name('painting-lead-detail');
    Route::get('garden-enquiry-detail/{enquiry_id}', [EnquiryController::class, 'garden_enquiry_detail'])->name('garden-enquiry-detail');


    Route::match(['get', 'post'], 'wooden-floor-enquiry', [AdminacceptLeadscontroller::class, 'wooden_floor_enquiry'])->name('wooden-floor-enquiry');
    Route::get('wooden-floor-lead-detail/{enquiry_id}', [EnquiryController::class, 'wooden_floor_lead_details'])->name('wooden-floor-lead-detail');
    Route::get('wooden-enquiry-detail/{enquiry_id}', [Vendorinquirycontroller::class, 'wooden_enquiry_detail'])->name('wooden-enquiry-detail');
    Route::resource('vendor/wooden-inquiry', 'App\Http\Controllers\admin\WoodenFloorLeadsController');
    Route::post(
        'wooden-assign-vendor',
        '\App\Http\Controllers\admin\WoodenFloorLeadsController@wooden_floor_assign_vendor'
    );
    Route::post('wooden-email-vendor', '\App\Http\Controllers\admin\WoodenFloorLeadsController@wooden_floor_email_vendor');
    Route::post('wooden-vendor-form', '\App\Http\Controllers\admin\WoodenFloorLeadsController@wooden_vendor_form');
    Route::post('wooden-wallet-vendor', '\App\Http\Controllers\admin\WoodenFloorLeadsController@wooden_wallet_vendor');


    // Route::resource('/enquiry_accept', '\App\Http\Controllers\admin\AdminacceptLeadscontroller');
    Route::get('filter_data', '\App\Http\Controllers\admin\AdminacceptLeadscontroller@filter_data');
    Route::get('garden_accept_filter_data', '\App\Http\Controllers\admin\AdminacceptLeadscontroller@garden_accept_filter_data');
    Route::match(['get', 'post'], 'enquiry_accept', [AdminacceptLeadscontroller::class, 'enquiry_accept'])->name('enquiry_accept');
    Route::match(['get', 'post'], 'enquiry_reject', [AdminacceptLeadscontroller::class, 'enquiry_reject'])->name('enquiry_reject');
    Route::match(['get', 'post'], 'painting-enquiry', [AdminacceptLeadscontroller::class, 'painting_enquiry'])->name('painting-enquiry');
    Route::match(['get', 'post'], 'garden-enquiry', [AdminacceptLeadscontroller::class, 'garden_enquiry'])->name('garden-enquiry');
    Route::match(['get', 'post'], '/garden-enquiry-filter', [AdminacceptLeadscontroller::class, 'garden_enquiry'])->name('garden-enquiry-filter');
    Route::get('garden_filter_data', [AdminacceptLeadscontroller::class, 'garden_filter_data'])->name('garden_filter_data');
    Route::match(['get', 'post'], 'garden_accept', [AdminacceptLeadscontroller::class, 'garden_accept'])->name('garden_accept');
    Route::match(['get', 'post'], 'garden_reject', [AdminacceptLeadscontroller::class, 'garden_enquiry_reject'])->name('garden_reject');


    Route::resource('vendor/garden_acceptleads', 'App\Http\Controllers\admin\GardenAcceptLeadsController');
    Route::get('garden-enquiry-view/{enquiry_id}', [GardenAcceptLeadsController::class, 'garden_enquiry_view'])->name('garden-enquiry-view');
    Route::get('vendor/garden_reject_leads', [GardenAcceptLeadsController::class, 'garden_reject_leads'])->name('garden_reject_leads');

    Route::get('admin/download/{filepath}', [EnquiryController::class, 'download']);





    Route::resource('/admin/form_field', '\App\Http\Controllers\admin\Form_fieldController');

    Route::get('/admin/delete_form_field', [Form_fieldController::class, 'delete_form_field'])->name('delete_form_field');
    Route::get('remove_attribute/{form_id}/{id}', [Form_fieldController::class, 'remove_attribute'])->name('remove_attribute');
    Route::post('set_order_form_fields', '\App\Http\Controllers\admin\Form_fieldController@set_order_form_fields');
    Route::post('validate_form_field', 'App\Http\Controllers\admin\Form_fieldController@validate_form_field');
    Route::post('mail_send', 'App\Http\Controllers\admin\Form_fieldController@mail_send_fun');
    Route::get('remove_add_more_attribute/{form_id}/{id}/{attr_id}', [Form_fieldController::class, 'remove_more_attribute'])->name('remove_add_more_attribute');


    Route::resource('admin/order', 'App\Http\Controllers\admin\Ordercontroller');
    Route::post('admin/addCommission', 'App\Http\Controllers\admin\Ordercontroller@addCommission')->name('add.commission');
    Route::post('show_customer_details', 'App\Http\Controllers\admin\Ordercontroller@show_customer_details');
    Route::post('show_vehicle_model', 'App\Http\Controllers\admin\Ordercontroller@show_vehicle_model');
    Route::post('show_price', 'App\Http\Controllers\admin\Ordercontroller@show_price');
    Route::post('show_package_price', 'App\Http\Controllers\admin\Ordercontroller@show_package_price');
    Route::post('car_inspection_order_store', 'App\Http\Controllers\admin\Ordercontroller@car_inspection_order_store')->name('car_inspection_order_store');
    Route::get('car_inspection_order_edit/{id}', 'App\Http\Controllers\admin\Ordercontroller@car_inspection_order_edit')->name('car-inspection-order-edit');
    Route::post('car-inspection-order-update/{id}', '\App\Http\Controllers\admin\Ordercontroller@car_inspection_order_update')
        ->name('car-inspection-order-update');


    /* automobile order route */

    Route::get('automobile-order', '\App\Http\Controllers\admin\Ordercontroller@automobile_order')
        ->name('automobile-order');

    Route::get('automobile-admin-order', '\App\Http\Controllers\admin\Ordercontroller@automobile_admin_order')
        ->name('automobile-admin-order');

    Route::get('automobile-order/edit/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@automobile_order_edit')
        ->name('automobile_order_edit');

    Route::post('automobile-order-store', '\App\Http\Controllers\admin\Ordercontroller@automobile_order_store')
        ->name('automobile-order-store');

    Route::put('automobile-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@automobile_order_update')
        ->name('automobile_order_update');

    /* automobile order route */



    Route::get('cleaning_package_order', '\App\Http\Controllers\admin\Ordercontroller@cleaning_package_order')
        ->name('cleaning_package_order');
    Route::get('cleaning_package_order_edit/{id}', '\App\Http\Controllers\admin\Ordercontroller@cleaning_package_order_edit')
        ->name('cleaning_package_order_edit');

    Route::get('admin/healthcare-at-home-package-order', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_package_order')
        ->name('healthcare_at_home_package_order');

    Route::get('admin/healthcare_at_home_admin_order/add', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_admin_order')
        ->name('healthcare_at_home_admin_order');

    // Route::get('admin/healthcare-at-home-service-order-service-order', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_service_order')
    //     ->name('healthcare_at_home_service_order');

    Route::get('admin/order/healthcare-at-home-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('healthcare_at_home_detail');

    Route::get('admin/healthcare-at-home-package-order/edit/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_order_edit')
        ->name('healthcare_at_home_order_edit');

    Route::post('admin/healthcare-at-home-service-order-store', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_service_order_store')
        ->name('healthcare_at_home_service_order_store');

    Route::put('admin/healthcare-at-home-package-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@healthcare_at_home_order_update')
        ->name('healthcare_at_home_order_update');

    Route::get('admin/order/vendor-healthcare-at-home-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-healthcare-at-home-detail');


    Route::post('set-end-date', '\App\Http\Controllers\admin\Ordercontroller@set_end_date')
        ->name('set-end-date');
    Route::get('painting-service-order', '\App\Http\Controllers\admin\Ordercontroller@painting_service_order')
        ->name('painting-service-order');
    Route::get('handyman-service-order', '\App\Http\Controllers\admin\Ordercontroller@handyman_service_order')
        ->name('handyman-service-order');
    Route::get('car-inspection-order', '\App\Http\Controllers\admin\Ordercontroller@car_inspection_order')
        ->name('car-inspection-order');
    Route::get('salon-spa-order', '\App\Http\Controllers\admin\Ordercontroller@salon_spa_order')
        ->name('salon-spa-order');
    Route::get('pest-control-order', '\App\Http\Controllers\admin\Ordercontroller@pest_control_order')
        ->name('pest-control-order');
    Route::get('delete_order', [Ordercontroller::class, 'destroy'])->name('delete_order');
    Route::get('admin/order/detail/{order_id}', [Ordercontroller::class, 'detail'])->name('detail');
    Route::get('admin/order/painting-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('painting-detail');
    Route::get('admin/order/cleaning-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('cleaning-detail');
    Route::get('admin/order/moving-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('moving-detail');
    Route::get('admin/order/handyman-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('handyman-detail');
    Route::get('admin/order/car-inspection-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('car-inspection-detail');
    Route::get('admin/order/salon-spa-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('salon-spa-detail');
    Route::get('admin/order/pest-control-detail/{order_id}', [Ordercontroller::class, 'detail'])->name('pest-control-detail');

    Route::get('cleaning-admin-order/add', '\App\Http\Controllers\admin\Ordercontroller@cleaning_admin_order')
        ->name('cleaning-admin-order');
    Route::post('cleaning-order-store', '\App\Http\Controllers\admin\Ordercontroller@cleaning_order_store')
        ->name('cleaning-order-store');
    Route::put('cleaning-order-update/{id}', '\App\Http\Controllers\admin\Ordercontroller@cleaning_order_update')
        ->name('cleaning-order-update');

    Route::get('moving-admin-order/add', '\App\Http\Controllers\admin\Ordercontroller@moving_admin_order')
        ->name('moving-admin-order');
    Route::post('get-time-slot', '\App\Http\Controllers\admin\Ordercontroller@get_time_slot')
        ->name('get-time-slot');
    Route::post('moving-order-store', '\App\Http\Controllers\admin\Ordercontroller@moving_order_store')
        ->name('moving-order-store');

    Route::get('moving-package-order/edit/{id}', '\App\Http\Controllers\admin\Ordercontroller@moving_package_order_edit')
        ->name('moving_package_order_edit');

    Route::get('handyman-package-order/edit/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@handyman_order_edit')
        ->name('handyman_order_edit');

    Route::put('moving-package-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@moving_order_update')
        ->name('moving_order_update');

    Route::put('handyman-package-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@handyman_order_update')
        ->name('handyman_order_update');

    Route::get('salon-spa-package-order/edit/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@salon_spa_order_edit')
        ->name('salon_spa_order_edit');

    Route::get('pest-control-order/edit/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@pest_control_order_edit')
        ->name('pest_control_order_edit');

    Route::get('salon-spa-admin-order', '\App\Http\Controllers\admin\Ordercontroller@salon_spa_admin_order')
        ->name('salon-spa-admin-order');
    Route::post('salon-spa-order-store', '\App\Http\Controllers\admin\Ordercontroller@salon_spa_order_store')
        ->name('salon-spa-order-store');

    Route::get('pest-control-admin-order', '\App\Http\Controllers\admin\Ordercontroller@pest_control_admin_order')
        ->name('pest-control-admin-order');
    Route::post('pest-control-order-store', '\App\Http\Controllers\admin\Ordercontroller@pest_control_order_store')
        ->name('pest-control-order-store');

    Route::put('salon-spa-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@salon_spa_order_update')
        ->name('salon_spa_order_update');

    Route::put('pest-control-order/update/{ci_order}', '\App\Http\Controllers\admin\Ordercontroller@pest_control_order_update')
        ->name('pest_control_order_update');

    Route::get('handyman-service-admin-order', '\App\Http\Controllers\admin\Ordercontroller@handyman_service_admin_order')
        ->name('handyman-service-admin-order');
    Route::post('handyman-service-order-store', '\App\Http\Controllers\admin\Ordercontroller@handyman_service_order_store')
        ->name('handyman-service-order-store');

    Route::get('painting-service-admin-order', '\App\Http\Controllers\admin\Ordercontroller@painting_service_admin_order')
        ->name('painting-service-admin-order');
    Route::get('car-inspection-admin-order', '\App\Http\Controllers\admin\Ordercontroller@car_inspection_service_admin_order')
        ->name('car-inspection-admin-order');
    Route::post('painting-service-order-store', '\App\Http\Controllers\admin\Ordercontroller@painting_service_order_store')
        ->name('painting-service-order-store');


    Route::post('get-package-category', '\App\Http\Controllers\admin\Ordercontroller@get_package_category')
        ->name('get-package-category');
    Route::post('get-package', '\App\Http\Controllers\admin\Ordercontroller@get_package')
        ->name('get-package');
    Route::post('get-subservice-cleaners', '\App\Http\Controllers\admin\Ordercontroller@get_subservice_cleaners')
        ->name('get-subservice-cleaners');
    Route::post('time-slot-available', '\App\Http\Controllers\admin\Ordercontroller@time_slot_available')
        ->name('time-slot-available');
    Route::post('get-cleaners-time-slot', '\App\Http\Controllers\admin\Ordercontroller@get_cleaners_time_slot')
        ->name('get-cleaners-time-slot');

    Route::get('storage_package_order', '\App\Http\Controllers\admin\Ordercontroller@storage_package_order')
        ->name('storage_package_order');

    Route::get('admin/storage-admin-order/add', '\App\Http\Controllers\admin\Ordercontroller@storage_admin_order')
        ->name('storage-admin-order');
    Route::post('admin/storage-order-store', '\App\Http\Controllers\admin\Ordercontroller@storage_order_store')
        ->name('storage-order-store');
    Route::get('storage-package-order-edit/{id?}', '\App\Http\Controllers\admin\Ordercontroller@storage_package_order_edit')
        ->name('storage-package-order-edit');
    Route::post('storage-package-order-update', '\App\Http\Controllers\admin\Ordercontroller@storage_package_order_update')
        ->name('storage-package-order-update');

    Route::post('storage-renew-mail', [Ordercontroller::class, 'storage_renew_mail']);

    Route::get('vendor/storage-vendor-listing', '\App\Http\Controllers\admin\VendorOrderController@storage_vendor_listing')
        ->name('storage-vendor-listing');

    Route::get('vendor/order/vendor-storage-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-storage-detail');



    Route::resource('admin/order', 'App\Http\Controllers\admin\Ordercontroller');
    Route::get('delete_order', [Ordercontroller::class, 'destroy'])->name('delete_order');
    Route::get('admin/order/detail/{order_id}', [Ordercontroller::class, 'detail'])->name('detail');

    Route::post('assign_vendor', '\App\Http\Controllers\admin\Ordercontroller@assign_vendor');
    Route::post('assign_vendor_car', '\App\Http\Controllers\admin\Ordercontroller@assign_vendor_car')->name('admin.assign_vendor_car');
    Route::post('checkcar_vendor_available', '\App\Http\Controllers\admin\Ordercontroller@checkcar_vendor_available')->name('admin.checkcar_vendor_available');
    Route::post('location-link-form', '\App\Http\Controllers\admin\Ordercontroller@location_link_form');
    Route::post('cleaner-assign-form', '\App\Http\Controllers\admin\Ordercontroller@cleaner_assign_form');
    Route::post('multi-cleaner-time-slot', '\App\Http\Controllers\admin\Ordercontroller@multi_cleaner_time_slot');
    Route::post('multi-cleaner-assign-form', '\App\Http\Controllers\admin\Ordercontroller@multi_cleaner_assign_form');
    Route::post('salesperson-assign-form', '\App\Http\Controllers\admin\Ordercontroller@salesperson_assign_form');
    Route::post('add-cleaner-price-form', '\App\Http\Controllers\admin\Ordercontroller@add_cleaner_price_form');
    Route::post('painting-assign-vendor', '\App\Http\Controllers\admin\PaintingLeadscontroller@painting_assign_vendor');
    Route::post('painting-email-vendor', '\App\Http\Controllers\admin\PaintingLeadscontroller@painting_email_vendor');
    Route::post('painting-vendor-form', '\App\Http\Controllers\admin\PaintingLeadscontroller@painting_vendor_form');
    Route::post('painting-wallet-vendor', '\App\Http\Controllers\admin\PaintingLeadscontroller@painting_wallet_vendor');
    Route::post('/get-cleaners', [OrderController::class, 'getCleaners'])->name('get.cleanersorder');
    Route::post('/get-order-amount-history', [OrderController::class, 'getAmountHistory']);
    Route::get('mark-attendance/{order_id}', [OrderController::class, 'markAttendance']);
    Route::post('save-attendance', [OrderController::class, 'saveAttendance'])->name('attendance.store');

    Route::resource('vendor/garden-inquiry', 'App\Http\Controllers\admin\GardenEnquirycontroller');
    Route::post('garden-assign-vendor', '\App\Http\Controllers\admin\GardenEnquirycontroller@garden_assign_vendor');
    Route::post('garden-email-vendor', '\App\Http\Controllers\admin\GardenEnquirycontroller@garden_email_vendor');
    Route::post('garden-vendor-form', '\App\Http\Controllers\admin\GardenEnquirycontroller@garden_vendor_form');
    Route::post('garden-wallet-vendor', '\App\Http\Controllers\admin\GardenEnquirycontroller@garden_wallet_vendor');

    Route::post('add_amount_form', '\App\Http\Controllers\admin\Ordercontroller@add_amount_form');
    Route::post('checkAmountorder', '\App\Http\Controllers\admin\Ordercontroller@checkAmountorder');
    Route::post('order-status-change', '\App\Http\Controllers\admin\Ordercontroller@order_status_change');
    Route::post('payment-status-change', '\App\Http\Controllers\admin\Ordercontroller@payment_status_change');
    Route::match(['get', 'post'], '/vendors-filter', 'App\Http\Controllers\admin\Ordercontroller@vendor_commission_report')->name('vendors-filter');
    Route::get('filter_data_vendor', '\App\Http\Controllers\admin\Ordercontroller@filter_data_vendor');
    Route::get('admin/vendor-commission-report', '\App\Http\Controllers\admin\Ordercontroller@vendor_commission_report')->name('vendor-commission-report');



    Route::post('order_vendor_form', '\App\Http\Controllers\admin\Ordercontroller@order_vendor_form');
    Route::post('car_inpsection_form', '\App\Http\Controllers\admin\Ordercontroller@car_inpsection_form');
    Route::get('car-inspection-order/document-upload/{id}', '\App\Http\Controllers\admin\Ordercontroller@car_inspection_document_upload')->name('car-inspection-document-upload');
    Route::post('car-inspection-order/document-upload-store', '\App\Http\Controllers\admin\Ordercontroller@car_inspection_document_upload_store')->name('car-inspection-document-upload-store');
    Route::post('set_booking_percentage', '\App\Http\Controllers\admin\Ordercontroller@set_booking_percentage');

    Route::resource('vendor/vendororder', 'App\Http\Controllers\admin\VendorOrderController');

    Route::get('admin/order/vendor-moving-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-moving-detail');

    Route::get('vendor/order/new-bookings', [VendorOrderController::class, 'vendor_all_order'])->name('vendor-all-order');
    Route::get('order/new-booking-details/{order_id}', [VendorOrderController::class, 'vendor_all_order_detail'])->name('vendor-all-order-detail');

    Route::get('vendor/rejected-bookings', [VendorOrderController::class, 'rejected_bookings'])->name('vendor.rejected_bookings');
    Route::get('order/rejected-booking-details/{order_id}', [VendorOrderController::class, 'rejected_booking_details'])->name('vendor.rejected_booking_details');

    Route::post('vendor/order/check_order_vendor', [VendorOrderController::class, 'check_order_vendor'])->name('vendor.check_order_vendor');
    Route::post('vendor/order/reject_order_vendor', [VendorOrderController::class, 'reject_order_vendor'])->name('vendor.reject_order_vendor');


    Route::post('assign-driver', '\App\Http\Controllers\admin\VendorOrderController@assign_driver');
    Route::post('assign-driver-form', '\App\Http\Controllers\admin\VendorOrderController@assign_driver_form');
    Route::get('admin/order/vendor-cleaning-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-cleaning-detail');
    Route::get('vendor/cleaning-listing', '\App\Http\Controllers\admin\VendorOrderController@cleaning_listing')
        ->name('cleaning-listing');

    Route::get('vendor/healthcare-at-home-listing', '\App\Http\Controllers\admin\VendorOrderController@healthcare_at_home_listing')
        ->name('healthcare_at_home_listing');

    Route::post('vendor-cleaner-assign-form', '\App\Http\Controllers\admin\VendorOrderController@vendor_cleaner_assign_form');
    Route::post('vendor-multi-cleaner-time-slot', '\App\Http\Controllers\admin\VendorOrderController@vendor_multi_cleaner_time_slot');
    Route::post('vendor-multi-cleaner-assign-form', '\App\Http\Controllers\admin\VendorOrderController@vendor_multi_cleaner_assign_form');

    Route::get('admin/order/vendor-painting-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-painting-detail');
    Route::get('admin/painting-listing', '\App\Http\Controllers\admin\VendorOrderController@painting_listing')
        ->name('painting-listing');
    Route::get('vendor/salon-spa-listing', '\App\Http\Controllers\admin\VendorOrderController@salon_spa_listing')
        ->name('salon-spa-listing');


    Route::get(
        'vendor/pest-control-listing',
        '\App\Http\Controllers\admin\VendorOrderController@pest_control_listing'
    )
        ->name('pest-control-listing');


    Route::get('vendor/handyman-and-service-listing', '\App\Http\Controllers\admin\VendorOrderController@handyman_and_service_listing')
        ->name('handyman-and-service-listing');

    Route::get('admin/order/vendor-salon-spa-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-salon-spa-detail');
    Route::get('admin/order/vendor-pest-control-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-pest-control-detail');

    Route::get('vendor/car-inspection-order-listing', '\App\Http\Controllers\admin\VendorOrderController@car_inspection_order_listing')
        ->name('car-inspection-order-listing');
    Route::get('admin/order/vendor-car-inspection-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-car-inspection-detail');

    Route::get('vendor/automobile-vendor-order', '\App\Http\Controllers\admin\VendorOrderController@automobile_vendor_order')
        ->name('automobile-vendor-order');
    Route::get('admin/order/vendor-automobile-detail/{vendororder_id}', [VendorOrderController::class, 'vendordetail'])->name('vendor-automobile-detail');


    Route::resource('admin/subscribe', 'App\Http\Controllers\admin\SubscribeController');
    Route::get('delete_subscribe', [SubscribeController::class, 'destroy'])->name('delete_subscribe');

    Route::get('remove_others_att/{pid}/{id}', [PackagesController::class, 'remove_others_att'])->name('remove_others_att');
    Route::get('remove_packages_att/{pid}/{id}', [PackagesController::class, 'remove_packages_att'])->name('remove_packages_att');
    Route::get('remove_package_att/{pid}/{id}', [PackagesController::class, 'remove_package_att'])->name('remove_package_att');

    Route::get('/enquiry_login', '\App\Http\Controllers\front\Packagecontroller@enquiry_login')->name('enquiry_login');

    Route::resource('admin/blog', 'App\Http\Controllers\admin\BlogController');
    Route::get('delete_blog', [BlogController::class, 'destroy'])->name('delete_blog');
    Route::post('ckeditor/upload', [BlogController::class, 'upload'])->name('ckeditor.upload');
    Route::post('blog_subservice_show', 'App\Http\Controllers\admin\BlogController@subservice_show');

    Route::resource('admin/blog_category', 'App\Http\Controllers\admin\Blog_categoryController');
    Route::get('delete_blog_category', [Blog_categoryController::class, 'destroy'])->name('delete_blog_category');

    Route::resource('admin/salesreport', 'App\Http\Controllers\admin\SalesReportController');
    Route::get('admin/sales-report/detail/{order_id}', [SalesReportController::class, 'detail'])->name('details');

    Route::resource('admin/day-report', 'App\Http\Controllers\admin\DayReportController');
    Route::match(['get', 'post'], 'admin/day-report-filter', 'App\Http\Controllers\admin\DayReportController@index')->name('day-report-filter');

    Route::get('filter_day_report_data', '\App\Http\Controllers\admin\DayReportController@filter_day_report_data');



    Route::match(['get', 'post'], 'admin/cleaner-report', 'App\Http\Controllers\admin\CleanerReportController@index')->name('cleaner-report');

    Route::get('filter_data_cleaner', '\App\Http\Controllers\admin\CleanerReportController@filter_data_cleaner');

    Route::resource('admin/google_review', 'App\Http\Controllers\admin\GooglereviewController');
    Route::get('delete_google_review', [GooglereviewController::class, 'destroy'])->name('delete_google_review');
    Route::get('admin/get-subservices-by-service/{service_id}', [GooglereviewController::class, 'getSubservicesByService'])->name('google_review.get_subservices');

    Route::get('admin/fix-db', function () {
        try {
            \DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `review_date` DATE NULL AFTER `name`');
            \DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `services` TEXT NULL AFTER `review_date`');
            \DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `subservice_id` TEXT NULL AFTER `services`');
            return "Columns added successfully!";
        } catch (\Exception $e) {
            try {
                // If columns exist or packages needs renaming
                \DB::statement('ALTER TABLE `googlereviews` CHANGE COLUMN `packages` `subservice_id` TEXT NULL');
                \DB::statement('ALTER TABLE `googlereviews` ADD COLUMN `review_date` DATE NULL AFTER `name`');
                return "Renamed packages and added review_date successfully!";
            } catch (\Exception $e2) {
                return "Error or columns already exist: " . $e2->getMessage();
            }
        }
    });

    Route::resource('system', 'App\Http\Controllers\admin\SystemController');
    Route::get('removed_system_att/{pid}/{id}', [SystemController::class, 'removed_system_att'])->name('removed_system_att');

    Route::resource('cleaning_price', 'App\Http\Controllers\admin\Cleaning_PriceController');

    Route::resource('time_slot_price', 'App\Http\Controllers\admin\Time_Slot_PriceController');
    Route::get('delete_timeslot', [Time_Slot_PriceController::class, 'destroy'])->name('delete_timeslot');

    Route::resource('painting-price', 'App\Http\Controllers\admin\PaintingPriceController');

    Route::resource('/admin/enquiry-users', '\App\Http\Controllers\admin\EnquiryUsersController');
    Route::match(['get', 'post'], '/filter-enquiryusers', 'App\Http\Controllers\admin\EnquiryUsersController@index')->name('filter-enquiryusers');
    Route::get('filter_data_enquiryusers', '\App\Http\Controllers\admin\EnquiryUsersController@filter_data_enquiryusers');

    Route::get('delete-enquiry-users', [EnquiryUsersController::class, 'destroy'])->name('delete-enquiry-users');

    Route::match(['get', 'post'], '/vendorsubscriptionreport', 'App\Http\Controllers\admin\vendorsubscriptionreport@index')->name('vendorsubscriptionreport');

    Route::get('filter_vendorsubscriptionreport', '\App\Http\Controllers\admin\vendorsubscriptionreport@filter_vendorsubscriptionreport');

    Route::post('subscription_change', 'App\Http\Controllers\admin\vendorsubscriptionreport@subscription_change');

    //  Route::resource('/erp_enquiry', '\App\Http\Controllers\admin\ERP_EnquiryController');
    //  Route::get('/admin/delete_erp_enquiry', [ERP_EnquiryController::class,'destroy'])->name('delete_erp_enquiry'); 

    Route::resource('admin/company-profile', 'App\Http\Controllers\admin\CompanyProfileController');
    Route::get('/comapny-documents-delete/{cid}/{id}', 'App\Http\Controllers\admin\CompanyProfileController@delete_attribute')->name('company-documents.delete');

    Route::resource('admin/company-employees', 'App\Http\Controllers\admin\CompanyEmployeeController');
    Route::get('/company-emp-document-delete/{eid}/{id}', 'App\Http\Controllers\admin\CompanyEmployeeController@delete_attribute')->name('company-emp-doc.delete');
    Route::get('company-employee/delete', 'App\Http\Controllers\admin\CompanyEmployeeController@destroy')->name('company-employee.delete');
});
Route::controller(Salespersonreportcontroller::class)->prefix('admin')->middleware('auth')->group(function () {

    Route::match(['get', 'post'], 'salesperson-report', 'index')->name('salesperson_report');
    Route::post('filter-data-salesperson', 'filter_data_salesperson')->name('filter_data_salesperson');
});


Route::controller(ERP_EnquiryController::class)->prefix('admin')->middleware('auth')->group(function () {

    Route::get('/erp_enquiry', 'index')->name('erp_enquiry.lists');
    Route::get('/erp_enquiry/create', 'create')->name('erp_enquiry.create');
    Route::post('/erp_enquiry/store', 'store')->name('erp_enquiry.store');
    Route::get('/erp_enquiry/{id}/edit', 'edit')->name('erp_enquiry.edit');
    Route::put('/erp_enquiry/{id}', 'update')->name('erp_enquiry.update');
    Route::get('/erp_enquiry/delete', 'destroy')->name('erp_enquiry.delete');
});

Route::controller(ErpSurveycontroller::class)->prefix('admin')->middleware('auth')->group(function () {

    Route::get('/erp_survey', 'index')->name('erp_survey.lists');
    Route::get('/erp_survey/create', 'create')->name('erp_survey.create');
    Route::post('/erp_survey/store', 'store')->name('erp_survey.store');
});

Route::controller(ErpQuotecontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/erp_quote', 'index')->name('erp_quote.lists');
    Route::get('/erp_quote/create', 'create')->name('erp_quote.create');
    Route::post('/erp_quote/store', 'store')->name('erp_quote.store');
    Route::get('/erp_quote/remove/{enquiry_id}/{id}', 'costing_remove')->name('erp_quote.remove');
    Route::get('/erp_quote/customer-mail/{id}', 'customer_mail')->name('erp_quote.mail');
    Route::post('/erp_quote/mail-format-type', 'mail_format_type')->name('erp_quote.mail-format-type');
    Route::get('/erp_quote/quotation-download', 'quotation_download')->name('erp_quote.download');
    Route::post('/erp_quote/send-quotation-mail', 'send_quotation_mail')->name('erp_quote.send_quotation_mail');
    Route::post('/erp_quote/accept-quotation-admin', 'accept_quotation_byadmin')->name('erp_quote.accept_quotation_admin');
    Route::post('/erp_quote/quatation_reject_form', 'quatation_reject_form')->name('erp_quote.quatation_reject_form');
    Route::get('erp_quote/revise-quote', 'create')->name('erp_quote.revisequote');
    Route::get('erp_quote/get-survey-document/{id}', 'getSurveydocument')->name('erp_quote.getSurveydocument');
});

Route::controller(Erpdescriptionofgoods::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/erp_dog', 'index')->name('erp_dog.lists');
    Route::get('/erp_dog/create', 'create')->name('erp_dog.create');
    Route::post('/erp_dog/store', 'store')->name('erp_dog.store');
    Route::get('/erp_dog/{id}/edit', 'edit')->name('erp_dog.edit');
    Route::put('/erp_dog/{id}', 'update')->name('erp_dog.update');
    Route::get('/erp_dog/delete', 'destroy')->name('erp_dog.delete');
});



Route::controller(ErpAcceptedquotecontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/erp_acceptedquote', 'index')->name('erp_acceptedquote.lists');
    Route::get('/erp_acceptedquote/sendmail/{id}', 'sendmail')->name('erp_acceptedquote.sendmail');
    Route::get('erp_acceptedquote/revise-quote', 'create')->name('erp_acceptedquote.revisequote');
    Route::post('/erp_acceptedquote/send-mail-ajax', 'sendmailcustomer_ajax')->name('erp_acceptedquote.sendmailcustomer_ajax');
    Route::get('erp_acceptedquote/addDocuments/{id}', 'addDocuments')->name('erp_acceptedquote.addDocuments');
    Route::post('erp_acceptedquote/addDocumentsstore', 'addDocumentsstore')->name('erp_acceptedquote.addDocumentsstore');
    Route::post('erp_acceptedquote/delete-document', 'deleteDocument')->name('erp_acceptedquote.deleteDocument');
    Route::get('erp_acceptedquote/agreement/{id}', 'agreement')->name('erp_acceptedquote.agreement');
    Route::post('erp_acceptedquote/send-agreement-mail', 'sendAgreementMail')->name('erp_acceptedquote.send_agreement_mail');
    Route::get('erp_acceptedquote/assignwarehouse/{id}', 'assignwarehouse')->name('erp_acceptedquote.assignwarehouse');
    Route::post('erp_acceptedquote/assignwarehouse-store', 'assignwarehousestore')->name('erp_acceptedquote.assignwarehousestore');
    Route::get('erp_acceptedquote/agreement-download', 'agreement_download')->name('erp_acceptedquote.agreement_download');
});
Route::controller(ErpRejectedquotecontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/erp_rejectedquote', 'index')->name('erp_rejectedquote.lists');
    Route::post('erp_rejectedquote/reason', 'reasonget')->name('erp_rejectedquote.reason');
});

Route::controller(Vendorquotecontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/vendorquote', 'index')->name('vendorquote.lists');
    Route::get('/vendorquote/get-survey-details/{id}', 'getSurveyDetails')->name('vendorquote.getSurveyDetails');
    Route::get('/vendorquote/upload-document/{id}', 'uploaddocument')->name('vendorquote.uploaddocument');
    Route::post('/vendorquote/store', 'store')->name('vendorquote.store');
    Route::delete('/vendorquote/document/{id}', 'deleteDoc')->name('vendorquote.deletedoc');
});
Route::controller(Vendorbookedtimeslotcontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/vendorbookedtimeslot', 'index')->name('vendorbookedtimeslot.lists');
    Route::get('/vendorbookedtimeslot/create', 'create')->name('vendorbookedtimeslot.create');
    Route::post('/vendorbookedtimeslot/store', 'store')->name('vendorbookedtimeslot.store');
    Route::get('/vendorbookedtimeslot/{id}/edit', 'edit')->name('vendorbookedtimeslot.edit');
    Route::put('/vendorbookedtimeslot/{id}', 'update')->name('vendorbookedtimeslot.update');
    Route::get('/vendorbookedtimeslot/delete', 'destroy')->name('vendorbookedtimeslot.delete');
});

Route::controller(Addonscontroller::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/addons', 'index')->name('addons.lists');
    Route::get('/addons/create', 'create')->name('addons.create');
    Route::post('/addons/store', 'store')->name('addons.store');
    Route::get('/addons/{id}/edit', 'edit')->name('addons.edit');
    Route::put('/addons/{id}', 'update')->name('addons.update');
    Route::get('/addons/delete', 'destroy')->name('addons.delete');
    Route::post('/addons/subservice-show', 'subservice_show')->name('addons.subservice_show');
    Route::post('/addons/set-order', 'set_order')->name('addons.set_order');
    Route::post('/addons/change-status', 'change_status')->name('addons.change_status');
});

Route::controller(EvcharginginstallationLeads::class)->prefix('admin')->middleware('auth')->group(function () {
    Route::get('/evchargingleads', 'index')->name('evchargingleads.lists');
    Route::get('evchargingleads/details/{enquiry_id}', 'details')->name('evchargingleads.details');
});









Route::get('/accept-quotation/{enquiry_id}/{format_type}', [ErpQuotecontroller::class, 'accept_quotation'])->name('accept.quotation');
Route::get('/request-accept/{enquiry_id}/{format_type}', [ErpQuotecontroller::class, 'request_accepted'])->name('request.accept');







/*------Front routes start ------*/


// Route::get('/', function () {
//     return redirect()->to(url('dubai'));
// })->name('default.city');

// Route::get('/{city}', [Fronthomecontroller::class, 'index'])
//     ->where('city', '^(?!admin|login|logout).*$')
//     ->name('city.home');


Route::get('/', '\App\Http\Controllers\front\Homecontroller@redirectToCity')
    ->name('default.city');

Route::prefix('{city}')
    ->where(['city' => '^(?!admin|login|logout|config-cache|accept-quotation|request-accept).*$'])
    ->middleware('front.city')
    ->group(function () {

        Route::get('/payment_success_automobile', '\App\Http\Controllers\front\Automobilecontroller@payment_success')->name('payment_success_automobile');
        Route::get('/payment_fail_automobile', '\App\Http\Controllers\front\Automobilecontroller@payment_fail')->name('payment_fail_automobile');

        Route::get('/automobile/thank-you', '\App\Http\Controllers\front\Automobilecontroller@thankyou')->name('automobile.thank-you');
        Route::get('/automobile/book-inspection/{id}', '\App\Http\Controllers\front\Automobilecontroller@book_inspection')->name('automobile.bookinspection');
        Route::get('/automobile/packages', '\App\Http\Controllers\front\Automobilecontroller@packages')->name('automobile.packages');
        Route::get('/automobile/{page_url}', '\App\Http\Controllers\front\Automobilecontroller@listing')->name('automobile.listing');
        Route::post('change_model', 'App\Http\Controllers\front\Automobilecontroller@change_model');


        Route::post('show_category', 'App\Http\Controllers\front\Automobilecontroller@show_category');
        Route::post('book-inspection-form', 'App\Http\Controllers\front\Automobilecontroller@book_inspection_form')->name('book-inspection-form');

        Route::get('/vendor-registration-succesful', '\App\Http\Controllers\front\Homecontroller@become_vendors')->name('vendor-registration-succesful');
        Route::post('facebook-login', '\App\Http\Controllers\front\FrontloginregisterController@facebook')->name('facebook-login');

        Route::get('auth/google', '\App\Http\Controllers\front\FrontloginregisterController@redirectToGoogle');
        Route::get('gmail-login', '\App\Http\Controllers\front\FrontloginregisterController@gmail');
        Route::post('booknow-user-otp-login', 'App\Http\Controllers\front\FrontloginregisterController@booknow_user_otp_login')->name('booknow-user-otp-login');
        Route::post('booknow-otp-sent', '\App\Http\Controllers\front\FrontloginregisterController@booknow_otp_sent')->name('booknow-otp-sent');


        Route::post('book-email-otp-login', 'App\Http\Controllers\front\FrontloginregisterController@book_user_otp_login')->name('home.book-email-otp-login');
        Route::post('book-email-otp-sent', '\App\Http\Controllers\front\FrontloginregisterController@book_email_otp_sent')->name('home.book-email-otp-sent');


        Route::post('search', '\App\Http\Controllers\front\Homecontroller@search')->name('search');

        Route::get('/privacy-policy', '\App\Http\Controllers\front\Homecontroller@privacy_policy')->name('privacy_policy');
        Route::get('/terms-of-service', '\App\Http\Controllers\front\Homecontroller@term_condition')->name('term_condition');
        Route::get('/payment-and-refund-policy', '\App\Http\Controllers\front\Homecontroller@payment_refund_policy')->name('payment_refund_policy');
        Route::get('/contact', '\App\Http\Controllers\front\Homecontroller@contact')->name('contact');
        Route::post('/contact_us_data', '\App\Http\Controllers\front\Homecontroller@contact_us_data');
        Route::get('/careers', '\App\Http\Controllers\front\Homecontroller@careers')->name('careers');
        Route::get('/about-us', '\App\Http\Controllers\front\Homecontroller@about_us')->name('about_us');

        Route::get('/services', '\App\Http\Controllers\front\Homecontroller@book_services');
        // Route::get('/book-services', '\App\Http\Controllers\front\Homecontroller@book_services');
        Route::get('/become-a-vendor', '\App\Http\Controllers\front\Homecontroller@become_vendor');
        Route::post('/front-get-subservices', '\App\Http\Controllers\front\Homecontroller@getSubservices')->name('front.getSubservices');

        Route::get('/blog', '\App\Http\Controllers\front\Homecontroller@blog');
        Route::get('/blog/{blog_url}', '\App\Http\Controllers\front\Homecontroller@blog_detail')->name('blog_detail');
        Route::post('email-otp-sent', '\App\Http\Controllers\front\Homecontroller@email_otp_sent')->name('home.email-otp-sent');
        Route::post('user-email-otp-login', 'App\Http\Controllers\front\Homecontroller@user_email_otp_login')->name('home.user-email-otp-login');
        Route::post('user-otp-login', 'App\Http\Controllers\front\Homecontroller@user_otp_login')->name('user-otp-login');
        Route::post('otp-sent', '\App\Http\Controllers\front\Homecontroller@otp_sent')->name('otp-sent');
        Route::get('Sign-Up/{id?}', '\App\Http\Controllers\front\FrontloginregisterController@test');
        Route::resource('Sign-Up', '\App\Http\Controllers\front\FrontloginregisterController');
        Route::get('Sign-in', '\App\Http\Controllers\front\FrontloginregisterController@Sign_in')->name('Sign-in');

        Route::post('user-detail-login', 'App\Http\Controllers\front\FrontloginregisterController@user_detail_login')->name('user-detail-login');

        // Handle both GET and POST requests
        // Route::match(['get', 'post'], 'sign-in-form', '\App\Http\Controllers\front\FrontloginregisterController@sign_in_form')->name('sign-in-form');

        Route::get('user_signout', 'App\Http\Controllers\front\FrontloginregisterController@user_signout')->name('user_signout');


        Route::get('test_mail', 'App\Http\Controllers\front\FrontloginregisterController@test_mail')->name('test_mail');

        Route::post('check_login', 'App\Http\Controllers\front\FrontloginregisterController@check_login');

        Route::get('search-package', 'App\Http\Controllers\front\FrontloginregisterController@search_package')->name('search_package');
        // Route::post('search-package', 'App\Http\Controllers\front\Homecontroller@search_package');

        // Route::match(['get', 'post'], 'search-package', [FrontloginregisterController::class, 'search_package'])->name('search_package');

        Route::post('user_login', 'App\Http\Controllers\front\FrontloginregisterController@user_login')->name('user_login');

        Route::post('registration_mail_check', '\App\Http\Controllers\front\FrontloginregisterController@registration_mail_check');


        Route::get('forget-password', '\App\Http\Controllers\front\FrontloginregisterController@lost_password');
        Route::post('email-check-login', '\App\Http\Controllers\front\FrontloginregisterController@emailCheck');
        Route::post('resetpassword', '\App\Http\Controllers\front\FrontloginregisterController@get_password')->name('reset-password');
        Route::get('reset-password/{uid}', '\App\Http\Controllers\front\FrontloginregisterController@reset_password')->name('reset_password');


        Route::post('check_email', '\App\Http\Controllers\front\FrontloginregisterController@check_email');
        Route::post('news_letter_email', '\App\Http\Controllers\front\FrontloginregisterController@news_letter_email');


        Route::post('set_password/{uid}', '\App\Http\Controllers\front\FrontloginregisterController@set_password')->name('set_password');

        Route::match(['get', 'post'], 'lost-password', [AdminpassController::class, 'lost_password'])->name('lost_password');
        Route::post('email-check-login-admin', '\App\Http\Controllers\admin\AdminpassController@emailCheck');
        Route::get('reset-password-vendor/{uid}', '\App\Http\Controllers\admin\AdminpassController@reset_password')->name('reset_password');
        Route::post('set_password_vendor/{uid}', '\App\Http\Controllers\admin\AdminpassController@set_password_vendor')->name('set_password_vendor');



        Route::match(['get', 'post'], 'our-vendors', [FrontvendorController::class, 'vendor_database'])->name('vendor_database');

        // Route::get('/package-lists/{page_url}', '\App\Http\Controllers\front\Packagecontroller@package_lists')->name('package-lists');
        Route::get('/package-detail/{page_url}', '\App\Http\Controllers\front\Packagecontroller@package_detail')->name('front.package_detail');

        Route::get('enquiry/{id}/', '\App\Http\Controllers\front\Packagecontroller@enquiry')->name('enquiry');
        Route::get('enquiry/{id}/{service_id}/', '\App\Http\Controllers\front\Packagecontroller@enquiry')->name('enquiry');

        Route::get('enquiry/{id}/', '\App\Http\Controllers\front\Packagecontroller@enquiry');

        Route::get('enquiry/{id}/{service_id}/', '\App\Http\Controllers\front\Packagecontroller@enquiry_sub')->name('enquiry');



        Route::get('enquiry/{service_id}/{subservice_id}', 'Packagecontroller@enquiry_sub')->name('enquiry');

        Route::get('enquiry-thankyou', '\App\Http\Controllers\front\Packagecontroller@enquiry_thankyou')->name('enquiry.thankyou');

        Route::get('booknow/{service_id}/{subservice_id}', '\App\Http\Controllers\front\Packagecontroller@booknow')->name('booknow');

        Route::post('get_price_cleaning', '\App\Http\Controllers\front\Packagecontroller@get_price_cleaning');
        Route::post('cleaner-time-check', '\App\Http\Controllers\front\Packagecontroller@cleaner_time_check');
        Route::post('homecleaner-time-check', '\App\Http\Controllers\front\Packagecontroller@homecleaner_time_check');

        Route::post('/get-cleaners-by-city', '\App\Http\Controllers\front\Packagecontroller@getCleanersByCity')
            ->name('get.cleaners.by.city');

        Route::post('painting-time-check', '\App\Http\Controllers\front\Packagecontroller@painting_time_check');



        Route::post('hours-check', '\App\Http\Controllers\front\Packagecontroller@hours_check');

        Route::post('apply-wallet-discount-book_now', '\App\Http\Controllers\front\Packagecontroller@apply_wallet_discount_book_now');
        Route::post('cancel-wallet-discount-book-now', '\App\Http\Controllers\front\Packagecontroller@cancel_wallet_discount_book_now');


        Route::post('change_drop_down', '\App\Http\Controllers\front\Packagecontroller@change_drop_down');

        Route::post('change_drop_down_two', '\App\Http\Controllers\front\Packagecontroller@change_drop_down_two');


        // Route::get('service/{page_url}', '\App\Http\Controllers\front\Homecontroller@subservices')->name('subservices');




        // Route::post('package_inquiry', '\App\Http\Controllers\front\Packagecontroller@package_inquiry')->name('package_inquiry');

        Route::match(['get', 'post'], 'package_inquiry', '\App\Http\Controllers\front\Packagecontroller@package_inquiry')->name('package_inquiry');

        Route::post('package_inquiry_new', '\App\Http\Controllers\front\Packagecontroller@package_inquiry_new')->name('package_inquiry_new');




        Route::post('vendors_check_mail', '\App\Http\Controllers\front\Homecontroller@vendors_check_mail');
        Route::post('/vendors_data', '\App\Http\Controllers\front\Homecontroller@vendors_data');

        Route::get('/cart/package_cart', '\App\Http\Controllers\front\Cartcontroller@package_cart')->name('cart.package_cart');
        Route::post('/cart/package_cart_store', '\App\Http\Controllers\front\Cartcontroller@package_cart_store')->name('cart.package_cart_store');

        Route::get('/cart/get-coupon', '\App\Http\Controllers\front\Cartcontroller@getCouponData')->name('package.get_coupon');
        Route::post('/cart/package-remove-coupon', '\App\Http\Controllers\front\Cartcontroller@package_remove_coupon')->name('package.remove_coupon');

        Route::get('/cart/get-coupon-home', '\App\Http\Controllers\front\Cartcontroller@homecleaning_getCouponData')->name('homecleaning.get_coupon');
        Route::post('/cart/homecleaning-remove-coupon', '\App\Http\Controllers\front\Cartcontroller@homecleaning_remove_coupon')->name('homecleaning.remove_coupon');

        Route::post('/homeaddons/store', '\App\Http\Controllers\front\Cartcontroller@homecleaningaddons_store')->name('homecleaningaddons_store');
        Route::get('/homeaddons/cart', '\App\Http\Controllers\front\Cartcontroller@homecleaningaddons_get')->name('homecleaningaddons_get');

        Route::post('/package-get-timeslots', '\App\Http\Controllers\front\Packagecontroller@package_get_timeslots')
            ->name('package.package_get_timeslots');


        Route::get('/cart', '\App\Http\Controllers\front\Cartcontroller@cart')->name('cart');
        Route::post('add_to_cart', '\App\Http\Controllers\front\Cartcontroller@add_to_cart');
        Route::post('cart_remove', '\App\Http\Controllers\front\Cartcontroller@cart_remove');
        Route::post('update_cart', '\App\Http\Controllers\front\Cartcontroller@update_cart');
        Route::post('update_cart_book_now', '\App\Http\Controllers\front\Cartcontroller@update_cart_book_now');

        Route::post('add_to_cart_book', '\App\Http\Controllers\front\Cartcontroller@add_to_cart_book');
        Route::post('cart_remove_book_now', '\App\Http\Controllers\front\Cartcontroller@cart_remove_book_now');
        Route::post('minus-quantity-cart-remove-book-now', '\App\Http\Controllers\front\Cartcontroller@minus_quantity_cart_remove_book_now');
        Route::post('promo_codecheck', '\App\Http\Controllers\front\Cartcontroller@promo_codecheck');
        Route::post('remove_coupon', '\App\Http\Controllers\front\Cartcontroller@remove_coupon');
        Route::post('lat_summary_promo_codecheck', '\App\Http\Controllers\front\Cartcontroller@lat_summary_promo_codecheck');
        Route::post('last_summary_remove_coupon', '\App\Http\Controllers\front\Cartcontroller@last_summary_remove_coupon');
        Route::post('promo_codecheck_home_cleaning', '\App\Http\Controllers\front\Cartcontroller@promo_codecheck_home_cleaning');
        Route::post('home_cleaning_remove_coupon', '\App\Http\Controllers\front\Cartcontroller@home_cleaning_remove_coupon');
        Route::post('lat_summary_home_cleaning_promo_codecheck', '\App\Http\Controllers\front\Cartcontroller@lat_summary_home_cleaning_promo_codecheck');
        Route::post('last_summary_home_cleaning_remove_coupon', '\App\Http\Controllers\front\Cartcontroller@last_summary_home_cleaning_remove_coupon');

        Route::post('package_promo_check', '\App\Http\Controllers\front\Cartcontroller@package_promo_check')->name('package_promo_check');
        Route::post('home_promo_check', '\App\Http\Controllers\front\Cartcontroller@home_promo_check')->name('home_promo_check');

        Route::post('checkout_promo_codecheck', '\App\Http\Controllers\front\Cartcontroller@checkout_promo_codecheck');
        Route::post('checkout_remove_coupon', '\App\Http\Controllers\front\Cartcontroller@checkout_remove_coupon');

        Route::post('promo_codecheck_painting', '\App\Http\Controllers\front\Cartcontroller@promo_codecheck_painting');





        Route::get('/checkout', '\App\Http\Controllers\front\checkoutcontroller@checkout');
        Route::post('/order_place', '\App\Http\Controllers\front\checkoutcontroller@order_place')->name('order_place');

        Route::get('cleaning/thankyou', [checkoutcontroller::class, 'thankyou_book_now'])->name("cleaning.thankyou_book_now");
        Route::get('salon-spa-at-home/thankyou', [checkoutcontroller::class, 'thankyou_book_now'])->name("saloon_spa.thankyou_book_now");
        Route::get('handyman-maintainence/thankyou', [checkoutcontroller::class, 'thankyou_book_now'])->name("hanyman.thankyou_book_now");
        Route::get('pest-control-gardening/thankyou', [checkoutcontroller::class, 'thankyou_book_now'])->name("pest_control.thankyou_book_now");

        Route::get('thankyou-book-now', [checkoutcontroller::class, 'thankyou_painting'])->name("thankyou-book-now");
        Route::get('success_mail_book_now', [checkoutcontroller::class, 'success_mail_book_now'])->name("success_mail_book_now");

        Route::get('thankyou', [checkoutcontroller::class, 'thankyou'])->name("thankyou");
        Route::get('thankyou_book_now', [checkoutcontroller::class, 'thankyou_book_now'])->name("thankyou_book_now");

        Route::post('/book_now_order', '\App\Http\Controllers\front\checkoutcontroller@book_now_order')->name('book_now_order');
        Route::post('/book_now_package', '\App\Http\Controllers\front\checkoutcontroller@book_now_package')->name('book_now_package');

        Route::post('/book_now_homecleaning', '\App\Http\Controllers\front\checkoutcontroller@book_now_homecleaning')->name('book_now_homecleaning');

        Route::get('success_mail_book_now_allvendor', [checkoutcontroller::class, 'success_mail_book_now_allvendor'])->name("success_mail_book_now_allvendor");



        Route::post('/book-now-garden-order', '\App\Http\Controllers\front\checkoutcontroller@book_now_garden_order')->name('book-now-garden-order');

        Route::get('/payment_success', '\App\Http\Controllers\front\checkoutcontroller@payment_success')->name('payment_success');
        Route::get('/payment_fail', '\App\Http\Controllers\front\checkoutcontroller@payment_fail')->name('payment_fail');

        // Tabby Routes
        Route::get('/tabby/success', '\App\Http\Controllers\front\TabbyController@success')->name('tabby.success');
        Route::get('/tabby/cancel', '\App\Http\Controllers\front\TabbyController@cancel')->name('tabby.cancel');
        Route::post('/tabby/webhook', '\App\Http\Controllers\front\TabbyController@webhook')->name('tabby.webhook');

        Route::post('/bill_state_change', '\App\Http\Controllers\front\checkoutcontroller@bill_state_change');
        Route::post('/ship_state_change', '\App\Http\Controllers\front\checkoutcontroller@ship_state_change');


        Route::get('/my-account', '\App\Http\Controllers\front\MyaccountController@my_account')->name('front.myaccount');
        Route::get('/my-order', '\App\Http\Controllers\front\MyaccountController@my_order')->name('front.myorder');
        Route::get('/my-profile', '\App\Http\Controllers\front\MyaccountController@my_profile')->name('front.myprofile');
        Route::get('my-wallet', '\App\Http\Controllers\front\MyaccountController@my_wallet')->name('front.mywallet');
        // Route::get('/order-detail', '\App\Http\Controllers\front\MyaccountController@order_detail');
        Route::get('/order-detail/{id}', '\App\Http\Controllers\front\MyaccountController@order_details')->name('order-detail');
        Route::get('/view-receipts/{id}', '\App\Http\Controllers\front\MyaccountController@view_receipts')->name('view-receipts');
        Route::post('/submit-review', '\App\Http\Controllers\front\MyaccountController@submitreview')->name('submit.review');
        Route::post('/update-instruction', '\App\Http\Controllers\front\MyaccountController@update_instruction')->name('update-instruction');
        Route::post('/update-address', '\App\Http\Controllers\front\MyaccountController@update_address')->name('update-address');
        Route::post('/cancel-order', '\App\Http\Controllers\front\MyaccountController@cancel_order')->name('cancel-order');
        Route::get('refer&earn', '\App\Http\Controllers\front\MyaccountController@refer_earn')->name('front.refer_earn');
        Route::get('refral', '\App\Http\Controllers\front\MyaccountController@refral')->name('front.refral');;
        Route::get('refer_and_earn/{userid}', '\App\Http\Controllers\front\MyaccountController@refer_earn_frend');
        Route::get('cancelpackage/{id}/', '\App\Http\Controllers\front\MyaccountController@cancelpackage')->name('cancelpackage');
        Route::post('/reschedule-from/{id}', '\App\Http\Controllers\front\MyaccountController@reschedule_from')->name('reschedule-from');
        Route::get('/reschedule/{id}', '\App\Http\Controllers\front\MyaccountController@reschedule')->name('reschedule');

        Route::get('/my-quotes', '\App\Http\Controllers\front\MyaccountController@myleads')->name('front.myleads');
        Route::get('/my-quote-detail/{type}/{id}', [\App\Http\Controllers\front\MyaccountController::class, 'myLeadDetail'])->name('front.mylead_detail');

        // Route::get('/my-lead-service/{id}', '\App\Http\Controllers\front\MyaccountController@myleads_service')->name('front.myleads_service');
        // Route::get('/my-lead-subservice/{serviceid}/{subserviceid}', '\App\Http\Controllers\front\MyaccountController@myleads_subservice')->name('front.myleads_subservice');

        Route::match(['get', 'post'], 'edit-profile', [MyaccountController::class, 'edit_profile'])->name('edit_profile');

        Route::get('download/{filepath}', [Packagecontroller::class, 'download']);



        Route::get('downloads/{filename}', '\App\Http\Controllers\front\Homecontroller@downloads')->name('downloads');

        Route::post('/apply-wallet-dicount', '\App\Http\Controllers\front\checkoutcontroller@apply_wallet_dicount');
        Route::post('/cancel-wallet-dicount', '\App\Http\Controllers\front\checkoutcontroller@cancel_wallet_dicount');

        /* Pating Price Routes and Urls */
        Route::post('get-size-home-price', '\App\Http\Controllers\front\Packagecontroller@get_size_home_price');
        Route::post('get-color-painted-price', '\App\Http\Controllers\front\Packagecontroller@get_color_painted_price');
        Route::post('get-colornow-paint-price', '\App\Http\Controllers\front\Packagecontroller@get_colornow_paint_price');
        Route::post('get-home-furnished-price', '\App\Http\Controllers\front\Packagecontroller@get_home_furnished_price');

        Route::get('thank-you', function () {

            return view('front.enquiry-thankyou');
        })->name('thank-you');


        Route::get('auto_accept_package', 'App\Http\Controllers\admin\CronController@auto_accept_package');

        Route::get('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
            ->middleware('auth')
            ->name('logout');


        Route::controller(PaymentfrontController::class)->group(function () {
            Route::get('paymentstripe/already', 'paymentalready')->name('quotepayment.already');
            Route::get('paymentstripe/success', 'paymentsuccess')->name('quotepayment.success');
            Route::get('paymentstripe/cancel', 'paymentcancel')->name('quotepayment.cancel');
            Route::get('paymentstripe/{inquiry_id}', 'paymentstripe')->name('front.paymentstripe');

            Route::get('paymentstorageorder/success', 'paymentstorageorder_success')->name('paymentstorageorder.success');
            Route::get('paymentstorageorder/cancel', 'paymentstorageorder_cancel')->name('paymentstorageorder.cancel');
            Route::get('paymentstorageorder/{order_id}', 'paymentstorageorder')->name('front.paymentstripe');
        });

        // Tabby dynamic installment AJAX
        Route::post('/tabby/check-installments', [TabbyController::class, 'fetchInstallments'])->name('tabby.check_installments');

        Route::controller(Croncontroller::class)->group(function () {

            Route::get('/package_inquiry_vendormailcron', 'package_inquiry_vendormailcron')->name('package_inquiry_vendormailcron');
        });

        // Route::get('/testapi/{id}/{order_id}', '\App\Http\Controllers\front\checkoutcontroller@success_msg_whatsapp_allVendor')->name('package-lists');

        Route::controller(Packagecontroller::class)->group(function () {

            Route::get('package-lists/{page_url}', 'package_lists')->name('front.package_lists');
        });

        Route::controller(Fronthomecontroller::class)->group(function () {

            // Route::get('/package-lists/{page_url}', '\App\Http\Controllers\front\Packagecontroller@package_lists')->name('package-lists');

            Route::get('/testapi', 'testwhatsapptemplate')->name('testapi');


            Route::get('service/{page_url}', 'subservices')->name('front.subservices');


            Route::get('/', 'index')->name('city.home');
        });
    });

require __DIR__ . '/auth.php';
