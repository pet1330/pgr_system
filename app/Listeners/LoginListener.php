<?php

namespace App\Listeners;

use \Aacotroneo\Saml2\Events\Saml2LoginEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $user = $event->getSaml2User();
		$userData = [
			'id' => $user->getUserId(),
			'attributes' => $user->getAttributes(),
			'assertion' => $user->getRawSamlAssertion()
		];
		$userData['attributes']['university_id'] = [str_before($userData['attributes']['upn'], '@')];
        //check if email already exists and fetch user
		$user = \App\Models\User::where('university_id', $userData['attributes']['university_id'][0])->first();
		
		//if email doesn't exist, create new user
		if($user === null)
		{		
			$user = new \App\User;
			$user->name = sprintf('%s %s', $userData['attributes']['FirstName'][0], $userData['attributes']['LastName'][0]);
			$user->email = $userData['attributes']['EmailAddress'][0];
			$user->password = bcrypt(str_random(8));
			$user->save();
		}
		
		//login user
		\Auth::login($user);
    }
}