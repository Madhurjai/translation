<?php

namespace App\Components;

use Phalcon\Http\Request;
use Phalcon\Di\Injectable;

class Helperclass extends Injectable
{
    public function sanitize_product()
    {
        $request = new Request();
        $inputdata = array(
            'name' => $this->escaper->escapeHtml($request->get('name')),
            'description' => $this->escaper->escapeHtml($request->get('description')),
            'tags' => $this->escaper->escapeHtml($request->get('tags')),
            'price' => $this->escaper->escapeHtml($request->get('price')),
            'stock' => $this->escaper->escapeHtml($request->get('stock'))
        );
        return $inputdata;
    }
    public function sanitize_order()
    {
        $escaper = new Escaper();
        $request = new Request();
        $inputdata =  array(
            'custumer_name' =>  $this->escaper->escapeHtml($request->get('custumer_name')),
            'address' =>  $this->escaper->escapeHtml($request->get('address')),
            'zipcode' =>  $this->escaper->escapeHtml($request->get('zipcode')),
            'product' =>  $this->escaper->escapeHtml($request->get('product')),
            'quantity' =>  $this->escaper->escapeHtml($request->get('quantity'))
        );
        return $inputdata;
    }
    public function datetime() {
        $date = date('Y-m-d');
        return $date ;
    }
 
}
