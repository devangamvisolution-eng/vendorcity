<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MyProfileBackButton extends Component
{
    public $url;

    public $label;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url = 'javascript:history.back()', $label = 'Back')
    {
        $this->url = $url;
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.my-profile-back-button');
    }
}
