@component('mail::message')
# Introduction

You OTP is {{$OTP}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
