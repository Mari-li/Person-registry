<?php

namespace App\Controllers;



class HomeController
{
    public function index()
    {
        require_once 'app/Views/homeView.php';
    }

    public function searchForm()
    {
        require_once 'app/Views/searchingFormView.php';
    }
    public function registrationForm()
    {
        require_once 'app/Views/registrationFormView.php';
    }
}