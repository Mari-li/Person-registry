<?php

namespace App\Controllers;

use Twig\Environment;

class HomeController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index()
    {
        $this->twig->display('homeView.twig');
    }

    public function searchForm()
    {
        $this->twig->display('search.twig');
    }

    public function registrationForm()
    {
        $this->twig->display('register.twig');

    }
}