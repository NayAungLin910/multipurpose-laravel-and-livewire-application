<div>
    <x-loading-indicator />

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Appointment</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-end mb-2">
                        <div>
                            <a href="{{ route('admin.appointments.create') }}" class="btn btn-primary"><i
                                    class="fa fa-plus-circle mr-1"></i> Add New Appointment</a>
                        </div>

                        <!-- custom dropdown button -->
                        <x-dropdown-button @style(['display: none' => !$selectedRows]) />

                        <div class="mr-2">
                            <span>Selected {{ count($selectedRows) }}
                                {{ Str::plural('appointment', count($selectedRows)) }}</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <label class="d-block" for="select-all-appointments">Select All</label>
                                            <input wire:model="selectPageRows" id="select-all-appointments"
                                                type="checkbox">
                                        </th>
                                        <th scope="col">Client Name</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Time</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $appointment)
                                        <tr>
                                            <td>
                                                <input value="{{ $appointment->id }}" wire:model="selectedRows"
                                                    id="select-appointment-{{ $appointment->id }}"
                                                    name="appointmentSelect" type="checkbox">
                                            </td>
                                            <td scope="row">{{ $loop->iteration }}</td>
                                            <td>{{ $appointment->client->name }}</td>
                                            <td>{{ $appointment->date }}</td>
                                            <td>{{ $appointment->human_readable_date }}</td>
                                            <td>
                                                <span class="badge badge-{{ $appointment->statusBadge }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.appointments.edit', $appointment) }}">
                                                    <i class="fa fa-edit mr-2"></i>
                                                </a>
                                                <button class="normal-button"
                                                    wire:click.prevent='confirmAppointmentRemoval({{ $appointment->id }}, "{{ $appointment->client->name }}")'>
                                                    <i class="fa fa-trash text-danger"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
<x-confirmation-alert />
</div>
