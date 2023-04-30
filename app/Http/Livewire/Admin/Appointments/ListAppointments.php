<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;
use Livewire\WithPagination;

class ListAppointments extends AdminComponent
{
    use WithPagination;

    public $appointmentId;
    public $appointmentClientName;

    protected $listeners = [
        'deleteConfirmed' => 'deleteAppointment'
    ];

    public function confirmAppointmentRemoval($appointmentId, $appointmentClientName)
    {
        $this->appointmentId = $appointmentId;
        $this->appointmentClientName = $appointmentClientName;

        $this->dispatchBrowserEvent('show-delete-confirmation', [
            'id' => $this->appointmentId,
            'clientName' => $this->appointmentClientName
        ]);
    }

    public function deleteAppointment()
    {
        $appointment = Appointment::findOrFail($this->appointmentId);

        $appointment->delete();

        $this->dispatchBrowserEvent('deleted-success', [
            'message' => "An appointment with $this->appointmentClientName has been deleted!"
        ]);
    }

    public function render()
    {
        $appointments = Appointment::latest()
            ->with('client:id,name')
            ->paginate(10);

        return view('livewire.admin.appointments.list-appointments', compact('appointments'));
    }
}
