<?php

use Phalcon\Mvc\Controller;

class ProductController extends Controller
{

    public function IndexAction()
    {
    }

    public function registerAction()
    {
        $product = new App\Models\Products();
        $helper = new \App\Components\Helperclass();
        $value = $helper->sanitize_product();
        // print_r($value);

        $product->assign(
            $value,
            [
                'name','description', 'tags', 'price', 'stock'
            ]
        );
        $values = Settings::find('id = 1');
        // $eventmanager = $this->di->get('EventManager');
      
        $val = $this->EventManager->fire('notifications:updatename', $product, $values);
        



        $success = $val->save();

        $this->view->success = $success;

        if ($success) {
            $this->view->message = "Register succesfully";
        } else {
            $this->view->message = "Not Register succesfully due to following reason: <br>" . implode("<br>", $product->getMessages());
        }
    }
    public function DisplayAction()
    {
        $data = new \App\Models\Products;
        $this->view->products = $data->find();
        // print_r($product[0]->name);
    }
}
