<?php
namespace App\Models;
use Phalcon\Mvc\Model;

class Products extends Model
{
    public $name;
    public $description;
    public $tags;
    public $price;
    public $stock;
}