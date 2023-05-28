<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end mb-2">
                        <button wire:click.prevent='addNew' class="btn btn-primary"><i
                                class="fa fa-plus-circle mr-1"></i> Add New User</button>
                        <x-search-input wire:model.debounce.500ms="searchTerm" />
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Registered Date</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Options</th>
                                    </tr>
                                </thead>
                                <tbody wire:loading.class='text-muted'>
                                    @forelse ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>
                                                <img loading="lazy" style="max-width: 100px; border-radius: 10px;"
                                                    src="{{ $user->avatar_url }}" class="img mr-2"
                                                    alt="{{ $user->name }}'s profile image">
                                                {{ $user->name }}
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->created_at->toFormattedDate() }}</td>
                                            <td>
                                                <select wire:change="changeRole({{ $user }}, $event.target.value)" class="form-select" aria-label="Default select example">
                                                    <option value="admin"
                                                        {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    <option {{ $user->role === 'user' ? 'selected' : '' }}
                                                        value="user">User</option>
                                                </select>
                                            </td>
                                            <td>
                                                <a href="" wire:click.prevent="edit({{ $user }})">
                                                    <i class="fa fa-edit mr-2"></i>
                                                </a>
                                                <a href="">
                                                    <i class="fa fa-trash text-danger"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <img height="100" src="{{ url('/images/cat_loading.svg') }}"
                                                    alt="cat svg image" />
                                                <p>No results found!</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="form" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="{{ $showEditModal ? 'updateUser' : 'createUser' }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            @if ($showEditModal)
                                <span>Edit User</span>
                            @else
                                <span>Add New User</span>
                            @endif
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            Close
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name-input" class="form-label">Name</label>
                            <input wire:model.defer='state.name' type="text"
                                class="form-control @error('name')
                                is-invalid
                            @enderror"
                                id="name-input" placeholder="Enter you full name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email-input" class="form-label">Email address</label>
                            <input wire:model.defer='state.email' type="text" placeholder="Enter your email"
                                name="email"
                                class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                id="email-input">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-input" class="form-label">Password</label>
                            <input wire:model.defer="state.password" type="password" name="password"
                                class="form-control @error('password')
                                    is-invalid
                                @enderror"
                                id="password-input">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="passwordConfirmation" class="form-label">Confirm Password</label>
                            <input wire:model.defer="state.password_confirmation" type="password"
                                name="passwordConfirmation"
                                class="form-control @error('password_confirmation')
                                    is-invalid
                                @enderror"
                                id="passwordConfirmation">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="profilePhoto" class="form-label">
                                @if ($photo)
                                    <img class="d-block mb-2" loading="lazy" src="{{ $photo->temporaryUrl() }}"
                                        style="max-height: 70px"
                                        alt="{{ $photo->getClientOriginalName() }} - Temporary Image">
                                    <p>
                                        {{ $photo->getClientOriginalName() }}
                                    </p>
                                @elseif ($editPhoto)
                                    <img class="d-block mb-2" loading="lazy" src="{{ $state['avatar_url'] }}"
                                        style="max-height: 70px" alt="{{ $editPhoto }} - Temporary Image">
                                    <p>
                                    @else
                                        <label for="profilePhoto" class="form-label">Choose Image</label>
                                @endif
                            </label>
                            <div x-data="{ isUploading: false, progress: 5 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false; progress = 5"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <input wire:model="photo" class="form-control" type="file" id="profilePhoto">

                                <!-- progress bar -->
                                <div x-show.transition="isUploading" class="progress progress-sm mt-2 rounded">
                                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                        x-bind:style="`width: ${progress}%`" x-bind:aria-valuenow="`${progress}`"
                                        aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times mr-1"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save mr-1"></i>
                            @if ($showEditModal)
                                <span>Save Changes</span>
                            @else
                                <span>Save</span>
                            @endif
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
</div>
