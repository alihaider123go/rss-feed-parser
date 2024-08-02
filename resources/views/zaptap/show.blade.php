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
                    <a href="{{ url()->previous() }}" class="btn btn-primary mb-3" role="button" aria-pressed="true">Back</a>
                    <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        Pooling Trigger
                                        <a class="btn btn-warning btn-sm ml-5" role="button" href="{{ route('zaptap.test',$zaptap->id) }}">Test</a>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Title:</b> {{$zaptap->title}}</p>
                                        <p class="card-text"><b>Feed URL:</b> {{$zaptap->feed_url}}</p>
                                        <p class="card-text"><b>Interval:</b> {{$zaptap->interval}} <span class="text-muted">(in minutes)</span></p> 
                                    </div>
                                </div>
                            </div>
                            
                            @foreach ($zaptap->alertActions as $key => $alertAction)
                                <div class="col-sm-12 col-md-6 col-lg-6 mt-4">
                                    <div class="card">
                                        <div class="card-header">
                                            {{ucfirst($alertAction->alert_type)}} Action
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text"><b>Recipient Address:</b> {{$alertAction->recipient_address}}</p>
                                            <p class="card-text"><b>Subject:</b> {{$alertAction->subject}}</p>
                                            <p class="card-text"><b>Body Items:</b> 
                                                @foreach (json_decode($alertAction->body_items) as $key1 => $item)
                                                    <span class="badge text-bg-primary">{{ucfirst($item)}}</span>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>    
                                </div>
                            @endforeach
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <a class="btn btn-primary" role="button" href="{{ route('zaptap.edit',$zaptap->id) }}">Edit</a>    
                            <form action="{{ route('zaptap.destroy',$zaptap->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ZapTap?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-2">Delete</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
