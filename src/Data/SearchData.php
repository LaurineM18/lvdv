<?php

namespace App\Data;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchData extends AbstractController
{
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var boolean
     */
    public $new = false;

    /**
     * @var boolean
     */
    public $available = false;
}