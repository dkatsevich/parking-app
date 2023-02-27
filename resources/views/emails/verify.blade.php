<x-mail::message>

Your verification code

<x-mail::button :url="''">
{{ $verification_code }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
