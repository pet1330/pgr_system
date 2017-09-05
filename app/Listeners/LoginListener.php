<?php

namespace App\Listeners;

use Auth;
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
        
        //check if email already exists and fetch user
        $user = User::where('university_email', $loginAttempt->getUserId())->first();
                  
        //if email doesn't exist, create new user
        if($user === null)
        {
            $user = new User;
            $user->university_email = $loginAttempt->getUserId();
            $user->first_name = $details['http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name'][0];
            $user->last_name = $details['LastName'][0];
            $user->university_id = $details['UniversityID'][0];
            $user->user_type = 'Student';
            if($details['Description'][0] == 'Staff Account')
                $user->user_type = 'Staff';
            $user->save();
            // Fetch user into the relavant type
            $user = User::where('university_email', $loginAttempt->getUserId())->first();
        }

        // SET USER PERMISSIONS HERE
        
        Auth::login($user);
    }
}
