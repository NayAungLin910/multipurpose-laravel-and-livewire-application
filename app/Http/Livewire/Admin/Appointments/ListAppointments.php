<?php

namespace App\Http\Livewire\Admin\Appointments;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Appointment;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class ListAppointments extends AdminComponent
{
    use WithPagination;

    public $appointmentId;
    public $appointmentClientName;
    public $selectedRows = [];
    public $selectPageRows = false;

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

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->appointments->pluck('id')->map(function ($id) {
                return (string) $id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function getAppointmentsProperty()
    {
        return Appointment::latest()
            ->with('client:id,name')
            ->paginate(10);
    }

    public function deleteSelectedRows()
    {
        $selectedAppointments = Appointment::whereIn('id', $this->selectedRows)->get();

        if ($selectedAppointments->isEmpty()) {
            $this->dispatchBrowserEvent('show-error', [
                'message' => "No appointment has been selected!"
            ]);
            return;
        }

        Appointment::whereIn('id', $this->selectedRows)->delete();

        $this->dispatchBrowserEvent('deleted-success', [
            'message' => "The selected appointments has been deleted!"
        ]);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsSchedule()
    {
        Appointment::whereIn('id', $this->selectedRows)->update([
            'status' => 'scheduled'
        ]);

        $areOrIs = count($this->selectedRows) > 1 ? 'are' : 'is';

        $this->dispatchBrowserEvent('show-success', [
            'message' => "The selected " . Str::plural('appointment', count($this->selectedRows)) . ' ' . $areOrIs . ' now marked as ' . Str::plural('schedule', count($this->selectedRows)) . '!'
        ]);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function markAllAsClosed()
    {
        Appointment::whereIn('id', $this->selectedRows)->update([
            'status' => 'closed'
        ]);

        $areOrIs = count($this->selectedRows) > 1 ? 'are' : 'is';

        $this->dispatchBrowserEvent('show-success', [
            'message' => "The selected " . Str::plural('appointment', count($this->selectedRows)) . ' ' . $areOrIs . ' now marked as closed ' . Str::plural('schedule', count($this->selectedRows)) . '!'
        ]);

        $this->reset(['selectedRows', 'selectPageRows']);
    }

    public function render()
    {
        $appointments = $this->appointments;
        return view('livewire.admin.appointments.list-appointments', compact('appointments'));
    }
}
