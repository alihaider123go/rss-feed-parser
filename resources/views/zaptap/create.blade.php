<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create ZapTap') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form  action="{{ route('zaptap.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        Pooling Trigger
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="feed-url">Feed URL*</label>
                                            <input type="url" name="feed_url" id="feed-url" placeholder="Enter Feed Url" class="form-control" value="{{ old('feed_url') }}" required>

                                        </div>
                                        <div class="row">
                                            <div class="form-group col-6 mb-3">
                                                <label for="title">Title*</label>
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="{{ old('title') }}">
                                            </div>
                                            <div class="form-group col-6">
                                                <label for="interval">Interval*</label>
                                                <input type="number" class="form-control" id="interval" name="interval" placeholder="Enter Interval" value="{{ old('interval') }}">
                                                <small id="intervalhelp" class="text-muted">
                                                    In minutes
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 col-md-6 col-lg-6 mt-4">
                                <div class="card">
                                    <div class="card-header">
                                        Email Action
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="email-address">Email Address*</label>
                                            <input type="email" class="form-control" id="email-address" name="email_address" placeholder="Enter Email Address" value="{{ old('email_address') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject">Subject*</label>
                                            <input type="text" class="form-control" id="subject" name="email_subject" placeholder="Enter Subject" value="{{ old('email_subject') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject">Body Items*</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    @foreach(['link' => 'Link', 'title' => 'Title', 'description' => 'Description'] as $value => $label)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="email_body[]" value="{{ $value }}" id="item-{{ $value }}" {{ in_array($value, old('email_body',[])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="item-{{ $value }}">
                                                                {{ $label }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 mt-4">
                                <div class="card">
                                    <div class="card-header card-title">
                                        Slack Action
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="slack-address">Email Address*</label>
                                            <input type="text" class="form-control" id="slack-address" name="slack_address" placeholder="Enter Slack Address" value="{{ old('slack_address') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="slack-subject">Subject*</label>
                                            <input type="text" class="form-control" id="slack-subject" name="slack_subject" placeholder="Enter Subject" value="{{ old('slack_subject') }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject">Body Items*</label>
                                            <div class="card">
                                                <div class="card-body">

                                                    @foreach(['link' => 'Link', 'title' => 'Title', 'description' => 'Description'] as $value => $label)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="slack_body[]" value="{{ $value }}" id="item-{{ $value }}" {{ in_array($value, old('slack_body',[])) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="item-{{ $value }}">
                                                                {{ $label }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <button class="btn btn-primary" type="submit">Create</button>
                        </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
