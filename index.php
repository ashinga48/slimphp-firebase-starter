<?php
error_reporting(E_ALL);

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';
require './includes/settings.php';

// use \MyController as MyController;

$app = new \Slim\App(['settings' => $config]);


require './includes/dependencies.php';


// $container['controller.home'] = function($container) {
//     return new DemoControllerHomeController($container['view']);
// };

// $container['controller.weather'] = function($container) {
//     return new DemoControllerWeatherController($container['view']);
// };
//
// $app->get('/weather', "controller.weather:index");

$container = $app->getContainer();
// controller
$container['HomeController'] = function($container) {
    return new app\controllers\HomeController($container->get('db'));
};
$app->get('/a', 'HomeController:index');

$container['ContactController'] = function($container) {
    return new app\controllers\ContactController($container);
};
$app->get('/contact', 'ContactController:hello');


$app->get('/cornercarwash.json', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $this->logger->addInfo('Someone tried accessing credentials');
    $response->getBody()->write("no");

    return $response;
});

$app->get('/hello', function (Request $request, Response $response, array $args) {

  $serviceAccount = ServiceAccount::fromJsonFile('./test.json');
  $firebase = (new Factory)
      ->withServiceAccount($serviceAccount)
      ->create();
  // $tokenHandler = $firebase->getTokenHandler();
  $idTokenString = 'eyJhbGciOiJSUzI1NiIsImtpZCI6ImZkZjY0MWJmNDY3MTA1YzMyYWRkMDI3MGIyZTEyZDJiZTJhYmNjY2IiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL3NlY3VyZXRva2VuLmdvb2dsZS5jb20vdG91Y2hvbi1kMjliOCIsInVzZXJ0eXBlIjoic3VwZXJ1c2VyIiwiYXVkIjoidG91Y2hvbi1kMjliOCIsImF1dGhfdGltZSI6MTU0MTU1NzQwOSwidXNlcl9pZCI6IkxSYzY4cHFVTlBQdGtBSXRoeUlWRWt3TFlibDEiLCJzdWIiOiJMUmM2OHBxVU5QUHRrQUl0aHlJVkVrd0xZYmwxIiwiaWF0IjoxNTQxODIxMjMzLCJleHAiOjE1NDE4MjQ4MzMsImVtYWlsIjoia2VzYW5hbS5yYXZpQGdtYWlsLmNvbSIsImVtYWlsX3ZlcmlmaWVkIjpmYWxzZSwiZmlyZWJhc2UiOnsiaWRlbnRpdGllcyI6eyJlbWFpbCI6WyJrZXNhbmFtLnJhdmlAZ21haWwuY29tIl19LCJzaWduX2luX3Byb3ZpZGVyIjoicGFzc3dvcmQifX0.Oog1UHg_CSkjNy3mby6SSeaw9pS8Avyr6HAhSvPRvjRb7zqIWfRk_65XzCc7sgigHxD2YksDdnTRASuJKByJ06pZLAPCaN7o2noP-LLZNTTH-8mPR322XnhO2u5fsOEohqIzKymfP5o_kaHMALQp_-oqB1VcpbyUDsOFDoSVhVskJ4-8XkoF4bTiU8R0PE3B0L8GGNPXkPCQTYiIeRFGKPFky4znHk00SBbini_G6t-brtzCMUf4r2Sd1TCZfcJiPXZLEH_6Q2YFHPNjFDqshXfce6ndY-ILXQ0w83Gb5AzGfvTlG4te2vHiKYfgq7PlpX158ugCh3VlrGCPdfj6Ag';

  try {
    $verifiedIdToken = $firebase->getAuth()->verifyIdToken($idTokenString);
    $uid = $verifiedIdToken->getClaim('sub');
    echo json_encode($uid);
  } catch (Exception $e) {
      echo $e->getMessage();
  }
  $name = $args['name'];
  $response->getBody()->write("Hello, $name");
  return $response;

});


$app->get('/api', function (Request $request, Response $response, $args)   {
    $this->logger->addInfo('API Entry');
    // $vars = [
    //     'page' => [
    //     'title' => 'Welcome - Corner Car Wash.',
    //     'description' => 'Welcome to the official api.'
    //     ],
    // ];

    $vars['name'] = 'ravi';

    return $response->withJson($vars);
    //  return $this->view->render($response, 'home.twig', $vars);

})->setName('home');


// $container['MyController'] = function() {
// // note the use of the namespace
// // $container is injected to pass it to the class
// // constructor
// return new \MyController($container);
// }
// $app->get('/dbtest', 'MyController:users');
// $container[MyController::class] = function($c) {
// return new MyController($c->get(‘db’));
// };

// $app->get('/dbtest', 'MyController:index');
// $app->get('/dbtest', [new Controller\MyController, 'index']);
// $app->get('/dbtest', MyController::class . ':contact');
// $container['MyController'] = function ($container) {
//     // return an instantiated UserController here.
//     return new \App\Controllers\MyController($container);
// };
// $app->get('/user', 'MyController');
// $app->any('/user', 'MyController');


$app->get('/', function (Request $request, Response $response, $args)   {
    $this->logger->addInfo('Something interesting happened');
    //$name = $args['name'];
    //$response->getBody()->write("Hello, $name");
    //return $response;
    $vars = [
        'page' => [
        'title' => 'Welcome - Corner Car Wash.',
        'description' => 'Welcome to the official page.'
        ],
    ];

    return $this->view->render($response, 'home.twig', $vars);

})->setName('home');


$app->run();


?>
