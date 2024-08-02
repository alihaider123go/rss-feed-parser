@component('mail::message')

<a href="{{ $data['job_link'] }}">{{$data['job_link']}}</a>

**Position:** {{ $data['job_title'] }}

**Description:**  

{!! $data['job_description'] !!}

--------------------------------------------------
Thank you for using our application!

Regards,  
{{ config('app.name') }}
@endcomponent