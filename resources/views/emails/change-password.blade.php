@component('mail::message')
<h1>{{$details['title']}}</h1>
<p>{{$details['body']}}</p>

@if ($details['url'] != null)
@component('mail::button', ['url' => $details['url']])
Click Here
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
