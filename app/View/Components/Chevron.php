<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Chevron extends Component
{
    /**
     * @var mixed|string
     */
    private $class;
    private $dir;
    private $innerColor;

    /**
     * Create a new component instance.
     *
     * @param string $class
     * @param string $dir
     * @param string $innerColor
     */
    public function __construct($class=null , $dir=null, $innerColor=null)
    {
        $this->class = $class;
        $this->dir = $dir;
        $this->innerColor = $innerColor;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chevron', ["class" => $this->class, "dir" => $this->dir, 'innerColor' => $this->innerColor]);
    }
}
