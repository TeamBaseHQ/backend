@component('mail::message')
# Invitation to join Team: {{$invitation->team->name}}
<br>
Hey,

You've been invited by {{$invitation->team->owner->name}} to join {{$invitation->team->name}}.

> {{$invitation->message}}

@component('mail::button', ['url' => $url, 'color' => 'blue'])
    Accept Invitation
@endcomponent

**You're Awesome! 🤘**

Thanks,<br>
Team {{ config('app.name') }}
@endcomponent
