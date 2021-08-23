<?php

namespace App\View;

use Cda0521Framework\Html\AbstractView;

/**
 * Vue permettant d'afficher la liste des tâches à faire
 */
class TodoListView extends AbstractView
{
    /**
     * Crée une nouvelle vue
     */
    public function __construct()
    {
        parent::__construct('Liste de courses');
    }

    /**
     * Génére le corps de la page HTML
     *
     * @return void
     */
    protected function renderBody(): void
    {
        include './templates/todo-list.php';
    }
}
