<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class UpdateAppointmentForm extends Component
{
    public $state = [];
    public Appointment $appointment;
    public $clients;

    public function mount(Appointment $appointment)
    {

        $this->state = $appointment->toArray();

        $this->appointment = $appointment;

        $this->clients = Client::all();
    }

    public function updateAppointment()
    {
        $validatedState = Validator::make($this->state, [
            'client_id' => "required|exists:clients,id",
            'date' => "required",
            'time' => 'required',
            'note' => 'required',
        ])->validate();

        $validatedState['status'] = 'open';

        $this->appointment->update($this->state);

        $this->dispatchBrowserEvent('toast-success', ['success' => "The appointment has been updated!"]);
    }

    public function render()
    {
        return view('livewire.admin.appointments.update-appointment-form');
    }
}
