<?php

// namespace MyApp\Controller;
//
// class MyController {
// private $db;
//
// public function __construct($db) {
//   $this->db = $db;
// }
//
// public function index($request, $response, $args) {
//   $name = $args['name'];
//   $response->getBody()->write("Hello, $name");
//   return $response;
//   // return $response;
// }
// }

// use Psr\Container\ContainerInterface;
// namespace MyController;
//
//
// class MyController
// {
//    protected $container;
//
//    // constructor receives container instance
//    public function __construct(ContainerInterface $container) {
//        $this->container = $container;
//    }
//
//    public function home($request, $response, $args) {
//         // your code
//         // to access items in the container... $this->container->get('');
//         return $response;
//    }
//
//    public function contact($request, $response, $args) {
//        $name = $args['name'];
//        $response->getBody()->write("Hello Contact, $name");
//        return $response;
//    }
// }


namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function index($request, $response, $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
    // return $response;
  }
}

?>
