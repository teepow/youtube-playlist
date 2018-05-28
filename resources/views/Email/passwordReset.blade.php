@component('mail::message')
# You've requested to reset your password.

Click the button to change your password.

@component('mail::button', ['url' => 'http://localhost:4200/response-password-reset?token=' . $token])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
