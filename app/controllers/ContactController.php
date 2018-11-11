<?php

namespace App\Controllers;

use Slim\Container;
use Slim\Http\Request;
use Slim\Http\Response;

class ContactController {

    private $c = null;

    public function __construct($container) {
        $this->c = $container;
    }

    public function hello(Request $request, Response $response) {
        return $this->c['view']->render($response, 'contact.twig', [
            "name" => "Michael"
        ]);
    }
}

?>
