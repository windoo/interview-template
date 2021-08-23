<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Filter
{
    /**
     * @var int
     */
    public $page = 1;

    /**
     * @var boolean
     */
    public $popular = false;

    /**
     * @var boolean
     */
    public $chrono = false;

    /**
     * @var boolean
     */
    public $reverse = false;
}
