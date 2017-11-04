@component('mail::message')
# Confirm your Account
<br>
Hey {{ $user->name }},

Thank you for creating your account on {{ config('app.name') }}!

**Please click the button below to confirm your account.**

@component('mail::button', ['url' => $url, 'color' => 'blue'])
Confirm Account
@endcomponent

**You're Awesome! 🤘**

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
