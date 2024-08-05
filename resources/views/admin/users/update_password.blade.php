<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Password') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('users') }}" class="btn btn-primary mb-3" role="button" aria-pressed="true">Back</a>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form  action="{{ route('user.password.update',$user->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-header">
                                        User ({{$user->name}})
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group mb-3">
                                                <label for="password">Password*</label>
                                                <input type="password" required class="form-control" name="password" id="password" placeholder="Enter Password" value="{{ old('password') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="flex items-center justify-end">
                                            <button class="btn btn-primary" type="submit">Update</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
