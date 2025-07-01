<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Carousel extends Component
{
    public $slides;

    public function __construct($slides)
    {
        $this->slides = $slides;
    }

    public function render()
    {
        return view('components.carousel');
    }
}
