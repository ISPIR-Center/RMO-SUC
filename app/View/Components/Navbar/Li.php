<?php

namespace App\View\Components\Navbar;

use Illuminate\View\Component;

class Li extends Component
{
    public $navstatus;
    public $name;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($navstatus,$name)
    {
        $this->navstatus = $navstatus;
        $this->name = $name;
    }
    public function getnavstatus()
    {
        $name = $this->name;
        $navstatus = $this->navstatus;
        if($name == $navstatus){
            return "active";
        }
        else{
           return "";
        }
    
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar.li');
    }
}
