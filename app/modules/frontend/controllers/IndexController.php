<?php
declare(strict_types=1);

namespace WebAppSeller\Modules\Frontend\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction($param = null)
    {
        $this->view->setVar('param', $param);
    }

}