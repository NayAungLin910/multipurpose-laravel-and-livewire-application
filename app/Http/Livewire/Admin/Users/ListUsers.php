<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\Admin\AdminComponent;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ListUsers extends AdminComponent
{
    use WithFileUploads;

    public $state = [];

    public $user;

    public $showEditModal = false;

    public $searchTerm;

    public $photo;

    public $editPhoto;


    public function changeRole(User $user, $role)
    {
        Validator::make([
            'role' => $role
        ], [
            'role' => 'required|in:admin,user',
        ])->validate();

        $user->update(['role' => $role]);

        $this->dispatchBrowserEvent('toast-success', [
            'success' => "The role has been changed to $role!"
        ]);
    }

    public function addNew()
    {
        $this->showEditModal = false;

        $this->reset('state');

        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ])->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($this->photo) {
            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }

        $validatedData['row'] = 'user';

        User::create($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['success' => 'The user addded successfully!']);
    }

    public function edit(User $user)
    {
        $this->reset();

        $this->showEditModal = true;

        $this->user = $user;

        $this->state = $user->toArray();

        $this->editPhoto = url("/storage/avatars/$user->avatar");

        if (!$user->avatar) {
            $this->editPhoto = url('no_image.jpg');
        }

        $this->dispatchBrowserEvent('show-form');
    }

    public function updateUser()
    {
        $validatedData = Validator::make($this->state, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'password' => 'sometimes|confirmed'
        ])->validate();

        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        if ($this->photo) {
            if ($this->user->avatar && Storage::disk('avatars')->has($this->user->avatar)) {
                Storage::disk('avatars')->delete($this->user->avatar);
            }

            $validatedData['avatar'] = $this->photo->store('/', 'avatars');
        }

        $this->user->update($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['success' => 'The user updated successfully!']);
    }

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', "%$this->searchTerm%")
            ->orWhere('email', 'like', "%$this->searchTerm%")
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.list-users', [
            "users" => $users
        ]);
    }
}
