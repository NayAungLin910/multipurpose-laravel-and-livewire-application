<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;
use Livewire\WithPagination;

class ListAppointments extends AdminComponent
{
    use WithPagination;

    public function render()
    {
        $appointments = Appointment::latest()
            ->with('client:id,name')
            ->paginate(10);

        return view('livewire.admin.appointments.list-appointments', compact('appointments'));
    }
}
