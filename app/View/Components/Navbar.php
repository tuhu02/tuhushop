<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    public $links;

    /**
     * Create a new component instance.
     *
     * @param array $links
     */
    public function __construct($links = [])
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.navbar');
    }
}
