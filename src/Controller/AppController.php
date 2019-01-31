<?php
namespace Controller;

class AppController extends AbstractController
{
    public function home()
    {
        // $AppManager = new AppManager($this->getPdo());
        return $this->twig->render('home.html.twig', ['message' => '']);
    }

    public function delete()
    {
        // $AppManager = new AppManager($this->getPdo());
        return $this->twig->render('delete.html.twig', ['message' => '']);
    }
}
