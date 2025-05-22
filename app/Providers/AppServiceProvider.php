<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
 
    public function register(): void
    {
       
    }
     
     public function boot(): void {
        // ⁡⁢⁣⁣YOU CAN CHANGE THIS URL TO HTTPS IF IMO NA EH DEPLOY ⁡
        URL::forceScheme('http');
     }

     //⁡⁢⁣⁣NGROK TESTING TUNNEL RANI⁡
    //public function boot(): void {if (str_contains(request()->getHost(), 'ngrok.app') || str_contains(request()->getHost(), 'ngrok.io')){URL::forceScheme('https');}}
    
}
