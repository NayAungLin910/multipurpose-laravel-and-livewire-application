<div>
    <div style="padding: 10px">
        <form wire:submit.prevent='createAppointment'>

            <!-- client -->
            <div class="form-group">
                <label for="exampleFormControlSelect1">Client</label>
                <select wire:model.defer="state.client_id" class="form-control @error('client_id') is-invalid @enderror"
                    id="exampleFormControlSelect1">
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

            <!-- date -->
            <div class="form-group">
                <label for="input-date">Date</label>
                <input wire:model.defer="state.date" type="date"
                    class="form-control @error('date') is-invalid @enderror" name="date" id="input-date">
                @error('date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- appointment time -->
            <div class="form-group">
                <label for="input-time">Appointment Time</label>
                <input wire:model.defer="state.time" type="time"
                    class="form-control @error('time') is-invalid @enderror" name="time" id="input-time">
                @error('time')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- note -->
            <div class="form-group" wire:ignore>
                <label for="textarea-note">Note</label>
                <textarea data-note="@this" id="note" wire:model.defer="state.note" class="form-control" name="note"
                    id="textarea-note" cols="30" rows="5"></textarea>
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
        <!-- CKEeditor -->
        <script>
            ClassicEditor
                .create(document.querySelector('#note'))
                .then(editor => {
                    document.querySelector('#submit').addEventListener('click', () => {
                        let note = $('#note').data('note')
                        eval(note).set('state.note', editor.getData())
                    })

                    // clear cke editor after creating the appointment
                    window.addEventListener('clear-note', event => {
                        editor.setData("");
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</div>
