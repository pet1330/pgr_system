<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Aacotroneo\Saml2\Events\Saml2LoginEvent;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Saml2LoginEvent  $event
     * @return void
     */
    public function handle(Saml2LoginEvent $event)
    {
        $loginAttempt = $event->getSaml2User();
        $details = $loginAttempt->getAttributes();

        $user = tap(
            // Find or create a user
            User::firstOrNew(['university_email' => $loginAttempt->getUserId()])
        )->fill([
            // Update or set attributes
            'university_email' => $loginAttempt->getUserId(),
            'first_name' => $details['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'][0],
            'last_name' => $details['LastName'][0],
            'university_id' => $details['UniversityID'][0],
        ]);

        if (! $user->exists )
        {
            $user->user_type = $details['Description'][0] == 'Staff Account' ? 'Staff' : 'Student';
            $user->save();
            // Convert $user to the correct type
            $user = User::find($user->id);
            $user->assignDefaultPermissions(true);
        }

        $user->save();

        if( ! $user->locked) auth()->login($user);

        return redirect()->route('account-locked');
    }
}
