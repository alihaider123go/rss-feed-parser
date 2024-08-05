<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">   
                    <h1>All Users</h1>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('user.create') }}" class="btn btn-primary" role="button" aria-pressed="true">Add New</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif             
                    <div>
                        <table class="table table-striped table-hover table-reflow">
                            <thead>
                                <tr>
                                    <th ><strong> Sr#: </strong></th>
                                    <th ><strong> Name: </strong></th>
                                    <th ><strong> Email: </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td> {{$key +1}} </td>
                                        <td> 
                                            @if($user->id != \Auth::User()->id) 
                                                @canImpersonate($gaurd = null) 
                                                    <a href="{{ route('impersonate',$user->id) }}">{{$user->name}}</a>
                                                @endCanImpersonate
                                            @else
                                                {{$user->name}}
                                            @endif
                                            @if($user->isAdmin())
                                                <span class="badge text-bg-success">Admin</span>
                                            @endif
                                        </td>
                                        <td> {{$user->email}} </td>
                                        <td>
                                            <div class="flex items-center justify-end">
                                                <a class="btn btn-primary btn-sm " role="button" href="{{ route('user.edit',$user->id) }}">Edit</a>
                                                <a class="btn btn-warning btn-sm ml-2" role="button" href="{{ route('user.password.update',$user->id) }}">Update Password</a>
                                                <form action="{{ route('user.destroy',$user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this User?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm ml-2">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
