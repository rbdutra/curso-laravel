<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $count = 0;

    public $dados = [];
    public $name = "";

    public function increment()
    {
        $this->count++;
    }

    public function decrement()
    {
        $this->count--;
    }


    public function save()
    {
        $this->dados[] = ["name" => $this->name];
        $this->name = "";
    }


    public function render()
    {
        return view('livewire.counter');
    }
}
