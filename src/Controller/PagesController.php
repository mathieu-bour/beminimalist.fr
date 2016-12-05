<?php
namespace App\Controller;

/**
 * Pages Controller
 *
 * @author Mathieu Bour <mathieu.tin.bour@gmail.com>
 */
class PagesController extends AppController
{
    /**
     * Render homepage
     */
    public function home()
    {
        $this->viewBuilder()->layout('home');
    }
}
