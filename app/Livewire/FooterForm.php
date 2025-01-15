<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscriber;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FooterForm extends Component
{

    use LivewireAlert;

    public $email;

    protected $rules = [
        'email' => 'required|email|unique:subscribers,email',
    ];

    public function subscribe()
    {
        $this->validate();

        Subscriber::create([
            'email' => $this->email,
        ]);

        $this->email = '';
        $this->alert('success', 'Thank you for subscribing to our newsletter', [
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
        // session()->flash('success', 'Thank you for subscribing!');
    }
    
    public function render()
    {
        return view('livewire.footer-form');
    }
}
