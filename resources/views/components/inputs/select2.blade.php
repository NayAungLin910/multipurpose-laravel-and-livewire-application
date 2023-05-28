@props(['placeholder' => 'Select Option', 'id'])

@once

@push('styles')
<!-- Select 2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('js')
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@endonce

<div wire:ignore>
    <select id="{{ $id }}" data-placeholder="{{ $placeholder }}" class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
        {{ $slot }}
    </select>
</div>

@push('js')
<script>
    $(document).ready(function() {
        $("#{{ $id }}").select2({
            theme: 'classic'
        })
    });

    // reset the select2 select box to default value after creation
    window.addEventListener('clear-select2', event => {
        $('#{{ $id }}').val('').trigger('change');
    });
</script>
@endpush
