<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotFoundController extends AbstractController {
    function index()
    {
        include DOSSIER_VIEWS.'/404.html.php';
    }
}