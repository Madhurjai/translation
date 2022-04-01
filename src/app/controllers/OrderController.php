<?php 

use Phalcon\Mvc\Controller ;

class OrderController extends Controller {
    
    public function indexAction()
    {
         
        
    }
    public function registerAction() {
        $order = new Orders();
        $data = new \App\Components\Helperclass() ;
        $inputdata = $data->sanitize_order() ;

        $order->assign(
            $inputdata , [
                'custumer_name', 'address', 'zipcode', 'product', 'quantity'
            ]);

            $values = Settings::find('id = 1');
            // $eventmanager = $this->di->get('EventManager');
        
            $val = $this->EventManager->fire('notifications:updatename', $order, $values);
            $success = $val->save();

        $this->view->success = $success;

        if($success){
            $this->view->message = "Register succesfully";
        }else{
            $this->view->message = "Not Register succesfully due to following reason: <br>".implode("<br>", $order->getMessages());
        }
    }
    public function DisplayAction() {
        $this->view->orders = Orders::find();
    }

    
}