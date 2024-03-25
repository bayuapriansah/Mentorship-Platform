<?php

namespace App\View\Components\Chat;

use Illuminate\View\Component;

class Received extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(public $chat)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.chat.received');
    }
}
