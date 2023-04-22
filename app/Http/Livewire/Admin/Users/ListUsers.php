<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class ListUsers extends Component
{
    public $state = [];

    public $user;

    public $showEditModal = false;

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

        User::create($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['success' => 'The user addded successfully!']);
    } 

    public function edit(User $user)
    {
        $this->showEditModal = true;

        $this->user = $user;

        $this->state = $user->toArray();

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

        $this->user->update($validatedData);

        $this->dispatchBrowserEvent('hide-form', ['success' => 'The user updated successfully!']);
    }

    public function render()
    {
        $users = User::latest()->paginate(10);
        return view('livewire.admin.users.list-users', [
            "users" => $users
        ]);
    }
}
