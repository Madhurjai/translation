<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
    //    header("Location: http://localhost:8080/?locale=en");
        // return '<h1>Hello World!</h1>';
    }
    public function DateAction() {
        $value = new \App\Components\Helperclass();
        echo $value->datetime();
        // die;
    }
}