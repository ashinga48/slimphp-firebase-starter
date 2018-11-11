<?php


//setting logs
$container = $app->getContainer();
$container['logger'] = function($c) {
    $cf = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger('my_logger');
    $file_handler = new \Monolog\Handler\StreamHandler($cf['path']);
    $logger->pushHandler($file_handler);
    return $logger;
};


//Dependency Twig Views
$container['view'] = function ($c) {

    $cf = $c->get('settings')['view'];
    $view = new \Slim\Views\Twig($cf['path'], $cf['twig']);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c->router,
        $c->request->getUri()
    ));

    return $view;
};


//MySQL Database Setup
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    try{
      //$this->logger->addInfo('Database before Connected');
      $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
      // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      //$this->logger->addInfo('Database Connected');
      return $pdo;
    }catch(Exception $e){
      //$this->logger->addInfo('Database Connection Failed');
      return false;
    }

};



/*
  setup firebase
*/
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

//Firebase Setup
$container['firebase'] = function ($c) {

    try{
      $serviceAccount = ServiceAccount::fromJsonFile('./test.json');
      $firebase = (new Factory)
          ->withServiceAccount($serviceAccount)
          ->create();
      return $firebase;
    }catch(Exception $e){
      //$this->logger->addInfo('Database Connection Failed');
      return false;
    }

};


?>
