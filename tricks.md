# Tricks

## Tinker

get into tinker: `php artisan tinker`

* create admin user: `factory(App\Models\Admin::class)->create();`
* find a user: `$user = App\Models\User::where('university_id', "scunningham")->first();`

## Authentication / Roles

* authenticate for devel:
  * in `routes/web.php` file add `auth()->loginUsingId(App\Models\Admin::first()->id);` to login as the first admin found
  * or in `routes/web.php` file add 

			$hack_user = getenv('HACK_USER');

			if (!empty($hack_user)) {
			    auth()->loginUsingId(App\Models\User::where('university_id',$hack_user) -> first()->id);
			}

	* assign permissions to user: 
	  * `$user->assignReadOnlyAdminPermissions();`
	  * `$user->assignBasicAdminPermissions();`
	  * `$user->assignElevatedAdminPermissions();`


