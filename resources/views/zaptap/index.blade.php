<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">                
                    <h1>All ZapTaps</h1>
                    <div class="flex items-center justify-end">
                        <a href="{{ route('zaptap.create') }}" class="btn btn-primary" role="button" aria-pressed="true">Add New</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div  class="table-responsive">
                        <table class="table table-striped table-hover table-reflow">
                            <thead>
                                <tr>
                                    <th ><strong> Sr# </strong></th>
                                    @if(\Auth::User()->isAdmin())
                                        <th ><strong> User </strong></th>
                                    @endif
                                    <th ><strong> Title </strong></th>
                                    <th ><strong> Feed Url </strong></th>
                                    <th ><strong> Interval </strong>(minutes)</th>
                                    <th ><strong> Alerts </strong></th>
                                    <th ><strong>  </strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($zaptaps as $key => $zaptap)
                                    <tr>
                                        <td> {{$key + 1}} </td>
                                        @if(\Auth::User()->isAdmin())
                                            <td class="text-truncate" style="max-width: 150px;">
                                                @if($zaptap->user_id != \Auth::User()->id) 
                                                    @canImpersonate($gaurd = null) 
                                                        <a href="{{ route('impersonate',$zaptap->user_id) }}">{{$zaptap->user->name}}</a>
                                                    @endCanImpersonate
                                                @else
                                                    {{$zaptap->user->name}}
                                                @endif
                                            </td>
                                        @endif
                                        <td class="text-truncate" style="max-width: 150px;"> {{$zaptap->title}} </td>
                                        <td class="text-truncate" style="max-width: 150px;"> {{$zaptap->feed_url}} </td>
                                        <td> {{$zaptap->interval}}</td>
                                        <td> 
                                            @foreach ($zaptap->alertActions as $key1 => $alertAction)
                                                <span class="badge text-bg-success">{{ucfirst($alertAction->alert_type)}}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="flex items-center justify-end">
                                                <a class="btn btn-success btn-sm " role="button" href="{{ route('zaptap.show',$zaptap->id) }}">Details</a>
                                                <a class="btn btn-primary btn-sm ml-2" role="button" href="{{ route('zaptap.edit',$zaptap->id) }}">Edit</a>    
                                                <form action="{{ route('zaptap.destroy',$zaptap->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ZapTap?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm ml-2">Delete</button>
                                                </form>
                                            </div>    
                                        </td>
                                        <td> 
                                            <a class="btn btn-warning btn-sm " role="button" href="{{ route('zaptap.test',$zaptap->id) }}">Test</a>
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
