<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Livewire\Admin\AdminComponent;
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

        User::create($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['success' => 'The user addded successfully!']);
    }

    public function edit(User $user)
    {
        $this->showEditModal = true;

        $this->user = $user;

        $this->state = $user->toArray();

        $this->editPhoto = url("/storage/avatars/$user->avatar");

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
