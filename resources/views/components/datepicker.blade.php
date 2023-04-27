@props(['id'])

<input id="{{ $id }}" {{ $attributes }} type="date" class="form-control"
    onchange="this.dispatchEvent(new InputEvent('input'))" />
