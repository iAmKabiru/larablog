<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
Artisan::command('configure', function (){
   Artisan::call('migrate:fresh');
   Artisan::call('passport:install');

   \App\Models\User::create([
       'name' => 'Admin user',
       'email' => 'admin@blog.com',
       'role'  => 'admin',
       'password' => \Illuminate\Support\Facades\Hash::make('password')
   ]);

   $this->info('Command done...');
   $this->info('Admin Email: admin@blog.com');
   $this->info('Admin Password: password');
});
