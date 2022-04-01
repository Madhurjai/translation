<?php

namespace App\Listener;

use Phalcon\Events\Event;
use Phalcon\Mvc\Controller;
use Phalcon\Logger;
use Phalcon\Security\JWT\Builder;
use Phalcon\Security\JWT\Signer\Hmac;
use Phalcon\Security\JWT\Token\Parser;
use Phalcon\Security\JWT\Validator;
use Phalcon\Di\Injectable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class NotificationListener extends Injectable
{
    public function updatename(Event $event, $product, $setting)
    {

        if ($product->price == null) {
            $product->price = $setting[0]->price;
        }
        if ($product->stock == null) {
            $product->stock = $setting[0]->stock;
        }
        if ($setting[0]->name_tag == 'tags') {
            $product->name = $product->name . ' ' . $product->tags;
        }
        if ($product->zipcode == null) {
            $product->zipcode = $setting[0]->zipcode;
        }

        return $product;
    }
    public function beforeHandleRequest(Event $event, \Phalcon\Mvc\Application $application)
    {
        // print_r("hello");
        // die ;
        $controller = ucwords($this->router->getControllerName());
        $action = ucwords($this->router->getActionName());

        $aclfile = APP_PATH . '/security/acl.cache';

        $bearer = $application->request->get('bearer')?? "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZXhhbXBsZS5vcmciLCJhdWQiOiJodHRwOi8vZXhhbXBsZS5jb20iLCJpYXQiOjEzNTY5OTk1MjQsIm5iZiI6MTM1NzAwMDAwMCwibmFtZSI6Im1hZGh1ciIsInJvbGUiOiJhZG1pbiJ9.9pErq74Yt0SZI9sSM91-jzYMiodfovxhebdy7-yYjH4" ;
        if ($bearer) {
            if (true === is_file($aclfile)) {
                $acl = unserialize(file_get_contents($aclfile));
                $key = "example_key";
                $jwt = $bearer;
                $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

                if ($decoded->role == 'admin') {
                    $action = ucwords($this->router->getActionName());
                }

                if (true !== $acl->isAllowed($decoded->role, $controller, $action)) {
                    echo "Access Denied";
                    // print_r($acl);
                    die();
                }
            }
        } else {

            echo "we dont find bearer!!";
            die;
        }
    }
}
