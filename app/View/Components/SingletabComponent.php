<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SingletabComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public $title;
    public $href;
    public $icon;
    public $tabname;
    public function __construct($title, $href, $icon, $tabname)
    {
        $this->title = $title;
        $this->href = $href;
        $this->icon = $icon;
        $this->tabname = $tabname;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.singletab-component');
    }
}
