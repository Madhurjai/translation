<?php

// use App\Models\Settings;
use Phalcon\Mvc\Controller ;

class SettingController extends Controller {
    public function IndexAction() {
       
    }
    public function addAction() {
        $tag = $this->request->get('tags');
        $price = $this->request->get('price');
        $stock = $this->request->get('stock');
        $zipcode = $this->request->get('zipcode');
        $value = Settings::find('id = 1');
      
        $value[0]->name_tag = $tag ;
        $value[0]->price = $price ;
        $value[0]->stock = $stock ;
        $value[0]->zipcode = $zipcode ;
        $value[0]->update();
        header("Location: http://localhost:8080/");

        
    }
  
}
