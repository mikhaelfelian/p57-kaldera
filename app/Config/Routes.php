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

    // Master management
    $routes->get('master', 'TargetFisikKeu::master', ['as' => 'tfk.master']);
    $routes->post('master/store', 'TargetFisikKeu::masterStore', ['as' => 'tfk.master.store']);
    $routes->post('master/delete/(:num)', 'TargetFisikKeu::masterDelete/$1', ['as' => 'tfk.master.delete']);
    
    // CSRF refresh
    $routes->get('refresh-csrf', 'TargetFisikKeu::refreshCSRF', ['as' => 'tfk.refresh_csrf']);
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
