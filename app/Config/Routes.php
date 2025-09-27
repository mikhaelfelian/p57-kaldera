<?php

use CodeIgniter\Router\RouteCollection;

/**
 * ---------------------------------------------------------------
 * Application Routes
 * ---------------------------------------------------------------
 * All application routes are defined here in a structured manner.
 * - Root
 * - Authentication
 * - Dashboard
 * - Public APIs
 * - Settings (Pengaturan)
 * - Utility/Test
 * ---------------------------------------------------------------
 * @var RouteCollection $routes
 */

// ==================== Root ====================
$routes->get(
    '/',
    'Auth::login',
    [
        'namespace' => 'App\Controllers',
        'as'        => 'root',
    ]
);

/**
 * Authentication Routes
 *
 * Handles all authentication processes:
 * - Login (regular and cashier)
 * - Logout
 * - Forgot Password
 */
$routes->group('auth', ['namespace' => 'App\Controllers'], static function ($routes) {
    // Index / auth landing page
    $routes->get('/', 'Auth::index', ['as' => 'auth.index']);

    // Login form
    $routes->get('login', 'Auth::login', ['as' => 'auth.login']);

    // Login processing
    $routes->post('cek_login', 'Auth::cek_login', ['as' => 'auth.login.attempt']);

    // Logout (POST preferred for security)
    $routes->post('logout', 'Auth::logout', ['as' => 'auth.logout']);

    // Legacy GET logout (temporary; can be removed later)
    $routes->get('logout', 'Auth::logout');

    // Forgot password (form and submit)
    $routes->get('forgot-password', 'Auth::forgot_password', ['as' => 'auth.forgot']);
    $routes->post('forgot-password', 'Auth::forgot_password', ['as' => 'auth.forgot.submit']);
});

// ==================== Dashboard ====================
$routes->group('dashboard', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Dashboard::index', ['as' => 'dashboard.index']);
    $routes->get('enhanced-features', 'Dashboard::enhancedFeatures', ['as' => 'dashboard.enhanced_features']);
    $routes->get('system-overview', 'Dashboard::systemOverview', ['as' => 'dashboard.system_overview']);
});

// ==================== Target Fisik & Keuangan (TFK) ====================
$routes->group('tfk', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    // Master/Data list
    $routes->get('/', 'TargetFisikKeu::index', ['as' => 'tfk.index']);
    $routes->get('data', 'TargetFisikKeu::index', ['as' => 'tfk.data']);

    // Input manual page
    $routes->get('input', 'TargetFisikKeu::input', ['as' => 'tfk.input']);
    $routes->get('input/(:num)', 'TargetFisikKeu::input/$1', ['as' => 'tfk.input.id']);
    $routes->post('store', 'TargetFisikKeu::store', ['as' => 'tfk.store']);
    // Rekap
    $routes->get('rekap', 'TargetFisikKeu::rekap', ['as' => 'tfk.rekap']);
    $routes->get('rekap/export-excel', 'TargetFisikKeu::rekapExportExcel', ['as' => 'tfk.rekap.export_excel']);
    $routes->get('rekap/export-pdf', 'TargetFisikKeu::rekapExportPDF', ['as' => 'tfk.rekap.export_pdf']);

    // Master management
    $routes->get('master', 'TargetFisikKeu::master', ['as' => 'tfk.master']);
    $routes->post('master/store', 'TargetFisikKeu::masterStore', ['as' => 'tfk.master.store']);
    $routes->post('master/delete/(:num)', 'TargetFisikKeu::masterDelete/$1', ['as' => 'tfk.master.delete']);
    
    // CSRF refresh
    $routes->get('refresh-csrf', 'TargetFisikKeu::refreshCSRF', ['as' => 'tfk.refresh_csrf']);
});

