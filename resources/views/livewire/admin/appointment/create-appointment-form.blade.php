<div>
    <div style="padding: 10px">
        <form wire:submit.prevent='createAppointment'>

            <!-- client -->
            <div class="form-group">
                <label for="exampleFormControlSelect1">Client</label>
                <select wire:model.defer="state.client_id" class="form-control @error('client_id') is-invalid @enderror" id="exampleFormControlSelect1">
                    <option value="" disabled>Choose A Client</option>
                    @foreach ($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- team select select2 -->
            <div class="form-group">
                <label for="team-select">Select Teams</label>
                <div class="@error('members') is-invalid border rounded border-danger custom-error @enderror">
                    <x-inputs.select2 wire:model="state.members" alright="alright" id="team-select" placeholder="Select The Teams">
                        <option value="alabama">Alabama</option>
                        <option value="wyoming">Wyoming</option>
                        <option value="california">California</option>
                        <option value="shan">Shan</option>
                    </x-inputs.select2>
                </div>
                @error('members')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="member-select">Select Teams Members</label>
                <div class="">
                    <x-inputs.select2 wire:model="state.others" id="member-select" placeholder="Select The Members">
                        <option value="jacob">Jacob</option>
                        <option value="william">William</option>
                        <option value="brad">Brad</option>
                        <option value="selena">Selena</option>
                    </x-inputs.select2>
                </div>
            </div>

            <!-- Color Pick -->
            <!-- <div class="form-group" wire:ignore.self>
                <label>Color picker:</label>
                <div class="@error('color') is-invalid border rounded border-danger custom-error @enderror">
                    <input wire:model.defer="state.color" type="text" class="form-control" id="colorPicker" data-colorpicker-id="1" data-original-title="" title="">
                </div>
                @error('color')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div> -->
            <div class="form-group">
                <label>Color picker with addon:</label>
                <div class="input-group" data-colorpicker-id="2">
                    <input wire:model.defer="state.color" name="color" type="text" class="form-control" data-original-title="" title="">
                    <div class="input-group-append">
                        <span class="input-group-text"><i id="colorPickerSquare" class="fas fa-square"></i></span>
                    </div>
                </div>
            </div>

            <!-- date -->
            <div class="form-group">
                <label for="input-date">Date</label>
                <input wire:model.defer="state.date" type="date" class="form-control @error('date') is-invalid @enderror" name="date" id="input-date">
                @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- appointment time -->
            <div class="form-group">
                <label for="input-time">Appointment Time</label>
                <input wire:model.defer="state.time" type="time" class="form-control @error('time') is-invalid @enderror" name="time" id="input-time">
                @error('time')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- note -->
            <div class="form-group">
                <label for="textarea-note">Note</label>
                <textarea data-note="@this" id="note" wire:model.defer="state.note" class="form-control" name="note" id="textarea-note" cols="30" rows="5"></textarea>
                @error('note')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    @push('js')
    <script>
        // $('#colorPicker').colorpicker();
        $('[name="color"]').colorpicker();

        $('[name="color"').on('colorpickerChange', function(event) {
            $('#colorPickerSquare').css('color', event.color.toString());
        })
    </script>
    <script>
        // ClassicEditor.create(document.querySelector('#note'));

        $('form').submit(function() {
            @this.set('state.members', $('#team-select').val())
            @this.set('state.note', $('#note').val())
            @this.set('state.color', $('[name="color"]').val())
        })
    </script>
    @endpush
</div>
