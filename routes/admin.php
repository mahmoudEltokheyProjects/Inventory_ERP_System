<?php

use App\Http\Controllers\Admin\AccountsController;
use App\Http\Controllers\Admin\AccountTypesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\InvUomController;
use App\Http\Controllers\Admin\TreasuryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPanelSettingController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\SalesMaterialTypeController;
use App\Http\Controllers\Admin\InvItemCardController;
use App\Http\Controllers\Admin\SupplierCategoriesController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Models\AccountTypes\AccountType;
use App\Models\Supplier\SupplierCategory;
use App\Http\Controllers\Admin\InvItemCardCategoryController;
use App\Http\Controllers\Admin\SuppliersWithOrderController;
use App\Models\Supplier\SuppliersWithOrder;

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
    // Define Constant "PAGINATION_COUNT" : هذا الثابت متعرف داخل السيستم كله
    const PAGINATION_COUNT = 5;
    // ++++++++++++++++++++ Root Url = '/' : Show Login Form ++++++++++++++++++++
    Route::group(['middleware' => ['web'] ],function(){
    // ++++++++++ Show Login Form : [url = "/"] , Go To LoginForm ++++++++++
    Route::get('/', [LoginController::class, 'show_login_view'])->name('admin.showLogin');
    // ================================= Before Login =================================
    Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'guest:admin'],function()
    {
        // ++++++++++++++++++++  Show Login Form : [url = "admin/login/"] , ++++++++++++++++++++
        Route::get('login', [LoginController::class, 'show_login_view'])->name('admin.showLogin');
        // ++++++++++++++++++++ Store Login Form ++++++++++++++++++++
        Route::post('login', [LoginController::class, 'login'])->name('admin.login');
    });
    // ================================= After Login =================================
    Route::group(['prefix'=>'admin','middleware'=>'auth:admin'], function()
    {
        // +++++++++++++++++ Dashboard route +++++++++++++++++
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        //+++++++++++++++++  Admin Panel Settings routes +++++++++++++++++
        Route::get('admin-panel-setting/index', [AdminPanelSettingController::class, 'index'])->name('admin.adminPanelSetting.index');
        Route::get('admin-panel-setting/edit', [AdminPanelSettingController::class, 'edit'])->name('admin.adminPanelSetting.edit');
        Route::post('admin-panel-setting/update', [AdminPanelSettingController::class, 'update'])->name('admin.adminPanelSetting.update');
        Route::post('admin-panel-setting/fetch-states', [AdminPanelSettingController::class, 'fetchStates'])->name('admin.adminPanelSetting.fetchStates');
        Route::post('admin-panel-setting/fetch-cities', [AdminPanelSettingController::class, 'fetchCities'])->name('admin.adminPanelSetting.fetchCities');
        // ++++++++++++++++++++++++++ Resource : inv_item_card_categories ++++++++++++++++++++++++++
        // [ فئات الاصناف حيث كل وحدة بتنتمي لصنف معين ]
        Route::resource('inv_item_card_categories', InvItemCardCategoryController::class);
        // ++++++++++++++++++++ Treasury ++++++++++++++++++++++++
        // ======= index treasuries =======
        Route::get('treasuries/index',[TreasuryController::class,'index'])->name('admin.treasury.index');
        // ======= create treasuries =======
        Route::get('treasuries/create',[TreasuryController::class,'create'])->name('admin.treasury.create');
        // ======= store treasuries =======
        Route::post('treasuries/store',[TreasuryController::class,'store'])->name('admin.treasury.store');
        // ======= edit treasury =======
        Route::get('treasuries/edit/{id}',[TreasuryController::class,'edit'])->name('admin.treasury.edit');
        // ======= update treasuries =======
        Route::post('treasuries/update',[TreasuryController::class,'update'])->name('admin.treasury.update');
        // ======= show treasury =======
        Route::get('treasuries/show/{id}',[TreasuryController::class,'show'])->name('admin.treasury.show');
        // ======= delete treasury =======
        Route::delete('treasuries/delete',[TreasuryController::class,'delete'])->name('admin.treasury.delete');
        // ======= ajax_search treasury =======
        Route::post('treasuries/ajax_search',[TreasuryController::class,'ajax_search'])->name('admin.treasury.ajax_search');
        // ++++++++++++++++++++ treasury_delivery ++++++++++++++++++++++++
        // ======= add treasury_delivery =======
        Route::get('treasuries/add_treasury_delivery/{id}',[TreasuryController::class,'add_treasury_delivery'])->name('admin.treasury.add_treasury_delivery');
        // ======= store treasury_delivery =======
        Route::post('treasuries/store_treasury_delivery/{id}',[TreasuryController::class,'store_treasury_delivery'])->name('admin.treasury.store_treasury_delivery');
        // ======= delete treasury_delivery =======
        Route::delete('treasuries/delete_treasury_delivery',[TreasuryController::class,'delete_treasury_delivery'])->name('admin.treasury.delete_treasury_delivery');
        // ++++++++++++++++++++ Sales Material Types ++++++++++++++++++++++++
        // ======= index sales_material_types =======
        Route::get('sales_material_types/index',[SalesMaterialTypeController::class,'index'])->name('admin.sales_material_types.index');
        // ======= create sales_material_types =======
        Route::get('sales_material_types/create',[SalesMaterialTypeController::class,'create'])->name('admin.sales_material_types.create');
        // ======= show sales_material_types =======
        Route::get('sales_material_types/show/{id}',[SalesMaterialTypeController::class,'show'])->name('admin.sales_material_types.show');
        // ======= edit sales_material_types =======
        Route::get('sales_material_types/edit/{id}',[SalesMaterialTypeController::class,'edit'])->name('admin.sales_material_types.edit');
        // ======= store sales_material_types =======
        Route::post('sales_material_types/store',[SalesMaterialTypeController::class,'store'])->name('admin.sales_material_types.store');
        // ======= update sales_material_types =======
        Route::post('sales_material_types/update',[SalesMaterialTypeController::class,'update'])->name('admin.sales_material_types.update');
        // ======= delete sales_material_types =======
        Route::delete('sales_material_types/delete',[SalesMaterialTypeController::class,'delete'])->name('admin.sales_material_types.delete');
        // ++++++++++++++++++++ Stores ++++++++++++++++++++++++
        // ======= index Stores =======
        Route::get('stores/index',[StoreController::class,'index'])->name('admin.stores.index');
        // ======= create sales_material_types =======
        Route::get('stores/create',[StoreController::class,'create'])->name('admin.stores.create');
        // ======= show stores =======
        Route::get('stores/show/{id}',[StoreController::class,'show'])->name('admin.stores.show');
        // ======= edit stores =======
        Route::get('stores/edit/{id}',[StoreController::class,'edit'])->name('admin.stores.edit');
        // ======= store stores =======
        Route::post('stores/store',[StoreController::class,'store'])->name('admin.stores.store');
        // ======= update stores =======
        Route::post('stores/update',[StoreController::class,'update'])->name('admin.stores.update');
        // ======= delete stores =======
        Route::delete('stores/delete/{id}',[StoreController::class,'delete'])->name('admin.stores.delete');
        // ++++++++++++++++++++ uoms [ unit of measurments وحدات القياس] ++++++++++++++++++++++++
        // ======= index Stores =======
        Route::get('uoms/index',[InvUomController::class,'index'])->name('admin.uoms.index');
        // ======= create sales_material_types =======
        Route::get('uoms/create',[InvUomController::class,'create'])->name('admin.uoms.create');
        // ======= show uoms =======
        Route::get('uoms/show/{id}',[InvUomController::class,'show'])->name('admin.uoms.show');
        // ======= edit uoms =======
        Route::get('uoms/edit/{id}',[InvUomController::class,'edit'])->name('admin.uoms.edit');
        // ======= store uoms =======
        Route::post('uoms/store',[InvUomController::class,'store'])->name('admin.uoms.store');
        // ======= update uoms =======
        Route::post('uoms/update',[InvUomController::class,'update'])->name('admin.uoms.update');
        // ======= delete uoms =======
        Route::delete('uoms/delete/{id}',[InvUomController::class,'destroy'])->name('admin.uoms.delete');
        // ======= ajax_search inv_uoms =======
        Route::post('uoms/ajax_search',[InvUomController::class,'ajax_search'])->name('admin.uoms.ajax_search');
        // ++++++++++++++++++++++++++ Resource : inv_item_cards ++++++++++++++++++++++++++
        //  [ الاصناف ذي اللحوم و الفراخ ]
        Route::resource('inv_item_cards',InvItemCardController::class);
        // Download Attachmenets For Students in "show page" of "student"
        Route::get('/download_attachment/{fileName}', [InvItemCardController::class,'Download_attachment'])->name('admin.item_card.Download_attachment');
        // "view attachment" route
        Route::get('/view_attachment/{fileName}', [InvItemCardController::class,'view_attachment'])->name('admin.item_card.view_attachment');
        // Delete Photo in "show page" of "item"
        Route::delete('/delete_attachment', [InvItemCardController::class,'Delete_attachment'])->name('admin.item_card.Delete_attachment');
        // ======= ajax_search inv_uoms =======
        Route::post('inv_item_cards/ajax_search',[InvItemCardController::class,'ajax_search'])->name('admin.item_card.ajax_search');
        // ++++++++++++++++++++++++++ Account Types ++++++++++++++++++++++++++
        // ====== index ======
        Route::get('accountTypes/index',[AccountTypesController::class,'index'])->name('admin.accountTypes.index');
        // ====== create ======
        Route::get('accountTypes/create',[AccountTypesController::class,'create'])->name('admin.accountTypes.create');
        // ====== store ======
        Route::post('accountTypes/store',[AccountTypesController::class,'store'])->name('admin.accountTypes.store');
        // ++++++++++++++++++++++++++ Accounts ++++++++++++++++++++++++++
        // ====== index ======
        Route::get('accounts/index',[AccountsController::class,'index'])->name('admin.accounts.index');
        // ====== create ======
        Route::get('accounts/create',[AccountsController::class,'create'])->name('admin.accounts.create');
        // ====== store ======
        Route::post('accounts/store',[AccountsController::class,'store'])->name('admin.accounts.store');
        // ====== show ======
        Route::get('accounts/show/{id}',[AccountsController::class,'show'])->name('admin.accounts.show');
        // ======= edit =======
        Route::get('accounts/edit/{id}',[AccountsController::class,'edit'])->name('admin.accounts.edit');
        // ======= update =======
        Route::post('accounts/update',[AccountsController::class,'update'])->name('admin.accounts.update');
        // ======= delete =======
        Route::delete('accounts/delete',[AccountsController::class,'destroy'])->name('admin.accounts.destroy');
        // ======= ajax_search =======
        Route::post('accounts/ajax_search',[AccountsController::class,'ajax_search'])->name('admin.accounts.ajax_search');
        // ++++++++++++++++++++++++++ Customers ++++++++++++++++++++++++++
        Route::resource('customers',CustomerController::class);
        // customers : ajax search
        Route::post('customers/ajax_search',[CustomerController::class,'ajax_search'])->name('admin.customers.ajax_search');
        // ++++++++++++++++++++++++++ Suppliers_categories ++++++++++++++++++++++++++
        // index
        Route::get('suppliers_categories/index',[SupplierCategoriesController::class,'index'])->name('admin.suppliers_categories.index');
        // show
        Route::get('suppliers_categories/show/{id}',[SupplierCategoriesController::class,'show'])->name('admin.suppliers_categories.show');
        // create
        Route::get('suppliers_categories/create',[SupplierCategoriesController::class,'create'])->name('admin.suppliers_categories.create');
        // store
        Route::post('suppliers_categories/store',[SupplierCategoriesController::class,'store'])->name('admin.suppliers_categories.store');
        // edit
        Route::get('suppliers_categories/edit/{id}',[SupplierCategoriesController::class,'edit'])->name('admin.suppliers_categories.edit');
        // update
        Route::post('suppliers_categories/update',[SupplierCategoriesController::class,'update'])->name('admin.suppliers_categories.update');
        // delete
        Route::delete('suppliers_categories/destroy',[SupplierCategoriesController::class,'destroy'])->name('admin.suppliers_categories.destroy');
        // ++++++++++++++++++++++++++ Suppliers ++++++++++++++++++++++++++
        // index
        Route::get('suppliers/index',[SuppliersController::class,'index'])->name('admin.suppliers.index');
        // create
        Route::get('suppliers/create',[SuppliersController::class,'create'])->name('admin.suppliers.create');
        // store
        Route::post('suppliers/store',[SuppliersController::class,'store'])->name('admin.suppliers.store');
        // show
        Route::get('suppliers/show/{id}',[SuppliersController::class,'show'])->name('admin.suppliers.show');
        // edit
        Route::get('suppliers/edit/{id}',[SuppliersController::class,'edit'])->name('admin.suppliers.edit');
        // update
        Route::post('suppliers/update',[SuppliersController::class,'update'])->name('admin.suppliers.update');
        // ajax_search
        Route::post('suppliers/ajax_search',[SuppliersController::class,'ajax_search'])->name('admin.suppliers.ajax_search');
        // delete
        Route::delete('suppliers/destroy',[SuppliersController::class,'destroy'])->name('admin.suppliers.delete');
        // ++++++++++++++++++++++++++ suppliers_orders ++++++++++++++++++++++++++
        // index
        Route::get('suppliers_orders/index',[SuppliersWithOrderController::class,'index'])->name('admin.suppliers_orders.index');
        // create
        Route::get('suppliers_orders/create',[SuppliersWithOrderController::class,'create'])->name('admin.suppliers_orders.create');
        // store
        Route::post('suppliers_orders/store',[SuppliersWithOrderController::class,'store'])->name('admin.suppliers_orders.store');
        // show
        Route::get('suppliers_orders/show/{id}',[SuppliersWithOrderController::class,'show'])->name('admin.suppliers_orders.show');
        // edit
        Route::get('suppliers_orders/edit/{id}',[SuppliersWithOrderController::class,'edit'])->name('admin.suppliers_orders.edit');
        // update
        Route::post('suppliers_orders/update',[SuppliersWithOrderController::class,'update'])->name('admin.suppliers_orders.update');
        // ajax_search
        Route::post('suppliers_orders/ajax_search',[SuppliersWithOrderController::class,'ajax_search'])->name('admin.suppliers_orders.ajax_search');
        // delete
        Route::delete('suppliers_orders/destroy',[SuppliersWithOrderController::class,'destroy'])->name('admin.suppliers_orders.delete');
        // ++++++++++++++++++++++++++ suppliers_orders_details ++++++++++++++++++++++++++

        // ++++++++++++++++++++ logout ++++++++++++++++++++
        Route::post('logout', [LoginController::class,'logout'])->name('admin.logout');
    });
});
