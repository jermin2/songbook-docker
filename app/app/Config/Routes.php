<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes(true);

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Song::index');

$routes->match(['get', 'post'], 'create', 'Book::create');
$routes->match(['get', 'post'], 'book/createPDF', 'Book::createPDF');
$routes->match(['get', 'post'], 'book/saveBook', 'Book::saveBook');
$routes->match(['get', 'post'], 'book/loadBook', 'Book::loadBook');
$routes->get('books', 'Book::index');
$routes->get('book/(:segment)', 'Book::view/$1');

$routes->get('book/testPDF', 'Book::testPDF');
$routes->match(['get', 'post'], 'load', 'Song::load');

$routes->match(['get', 'post'], 'song/edit/(:segment)', 'Song::edit/$1');

$routes->get('song/createPDF/(:segment)', 'Song::createPDF/$1');
$routes->get('song/(:segment)', 'Song::view/$1');
$routes->get('songs', 'Song::index');

$routes->match(['get', 'post'], 'news/create', 'News::create');
$routes->get('news/(:segment)', 'News::view/$1');
$routes->get('news', 'News::index');
$routes->get('(:any)', 'Pages::showme/$1');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
