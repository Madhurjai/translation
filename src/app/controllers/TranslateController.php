<?php

use Phalcon\Mvc\Controller;

/**
 * @property MyApp\Locale $locale
 */
class TranslateController extends Controller
{
    public function indexAction()
    {   $val = $this->request->get('locale');
        // print_r($val);
        // die;

        // $song = 'fuck u';

        // $text = $this->locale->_(
        //     'hi' ,
        //     [
        //         'song' => $song ,

        //     ]
        // );
        
        // echo $text;
        // header("Location")
    }
}