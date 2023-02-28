@component('mail::message')
<h1>{{$emails['title']}}</h1>
<h3>Hello {{$emails['user']}}</h3>
<p>{{$emails['body']}}</p>

@if ($emails['url'] != null)
@component('mail::button', ['url' => $emails['url']])
Click Here
@endcomponent
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent
