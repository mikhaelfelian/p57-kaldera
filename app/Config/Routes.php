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

    // Input/create (redirects to index with master_id)
    $routes->get('input', 'TargetFisikKeu::index', ['as' => 'tfk.input']);
    $routes->get('input/(:num)', 'TargetFisikKeu::index', ['as' => 'tfk.input.id']);
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
