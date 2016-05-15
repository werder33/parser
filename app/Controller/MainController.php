<?php
/**
 * Created by PhpStorm.
 * User: silivanov_aa
 * Date: 10.05.2016
 * Time: 12:21
 */

namespace app\Controller;

use core\View;

class MainController extends Controller
{

    public function getIndex()
    {
         View::render('index');
    }

}