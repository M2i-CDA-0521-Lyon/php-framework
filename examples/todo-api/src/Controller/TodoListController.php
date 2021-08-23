<?php

namespace App\Controller;

use App\View\TodoListView;
use Cda0521Framework\Interfaces\HttpResponse;
use Cda0521Framework\Interfaces\ControllerInterface;

class TodoListController implements ControllerInterface
{
    public function invoke(): HttpResponse
    {
        return new TodoListView();
    }
}