// ==================== Belanja (alias routes to TFK controller) ====================
$routes->group('belanja', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('master', 'TargetFisikKeu::master', ['as' => 'belanja.master']);
    $routes->get('master/get', 'TargetFisikKeu::belanjaMasterGet', ['as' => 'belanja.master.get']);
    $routes->get('input', 'TargetFisikKeu::belanjaInput', ['as' => 'belanja.input']);
    $routes->post('input/save', 'TargetFisikKeu::belanjaInputSave', ['as' => 'belanja.input.save']);
    $routes->get('rekap', 'TargetFisikKeu::belanjaRekap', ['as' => 'belanja.rekap']);
    $routes->get('rekap/export-excel', 'TargetFisikKeu::belanjaRekapExportExcel', ['as' => 'belanja.rekap.export_excel']);
    $routes->get('rekap/export-pdf', 'TargetFisikKeu::belanjaRekapExportPDF', ['as' => 'belanja.rekap.export_pdf']);
    $routes->post('master/update', 'TargetFisikKeu::belanjaMasterUpdate', ['as' => 'belanja.master.update']);
});

// ==================== Pendapatan ====================
$routes->group('pendapatan', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('master', 'Pendapatan::master', ['as' => 'pendapatan.master']);
    $routes->get('master/get', 'Pendapatan::pendapatanMasterGet', ['as' => 'pendapatan.master.get']);
    $routes->post('master/update', 'Pendapatan::pendapatanMasterUpdate', ['as' => 'pendapatan.master.update']);
    $routes->get('input', 'PendapatanInput::input', ['as' => 'pendapatan.input']);
    $routes->post('input/save', 'PendapatanInput::inputSave', ['as' => 'pendapatan.input.save']);
    $routes->get('rekap', 'PendapatanInput::rekap', ['as' => 'pendapatan.rekap']);
    $routes->get('rekap/export-excel', 'PendapatanInput::rekapExportExcel', ['as' => 'pendapatan.rekap.export_excel']);
    $routes->get('rekap/export-pdf', 'PendapatanInput::rekapExportPDF', ['as' => 'pendapatan.rekap.export_pdf']);
});

// ==================== AJAX Routes (No CSRF) ====================
$routes->post('tfk/update-cell', 'TargetFisikKeu::updateCell', ['as' => 'tfk.update_cell']);

// ==================== Public API ====================
$routes->group('publik', function ($routes) {
    $routes->get('items', 'Publik::getItems');
    $routes->get('items_stock', 'Publik::getItemsStock');
    $routes->get('satuan', 'Publik::getSatuan');
});

// ==================== Gender Module ====================
$routes->group('gender', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Gender::index', ['as' => 'gender.index']);
    $routes->post('store', 'Gender::store', ['as' => 'gender.store']);
    $routes->get('preview/(:num)', 'Gender::preview/$1', ['as' => 'gender.preview']);
    $routes->get('download/(:num)', 'Gender::download/$1', ['as' => 'gender.download']);
    $routes->post('delete/(:num)', 'Gender::delete/$1', ['as' => 'gender.delete']);
});

// ==================== Manajemen Risiko Module ====================
$routes->group('risiko', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Risiko::index', ['as' => 'risiko.index']);
    $routes->post('store', 'Risiko::store', ['as' => 'risiko.store']);
    $routes->get('preview/(:num)', 'Risiko::preview/$1', ['as' => 'risiko.preview']);
    $routes->get('download/(:num)', 'Risiko::download/$1', ['as' => 'risiko.download']);
    $routes->post('delete/(:num)', 'Risiko::delete/$1', ['as' => 'risiko.delete']);
});

// ==================== SDGs Module ====================
$routes->group('sdgs', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Sdgs::index', ['as' => 'sdgs.index']);
    $routes->post('store', 'Sdgs::store', ['as' => 'sdgs.store']);
    $routes->get('preview/(:num)', 'Sdgs::preview/$1', ['as' => 'sdgs.preview']);
    $routes->get('download/(:num)', 'Sdgs::download/$1', ['as' => 'sdgs.download']);
    $routes->post('delete/(:num)', 'Sdgs::delete/$1', ['as' => 'sdgs.delete']);
});

// ==================== Gulkin Module ====================
$routes->group('gulkin', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Gulkin::index', ['as' => 'gulkin.index']);
    $routes->post('store', 'Gulkin::store', ['as' => 'gulkin.store']);
    $routes->get('preview/(:num)', 'Gulkin::preview/$1', ['as' => 'gulkin.preview']);
    $routes->get('download/(:num)', 'Gulkin::download/$1', ['as' => 'gulkin.download']);
    $routes->post('delete/(:num)', 'Gulkin::delete/$1', ['as' => 'gulkin.delete']);
});

