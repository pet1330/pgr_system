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


## Development

* use `docker-compose -f docker-compose-devel.yml up` to fire up the development deployment
* the local source directory is deployed as the main app directory in development, so the following might have to be run in the container:
  * Enter the container with `docker-compose -f docker-compose-devel.yaml exec pgr bash`
  * run `composer install`
  * `yarn`
  * `yarn run production`
  * You can now leave the container

## Data Import
* `docker exec -i pgrsystem_db_1 mysql -B -uroot pgr_saml < ~/pgr201804251312.sql`

