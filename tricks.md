# Tricks

* authenticate for devel:
  * run `php artisan tinker` then type `factory(App\Models\Admin::class)->create();`
  * then in the `routes/web.php` file add `auth()->loginUsingId(App\Models\Admin::first()->id);`