// ==================== LINKS (Web GIS ESDM) ====================
$routes->group('links', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Links::index', ['as' => 'links.index']);
    $routes->post('store', 'Links::store', ['as' => 'links.store']);
    $routes->post('delete/(:num)', 'Links::delete/$1', ['as' => 'links.delete']);
});

// ==================== ESDM Feedbacks ====================
$routes->group('esdm-feedbacks', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'EsdmFeedbacks::index', ['as' => 'esdm_feedbacks.index']);
    $routes->post('store', 'EsdmFeedbacks::store', ['as' => 'esdm_feedbacks.store']);
    $routes->post('delete/(:num)', 'EsdmFeedbacks::delete/$1', ['as' => 'esdm_feedbacks.delete']);
});

// Backward-compatible alias (singular URL)
$routes->get('esdm-feedback', 'EsdmFeedbacks::index');

// ==================== Upload Laporan ====================
$routes->group('uploads', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Uploads::index', ['as' => 'uploads.index']);
    $routes->post('store', 'Uploads::store', ['as' => 'uploads.store']);
    $routes->get('preview/(:num)', 'Uploads::preview/$1', ['as' => 'uploads.preview']);
    $routes->get('download/(:num)', 'Uploads::download/$1', ['as' => 'uploads.download']);
    $routes->post('delete/(:num)', 'Uploads::delete/$1', ['as' => 'uploads.delete']);
});

// ==================== Indikator Module ====================
$routes->group('indikator', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    // Metadata routes
    $routes->get('metadata', 'IndikatorMeta::metadata', ['as' => 'indikator.metadata']);
    $routes->post('upload', 'IndikatorMeta::upload', ['as' => 'indikator.upload']);
    $routes->get('view/(:num)', 'IndikatorMeta::viewData/$1', ['as' => 'indikator.view']);
    $routes->get('download/(:num)', 'IndikatorMeta::download/$1', ['as' => 'indikator.download']);
    
    // Input routes
    $routes->get('input', 'IndikatorInput::input', ['as' => 'indikator.input']);
    $routes->post('input/save', 'IndikatorInput::save', ['as' => 'indikator.input.save']);
    $routes->post('input/upload-catatan', 'IndikatorInput::uploadCatatan', ['as' => 'indikator.input.upload_catatan']);
    $routes->post('input/upload-rencana', 'IndikatorInput::uploadRencana', ['as' => 'indikator.input.upload_rencana']);
    $routes->get('input/preview/(:num)', 'IndikatorInput::preview/$1', ['as' => 'indikator.input.preview']);
    $routes->get('input/download-catatan/(:num)', 'IndikatorInput::downloadCatatan/$1', ['as' => 'indikator.input.download_catatan']);
    $routes->get('input/download-rencana/(:num)', 'IndikatorInput::downloadRencana/$1', ['as' => 'indikator.input.download_rencana']);
    
    // Rekap routes
    $routes->get('rekap', 'IndikatorInput::rekap', ['as' => 'indikator.rekap']);
});

// ==================== PBJ (Pengadaan Barang dan Jasa) ====================
$routes->group('pbj', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('input', 'Pbj::input', ['as' => 'pbj.input']);
    $routes->get('input/indeks', 'Pbj::input', ['as' => 'pbj.input.indeks']);
    $routes->post('input/save', 'Pbj::save', ['as' => 'pbj.input.save']);
    $routes->get('input/realisasi_pdn', 'PbjPdn::realisasi_pdn', ['as' => 'pbj.input.realisasi_pdn']);
    $routes->post('input/realisasi_pdn/save', 'PbjPdn::save', ['as' => 'pbj.input.realisasi_pdn.save']);
    $routes->get('input/progres', 'PbjProgres::progres', ['as' => 'pbj.input.progres']);
    $routes->post('input/progres/save', 'PbjProgres::save', ['as' => 'pbj.input.progres.save']);
    $routes->post('input/progres/update-status', 'PbjProgres::updateStatus', ['as' => 'pbj.input.progres.update_status']);
    
    // Rekap routes
    $routes->get('rekap/indeks', 'Pbj::rekap_indeks', ['as' => 'pbj.rekap.indeks']);
    $routes->get('rekap/realisasi_pdn', 'PbjPdn::rekap_realisasi_pdn', ['as' => 'pbj.rekap.realisasi_pdn']);
    $routes->get('rekap/progres', 'PbjProgres::rekap_progres', ['as' => 'pbj.rekap.progres']);
});

