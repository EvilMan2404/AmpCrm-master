<?php


use App\Http\Controllers\BrandController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ClientGroupTypeController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FixedRateController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\IssuanceOfFinanceController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchasePaymentTypeController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\PurchaseStatusController;
use App\Http\Controllers\Requests\ServicesController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TasksPrioritiesController;
use App\Http\Controllers\TasksStatusesController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WasteTypesController;
use Illuminate\Support\Facades\Route;

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
Route::get('/calculator', function () {
    return view('components.calculator');
})->name('calculator');
Route::middleware('guest')->group(static function () {
    Route::get('/login', MainController::class.'@login')->name('login');
    Route::post('/auth', MainController::class.'@auth')->name('auth');
});
Route::middleware('auth')->group(static function () {
    Route::post('/logout', MainController::class.'@logout')->name('logout');
    Route::get('/home', MainController::class.'@index')->name('main');
    Route::get('/', MainController::class.'@index')->name('index');
    Route::get('/dashboard', DashboardController::class.'@index')->name('dashboard');
    Route::prefix('catalog')->group(static function () {
        Route::get('/', CatalogController::class.'@index')
            ->middleware('can:guard_catalog_view|guard_catalog_view_self')
            ->name('catalog.index');

        Route::get('/create', CatalogController::class.'@form')
            ->middleware('can:guard_catalog_write')
            ->name('catalog.create');

        Route::get('/edit/{id}', CatalogController::class.'@form')
            ->middleware('can:guard_catalog_edit|guard_catalog_edit_self')
            ->name('catalog.edit')->whereNumber('id');

        Route::get('/delete/{id}', CatalogController::class.'@delete')
            ->middleware('can:guard_catalog_delete|guard_catalog_delete_self')
            ->name('catalog.delete')->whereNumber('id');

        Route::post('/removeImage/{obj_id}/{image_id}', CatalogController::class.'@removeImage')
            ->middleware('can:guard_catalog_edit|guard_catalog_edit_self|guard_catalog_write')
            ->name('catalog.removeImage')
            ->whereNumber('obj_id')
            ->whereNumber('image_id');

        Route::post('/save/{id?}', CatalogController::class.'@save')->name('catalog.save')
            ->middleware('can:guard_catalog_edit|guard_catalog_edit_self|guard_catalog_write')
            ->whereNumber('id');

        Route::post('/upload', CatalogController::class.'@upload')
            ->middleware('can:guard_catalog_edit|guard_catalog_edit_self|guard_catalog_write')
            ->name('catalog.upload');

        Route::get('/info/{id}', CatalogController::class.'@view')
            ->middleware('can:guard_catalog_view|guard_catalog_view_self|guard_catalog_write')
            ->name('catalog.info')->whereNumber('id');

        Route::post('/course/settings/save', CatalogController::class.'@courseSave')->name('catalog.course.settings');
        Route::get('/course/clear', CatalogController::class.'@courseClear')->name('catalog.course.clear');
    });

    Route::prefix('company')->group(static function () {
        Route::get('/', CompanyController::class.'@index')
            ->middleware('can:guard_company_view_self|guard_company_view')
            ->name('company.index');


        Route::get('/info/{id}', CompanyController::class.'@view')
            ->middleware('can:guard_company_view|guard_company_view_self')
            ->name('company.info')->whereNumber('id');

        Route::get('/create', CompanyController::class.'@form')
            ->middleware('can:guard_company_add')
            ->name('company.create');


        Route::post('/save/{id?}', CompanyController::class.'@save')
            ->middleware('can:guard_company_edit_self|guard_company_edit|guard_company_add')
            ->name('company.save')
            ->whereNumber('id');


        Route::get('/edit/{id}', CompanyController::class.'@form')
            ->middleware('can:guard_company_edit_self|guard_company_edit')
            ->name('company.edit')->whereNumber('id');


        Route::get('/delete/{id}', CompanyController::class.'@delete')
            ->middleware('can:guard_company_delete_self|guard_company_delete')
            ->name('company.delete')->whereNumber('id');
    });

    Route::prefix('client')->group(static function () {
        Route::get('/', ClientsController::class.'@index')
            ->middleware('can:guard_clients_view|guard_clients_view_self')
            ->name('client.index');


        Route::get('/info/{id}', ClientsController::class.'@view')
            ->middleware('can:guard_clients_view|guard_clients_view_self')
            ->name('client.info')->whereNumber('id');


        Route::get('/create', ClientsController::class.'@form')
            ->middleware('can:guard_clients_add')
            ->name('client.create');


        Route::post('/save/{id?}', ClientsController::class.'@save')
            ->middleware('can:guard_clients_add|guard_clients_edit|guard_clients_edit_self')
            ->name('client.save')
            ->whereNumber('id');


        Route::get('/edit/{id}', ClientsController::class.'@form')
            ->middleware('can:guard_clients_edit|guard_clients_edit_self')
            ->name('client.edit')->whereNumber('id');


        Route::get('/delete/{id}', ClientsController::class.'@delete')
            ->middleware('can:guard_clients_delete|guard_clients_delete_self')
            ->name('client.delete')->whereNumber('id');
    });

    Route::prefix('stock')->group(static function () {
        Route::get('/', StockController::class.'@index')
            ->middleware('can:guard_stock_view|guard_stock_view_self')
            ->name('stock.index');

        Route::get('/info/{id}', StockController::class.'@view')
            ->middleware('can:guard_stock_view|guard_stock_view_self')
            ->name('stock.info')->whereNumber('id');

        Route::get('/create', StockController::class.'@form')
            ->middleware('can:guard_stock_add')
            ->name('stock.create');

        Route::post('/save/{id?}', StockController::class.'@save')
            ->middleware('can:guard_stock_add|guard_stock_edit|guard_stock_edit_self')
            ->name('stock.save')
            ->whereNumber('id');

        Route::get('/edit/{id}', StockController::class.'@form')
            ->middleware('can:guard_stock_edit|guard_stock_edit_self')
            ->name('stock.edit')->whereNumber('id');

        Route::get('/delete/{id}', StockController::class.'@delete')
            ->middleware('can:guard_stock_delete|guard_stock_delete_self')
            ->name('stock.delete')->whereNumber('id');
    });

    Route::prefix('users')->group(static function () {
        Route::get('/', UsersController::class.'@index')
            ->middleware('can:guard_users_view|guard_users_view_self')
            ->name('users.index');

        Route::get('/info/{id}', UsersController::class.'@view')
            ->middleware('can:guard_users_view|guard_users_view_self')
            ->name('users.info')->whereNumber('id');

        Route::get('/create', UsersController::class.'@form')
            ->middleware('can:guard_users_add')
            ->name('users.create');

        Route::post('/save/{id?}', UsersController::class.'@save')
            ->middleware('can:guard_users_edit|guard_users_edit_self|guard_users_add')
            ->name('users.save')
            ->whereNumber('id');

        Route::get('/edit/{id}', UsersController::class.'@form')
            ->middleware('can:guard_users_edit|guard_users_edit_self')
            ->name('users.edit')->whereNumber('id');

        Route::get('/delete/{id}', UsersController::class.'@delete')
            ->middleware('can:guard_users_delete|guard_users_delete_self')
            ->name('users.delete')->whereNumber('id');
    });

    Route::prefix('tasks')->group(static function () {
        Route::get('/', TaskController::class.'@index')
            ->middleware('can:guard_tasks_view|guard_tasks_view_self')
            ->name('tasks.index');

        Route::get('/info/{id}', TaskController::class.'@view')
            ->middleware('can:guard_tasks_view|guard_tasks_view_self')
            ->name('tasks.info')->whereNumber('id');

        Route::get('/create', TaskController::class.'@form')
            ->middleware('can:guard_tasks_add')
            ->name('tasks.create');


        Route::post('/save/{id?}', TaskController::class.'@save')
            ->middleware('can:guard_tasks_edit|guard_tasks_edit_self|guard_tasks_add')
            ->name('tasks.save')
            ->whereNumber('id');

        Route::get('/edit/{id}', TaskController::class.'@form')
            ->middleware('can:guard_tasks_edit|guard_tasks_edit_self')
            ->name('tasks.edit')->whereNumber('id');


        Route::get('/delete/{id}', TaskController::class.'@delete')
            ->middleware('can:guard_tasks_delete|guard_tasks_delete_self')
            ->name('tasks.delete')->whereNumber('id');


        Route::post('/upload', TaskController::class.'@upload')
            ->middleware('can:guard_tasks_edit|guard_tasks_edit_self|guard_tasks_add')
            ->name('tasks.upload');

        Route::post('/removeFile/{obj_id}/{image_id}', TaskController::class.'@removeFile')
            ->middleware('can:guard_tasks_edit|guard_tasks_edit_self|guard_tasks_add')
            ->name('tasks.removeFile')
            ->whereNumber('obj_id')
            ->whereNumber('image_id');

        Route::post('/get/file', TaskController::class.'@getFile')
            ->middleware('can:guard_tasks_view|guard_tasks_view_self')
            ->name('tasks.getFile');
    });

    Route::prefix('issuanceOfFinance')->group(static function () {
        Route::get('/', IssuanceOfFinanceController::class.'@index')
            ->middleware('can:guard_issuance_of_finance_view')
            ->name('issuanceOfFinance.index');
        Route::get('/create', IssuanceOfFinanceController::class.'@form')
            ->middleware('can:guard_issuance_of_finance_add')
            ->name('issuanceOfFinance.create');
        Route::post('/save/{id?}', IssuanceOfFinanceController::class.'@save')
            ->middleware('can:guard_issuance_of_finance_add')
            ->name('issuanceOfFinance.save')
            ->whereNumber('id');
    });

    Route::prefix('roles')->group(static function () {
        Route::get('/', RolesController::class.'@index')
            ->middleware('can:guard_roles_view')
            ->name('roles.index');

        Route::get('/create', RolesController::class.'@form')
            ->middleware('can:guard_roles_edit')
            ->name('roles.create');


        Route::post('/save/{id?}', RolesController::class.'@save')
            ->middleware('can:guard_roles_edit')
            ->name('roles.save')
            ->whereNumber('id');

        Route::get('/info/{id}', RolesController::class.'@view')
            ->middleware('can:guard_roles_edit')
            ->name('roles.info')->whereNumber('id');

        Route::get('/edit/{id}', RolesController::class.'@form')
            ->middleware('can:guard_roles_edit')
            ->name('roles.edit')->whereNumber('id');

        Route::get('/delete/{id}', RolesController::class.'@delete')
            ->middleware('can:guard_roles_edit')
            ->name('roles.delete')->whereNumber('id');
    });


    Route::prefix('request')->group(static function () {
        Route::post('/getCities', ServicesController::class.'@getCities')->name('request.getCities');
        Route::post('/getCategories', ServicesController::class.'@getCategories')->name('request.getCategories');
        Route::post('/getCatalog', ServicesController::class.'@getCatalog')->name('request.getCatalog');
        Route::post('/getLots', ServicesController::class.'@getLots')->name('request.getLots');
        Route::post('/getLot', ServicesController::class.'@getLot')->name('request.getLot');
        Route::post('/getCompanies', ServicesController::class.'@getCompanies')->name('request.getCompanies');
        Route::post('/getSerialNumber/{car_brand?}',
            ServicesController::class.'@getSerialNumber')->name('request.getSerialNumber');
        Route::post('/getUsers', ServicesController::class.'@getUsers')->name('request.getUsers');
        Route::post('/getIndustries', ServicesController::class.'@getIndustries')->name('request.getIndustries');
        Route::post('/getClientTypes', ServicesController::class.'@getClientTypes')->name('request.getClientTypes');
        Route::post('/getClientTypeGroups',
            ServicesController::class.'@getClientTypeGroups')->name('request.getClientTypeGroups');
        Route::post('/getClients', ServicesController::class.'@getClients')->name('request.getClients');
        Route::post('/getTeams', ServicesController::class.'@getTeams')->name('request.getTeams');
        Route::post('/getSpaces', ServicesController::class.'@getSpaces')->name('request.getSpaces');
        Route::post('/getCompanyLots',
            ServicesController::class.'@getCompanyLots')->name('request.getCompanyLots');
        Route::post('/getLotsAssigned',
            ServicesController::class.'@getLotsAssigned')->name('request.getLotsAssigned');
        Route::post('/getLotsOwner',
            ServicesController::class.'@getLotsOwner')->name('request.getLotsOwner');
        Route::post('/searchPurchase',
            ServicesController::class.'@searchPurchase')->name('request.searchPurchase');
        Route::post('/getStocks',
            ServicesController::class.'@getStocks')->name('request.getStocks');
        Route::post('/getStockOwner',
            ServicesController::class.'@getStockOwner')->name('request.getStockOwner');
        Route::post('/getCarBrand',
            ServicesController::class.'@getCarBrand')->name('request.getCarBrand');
        Route::post('/getPurchaseStatuses',
            ServicesController::class.'@getPurchaseStatuses')->name('request.getPurchaseStatuses');
        Route::post('/getPurchase',
            ServicesController::class.'@getPurchase')->name('request.getPurchase');
        Route::post('/getPurchaseInfo',
            ServicesController::class.'@getPurchaseInfo')->name('request.getPurchaseInfo');
        Route::post('/getPurchasePaymentTypes',
            ServicesController::class.'@getPurchasePaymentTypes')->name('request.getPurchasePaymentTypes');
        Route::post('/getTaskStatuses',
            ServicesController::class.'@getTaskStatuses')->name('request.getTaskStatuses');
        Route::post('/getTaskPriorities',
            ServicesController::class.'@getTaskPriorities')->name('request.getTaskPriorities');
        Route::post('/getSource',
            ServicesController::class.'@getSource')->name('request.getSource');
        Route::post('/getTasks',
            ServicesController::class.'@getTasks')->name('request.getTasks');
        Route::post('/getIssuance',
            ServicesController::class.'@getIssuance')->name('request.getIssuance');
        Route::post('/getPermissions',
            ServicesController::class.'@getPermissions')->name('request.getPermissions');
        Route::post('/getRoles',
            ServicesController::class.'@getRoles')->name('request.getRoles');
        Route::post('/getWasteTypes',
            ServicesController::class.'@getWasteTypes')->name('request.getWasteTypes');
        Route::post('/getPurchaseOwner',
            ServicesController::class.'@getPurchaseOwner')->name('request.getPurchaseOwner');

        Route::post('/getStockTotal',
            ServicesController::class.'@getStockTotal')->name('request.getStockTotal');

        Route::post('/getWasteInfo',
            ServicesController::class.'@getWasteInfo')->name('request.getWasteInfo');

        Route::post('/getPurchaseReports',
            ServicesController::class.'@getPurchaseReports')->name('request.getPurchaseReports');

        Route::post('/getPurchaseReportOwner',
            ServicesController::class.'@getPurchaseReportOwner')->name('request.getPurchaseReportOwner');
    });
    Route::prefix('purchase')->group(static function () {
        Route::get('/', PurchaseController::class.'@index')
            ->middleware('can:guard_purchase_view_self|guard_purchase_view')
            ->name('purchase.index');

        Route::get('/view/{id}',
            PurchaseController::class.'@view')
            ->middleware('can:guard_purchase_view_self|guard_purchase_view')
            ->name('purchase.view')->whereNumber('id');

        Route::get('/create', PurchaseController::class.'@form')
            ->middleware('can:guard_purchase_add')
            ->name('purchase.create');

        Route::get('/edit/{id}', PurchaseController::class.'@form')
            ->middleware('can:guard_purchase_edit|guard_purchase_edit_self')
            ->name('purchase.edit')->whereNumber('id');

        Route::get('/delete/{id}', PurchaseController::class.'@delete')
            ->middleware('can:guard_purchase_delete|guard_purchase_delete_self')
            ->name('purchase.delete')->whereNumber('id');

        Route::post('/save/{id?}', PurchaseController::class.'@save')
            ->middleware('can:guard_purchase_edit|guard_purchase_edit_self|guard_purchase_add')
            ->name('purchase.save')
            ->whereNumber('id');
    });

    Route::prefix('lots')->group(static function () {
        Route::get('/', FixedRateController::class.'@index')
            ->middleware('can:guard_lots_view_self|guard_lots_view')
            ->name('lots.index');


        Route::get('/info/{id}', FixedRateController::class.'@view')
            ->middleware('can:guard_lots_view|guard_lots_view_self')
            ->name('lots.info')->whereNumber('id');


        Route::get('/create', FixedRateController::class.'@form')
            ->middleware('can:guard_lots_add')
            ->name('lots.create');


        Route::post('/save/{id?}', FixedRateController::class.'@save')
            ->middleware('can:guard_lots_edit_self|guard_lots_edit|guard_lots_add')
            ->name('lots.save')
            ->whereNumber('id');


        Route::get('/edit/{id}', FixedRateController::class.'@form')
            ->middleware('can:guard_lots_edit_self|guard_lots_edit')
            ->name('lots.edit')->whereNumber('id');

        Route::get('/delete/{id}', FixedRateController::class.'@delete')
            ->middleware('can:guard_lots_delete|guard_lots_delete_self')
            ->name('lots.delete')->whereNumber('id');
    });

    Route::prefix('purchaseReports')->group(static function () {
        Route::get('/', PurchaseReportController::class.'@index')
            ->middleware('can:guard_purchaseReports_view_self|guard_purchaseReports_view')
            ->name('purchaseReports.index');


        Route::get('/create', PurchaseReportController::class.'@form')
            ->middleware('can:guard_purchaseReports_add')
            ->name('purchaseReports.create');

        Route::get('/download/{id}', PurchaseReportController::class.'@download')
            ->middleware('can:guard_purchaseReports_view_self|guard_purchaseReports_view')
            ->name('purchaseReports.download')->whereNumber('id');


        Route::post('/save/{id?}', PurchaseReportController::class.'@save')
            ->middleware('can:guard_purchaseReports_edit_self|guard_purchaseReports_edit|guard_purchaseReports_add')
            ->name('purchaseReports.save')
            ->whereNumber('id');


        Route::get('/edit/{id}', PurchaseReportController::class.'@form')
            ->middleware('can:guard_purchaseReports_edit_self|guard_purchaseReports_edit')
            ->name('purchaseReports.edit')->whereNumber('id');
    });


    Route::prefix('discount')->middleware('can:guard_discount')->group(static function () {
        Route::get('/', DiscountController::class.'@index')->name('discount.form');
        Route::post('/', DiscountController::class.'@index')->name('discount.save');
    });
    Route::prefix('administrating')->group(static function () {
        Route::prefix('space')->group(static function () {
            Route::get('/', SpaceController::class.'@index')->name('space.index');
            Route::get('/delete/{id}', SpaceController::class.'@delete')->name('space.delete')->whereNumber('id');
            Route::post('/save/{id?}', SpaceController::class.'@save')->name('space.save')
                ->whereNumber('id');
        });
        Route::prefix('industry')->group(static function () {
            Route::get('/', IndustryController::class.'@index')
                ->middleware('can:guard_industry_view')
                ->name('industry.index');

            Route::get('/delete/{id}', IndustryController::class.'@delete')
                ->middleware('can:guard_industry_edit')
                ->name('industry.delete')->whereNumber('id');

            Route::post('/save/{id?}', IndustryController::class.'@save')
                ->middleware('can:guard_industry_edit')
                ->name('industry.save')
                ->whereNumber('id');
        });

        Route::prefix('brand')->group(static function () {
            Route::get('/', BrandController::class.'@index')
                ->middleware('can:guard_brand_view')
                ->name('brand.index');

            Route::get('/delete/{id}', BrandController::class.'@delete')
                ->middleware('can:guard_brand_edit')
                ->name('brand.delete')->whereNumber('id');

            Route::post('/save/{id?}', BrandController::class.'@save')
                ->middleware('can:guard_brand_edit')
                ->name('brand.save')
                ->whereNumber('id');
        });

        Route::prefix('team')->group(static function () {
            Route::get('/', TeamController::class.'@index')
                ->middleware('can:guard_team_view')
                ->name('team.index');

            Route::get('/delete/{id}', TeamController::class.'@delete')
                ->middleware('can:guard_team_edit')
                ->name('team.delete')->whereNumber('id');

            Route::post('/save/{id?}', TeamController::class.'@save')
                ->middleware('can:guard_team_edit')
                ->name('team.save')
                ->whereNumber('id');
        });


        Route::prefix('purchaseStatus')->group(static function () {
            Route::get('/', PurchaseStatusController::class.'@index')
                ->middleware('can:guard_purchase_statuses_view')
                ->name('purchaseStatus.index');

            Route::get('/delete/{id}',
                PurchaseStatusController::class.'@delete')
                ->middleware('can:guard_purchase_statuses_edit')
                ->name('purchaseStatus.delete')->whereNumber('id');


            Route::post('/save/{id?}', PurchaseStatusController::class.'@save')
                ->middleware('can:guard_purchase_statuses_edit')
                ->name('purchaseStatus.save')
                ->whereNumber('id');
        });


        Route::prefix('purchasePaymentType')->group(static function () {
            Route::get('/', PurchasePaymentTypeController::class.'@index')
                ->middleware('can:guard_purchase_payment_type_view')
                ->name('purchasePaymentType.index');

            Route::get('/delete/{id}',
                PurchasePaymentTypeController::class.'@delete')
                ->middleware('can:guard_purchase_payment_type_edit')
                ->name('purchasePaymentType.delete')->whereNumber('id');

            Route::post('/save/{id?}', PurchasePaymentTypeController::class.'@save')
                ->middleware('can:guard_purchase_payment_type_edit')
                ->name('purchasePaymentType.save')
                ->whereNumber('id');
        });


        Route::prefix('clientType')->group(static function () {
            Route::get('/', ClientTypeController::class.'@index')
                ->middleware('can:guard_client_type_view')
                ->name('clientType.index');

            Route::get('/delete/{id}',
                ClientTypeController::class.'@delete')
                ->middleware('can:guard_client_type_edit')
                ->name('clientType.delete')->whereNumber('id');

            Route::post('/save/{id?}', ClientTypeController::class.'@save')
                ->middleware('can:guard_client_type_edit')
                ->name('clientType.save')
                ->whereNumber('id');
        });


        Route::prefix('clientGroupType')->group(static function () {
            Route::get('/', ClientGroupTypeController::class.'@index')
                ->middleware('can:guard_client_group_type_view')
                ->name('clientGroupType.index');

            Route::get('/delete/{id}',
                ClientGroupTypeController::class.'@delete')
                ->middleware('can:guard_client_group_type_edit')
                ->name('clientGroupType.delete')->whereNumber('id');

            Route::post('/save/{id?}', ClientGroupTypeController::class.'@save')
                ->middleware('can:guard_client_group_type_edit')
                ->name('clientGroupType.save')
                ->whereNumber('id');
        });

        Route::prefix('taskStatus')->group(static function () {
            Route::get('/', TasksStatusesController::class.'@index')
                ->middleware('can:guard_task_statuses_view')
                ->name('taskStatus.index');
            Route::get('/delete/{id}',
                TasksStatusesController::class.'@delete')
                ->middleware('can:guard_task_statuses_edit')
                ->name('taskStatus.delete')->whereNumber('id');
            Route::post('/save/{id?}', TasksStatusesController::class.'@save')
                ->middleware('can:guard_task_statuses_edit')
                ->name('taskStatus.save')
                ->whereNumber('id');
        });
        Route::prefix('taskPriority')
            ->group(static function () {
                Route::get('/', TasksPrioritiesController::class.'@index')
                    ->middleware('can:guard_task_priorities_view')
                    ->name('taskPriority.index');

                Route::get('/delete/{id}',
                    TasksPrioritiesController::class.'@delete')
                    ->middleware('can:guard_task_priorities_edit')
                    ->name('taskPriority.delete')->whereNumber('id');

                Route::post('/save/{id?}', TasksPrioritiesController::class.'@save')
                    ->middleware('can:guard_task_priorities_edit')
                    ->name('taskPriority.save')
                    ->whereNumber('id');
            });

        Route::prefix('permissions')->group(static function () {
            Route::get('/', PermissionsController::class.'@index')
                ->middleware('can:guard_permissions_view')
                ->name('permissions.index');


            Route::get('/delete/{id}',
                PermissionsController::class.'@delete')
                ->middleware('can:guard_permissions_edit')
                ->name('permissions.delete')->whereNumber('id');


            Route::post('/save/{id?}', PermissionsController::class.'@save')
                ->middleware('can:guard_permissions_edit')
                ->name('permissions.save')
                ->whereNumber('id');
        });

        Route::prefix('wasteTypes')->group(static function () {
            Route::get('/', WasteTypesController::class.'@index')
                ->middleware('can:guard_waste_types_view')
                ->name('wasteTypes.index');


            Route::get('/delete/{id}',
                WasteTypesController::class.'@delete')
                ->middleware('can:guard_waste_types_edit')
                ->name('wasteTypes.delete')->whereNumber('id');


            Route::post('/save/{id?}', WasteTypesController::class.'@save')
                ->middleware('can:guard_waste_types_edit')
                ->name('wasteTypes.save')
                ->whereNumber('id');
        });
    });
});
