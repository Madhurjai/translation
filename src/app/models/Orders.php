<?php

use Phalcon\Mvc\Model;

class Orders extends Model
{
    public $custumer_name;
    public $address;
    public  $zipcode;
    public $product;
    public $quantity;
}
