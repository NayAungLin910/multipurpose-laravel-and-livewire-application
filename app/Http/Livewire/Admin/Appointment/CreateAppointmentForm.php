<?php

namespace App\Http\Livewire\Admin\Appointment;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreateAppointmentForm extends Component
{
    public $clients;
    public $state = [
        "client_id" => ""
    ];

    public function mount()
    {
        $this->clients = Client::all();
    }

    public function createAppointment()
    {
        // validate
        $validatedState = Validator::make($this->state, [
            'client_id' => "required|exists:clients,id",
            'members' => 'required',
            'color' => 'required',
            'date' => "required",
            'time' => 'required',
            'note' => 'required',
        ])->validate();

        $validatedState['status'] = 'open';

        Appointment::create($validatedState);

        $this->reset('state');

        $this->dispatchBrowserEvent('clear-select2'); // clear the select2 value

        $this->dispatchBrowserEvent('clear-note'); // clear the cke editor

        $this->dispatchBrowserEvent('toast-success', ['success' => "The appointment has been created!"]);
    }

    public function render()
    {
        return view('livewire.admin.appointment.create-appointment-form');
    }
}
