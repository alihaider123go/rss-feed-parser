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
                                        <td> {{$user->name}}
                                            @if($user->isAdmin())
                                                <span class="badge text-bg-success">Admin</span>
                                            @endif
                                        </td>
                                        <td> {{$user->email}} </td>
                                        <td>
                                            @if($user->id != \Auth::User()->id) 
                                                @canImpersonate($gaurd = null) 
                                                    <a class="btn btn-primary btn-sm " role="button" href="{{ route('impersonate',$user->id) }}">Impersonate</a>
                                                @endCanImpersonate
                                            @endif
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
