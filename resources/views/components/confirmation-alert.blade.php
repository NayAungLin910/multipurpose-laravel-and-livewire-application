@push('js')
    <script type="module">
        // delete confirmation box
        window.addEventListener('show-delete-confirmation', event => {
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete an appointment with ${event.detail.clientName}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#40B43B',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                   Livewire.emit('deleteConfirmed')
                }
            })
        })
    
        // deleted alert message
        window.addEventListener('deleted-success', event => {
            Swal.fire(
                'Deleted!',
                event.detail.message,
                'success'
            )
        })
    </script>
@endpush
