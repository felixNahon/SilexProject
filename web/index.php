<?php 
require_once __DIR__.'/../vendor/autoload.php';

use Silex\Application; 
use Silex\Provider\TwigServiceProvider as Twig;

const DB_HOST = 'localhost';
const DB_DATABASE = 'portfolio';
const DB_USERNAME = 'root';
const DB_PASSWORD = '';

$app = new Silex\Application(); // application Silex 

$twig= new Twig();  

$app['debug']=true;

// databases                      
$app['database.config'] = [
        'dsn'      => 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE,
        'username' => 'root',
        'password' => '',
        'options'  => [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", // flux en utf8
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // mysql erreurs remontées sous forme d'exception
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // tous les fetch en objets
        ]
  
];


//PDO 
$app['pdo'] = function($app){

	$options = $app['database.config'];

  	return new \PDO($options['dsn'], $options['username'], $options['password'], $options['options']);
}; 

//loader Twig 

$app->register(new Twig(), [
	"twig.path" => __DIR__ . '/../views']); 


$app->get('/', function() use($app) {

	$parameters = 'bonjour bono!!';
	


	return $app['twig']->render('Front/home.twig', [
		'formulaire'=>'']); 	

});



$app->get('form', function() use($app) {
    return $app['twig']->render('Front/form.twig');
});

$app->run();