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
        $this->twig->display('HomeView.twig');
    }

    public function searchForm()
    {
        $this->twig->display('SearchingFormView.twig');
    }

    public function registrationForm()
    {
        $this->twig->display('RegistrationFormView.twig');
    }
}