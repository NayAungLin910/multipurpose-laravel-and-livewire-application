@props(['id'])

<input id="{{ $id }}" {{ $attributes }} type="time" class="form-control"
    onchange="this.dispatchEvent(new InputEvent('input'))" />