// ==================== Bantuan ====================
$routes->group('bantuan', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('hibah', 'BanmasHibah::hibah', ['as' => 'bantuan.hibah']);
    $routes->post('hibah/save', 'BanmasHibah::save', ['as' => 'bantuan.hibah.save']);
    $routes->post('hibah/upload', 'BanmasHibah::upload', ['as' => 'bantuan.hibah.upload']);
    $routes->get('hibah/preview/(:num)', 'BanmasHibah::preview/$1', ['as' => 'bantuan.hibah.preview']);
    $routes->get('hibah/download/(:num)', 'BanmasHibah::download/$1', ['as' => 'bantuan.hibah.download']);
    
    $routes->get('bansos', 'BanmasBansos::bansos', ['as' => 'bantuan.bansos']);
    $routes->post('bansos/save', 'BanmasBansos::save', ['as' => 'bantuan.bansos.save']);
    $routes->post('bansos/upload', 'BanmasBansos::upload', ['as' => 'bantuan.bansos.upload']);
    $routes->get('bansos/preview/(:num)', 'BanmasBansos::preview/$1', ['as' => 'bantuan.bansos.preview']);
    $routes->get('bansos/download/(:num)', 'BanmasBansos::download/$1', ['as' => 'bantuan.bansos.download']);
    
    $routes->get('barang', 'BanmasBs::barang', ['as' => 'bantuan.barang']);
    $routes->post('barang/save', 'BanmasBs::save', ['as' => 'bantuan.barang.save']);
    $routes->post('barang/upload', 'BanmasBs::upload', ['as' => 'bantuan.barang.upload']);
    $routes->get('barang/preview/(:num)', 'BanmasBs::preview/$1', ['as' => 'bantuan.barang.preview']);
    $routes->get('barang/download/(:num)', 'BanmasBs::download/$1', ['as' => 'bantuan.barang.download']);
});

// ==================== PK (Rancangan Aksi Perubahan) ====================
$routes->group('pk', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Pg::pk', ['as' => 'pk.index']);
    $routes->post('save', 'Pg::save', ['as' => 'pk.save']);
    $routes->post('upload', 'Pg::upload', ['as' => 'pk.upload']);
    $routes->get('preview/(:num)', 'Pg::preview/$1', ['as' => 'pk.preview']);
    $routes->get('download/(:num)', 'Pg::download/$1', ['as' => 'pk.download']);
});

// ==================== PT Master UKP ====================
$routes->group('pt', ['namespace' => 'App\\Controllers', 'filter' => 'auth'], function ($routes) {
    $routes->group('master', function ($routes) {
        $routes->get('ukp', 'Ukp::master', ['as' => 'pt.master.ukp']);
        $routes->post('ukp/create', 'Ukp::create', ['as' => 'pt.master.ukp.create']);
        $routes->post('ukp/update/(:num)', 'Ukp::update/$1', ['as' => 'pt.master.ukp.update']);
        $routes->post('ukp/delete/(:num)', 'Ukp::delete/$1', ['as' => 'pt.master.ukp.delete']);
        $routes->get('ukp/get/(:num)', 'Ukp::get/$1', ['as' => 'pt.master.ukp.get']);
    });
});

// ==================== Settings (Pengaturan) ====================
$routes->group('pengaturan', ['namespace' => 'App\Controllers', 'filter' => 'auth'], function ($routes) {
    // App settings
    $routes->get('app', 'Pengaturan::index');
});

// ==================== Utility/Test ====================
$routes->group('home', function ($routes) {
    $routes->get('test', 'Home::test');
    $routes->get('test2', 'Home::test2');
});
