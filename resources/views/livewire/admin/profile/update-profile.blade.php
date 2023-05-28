<div class="card-body box-profile" x-data="{ imagePreview: '{{ auth()->user()->avatar_url }}'}">
    <div class="d-flex my-3">
        <input class="mx-auto w-auto d-none" wire:model="image" x-ref="image" type="file" x-on:change="const reader = new FileReader(); reader.onload = (event) => {imagePreview = event.target.result; document.getElementById('profileImage').src = `${imagePreview}`;}; reader.readAsDataURL($refs.image.files[0]);">
    </div>
    <div class="text-center">
        <img x-on:click="$refs.image.click()" class="profile-user-img img-fluid img-circle" x-bind:src="imagePreview" alt="User profile picture">
    </div>
    <h3 class="profile-username text-center">Nina Mcintire</h3>
    <p class="text-muted text-center">Software Engineer</p>
</div>

@push('styles')
<style>
    .profile-user-img:hover {
        background-color: blue;
        cursor: pointer;
    }
</style>
@endpush
