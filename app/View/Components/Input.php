<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $type;
    public $id;
    public $name;
    public $value;
    public $for;
    
    /**
     * Create a new component instance.
     */
    public function __construct($type, $id, $name, $value)
    {
        $this->type = $type;
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input');
    }
}
