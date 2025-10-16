<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::share('patientHeaders', [
            ['column' => 'id', 'label' => 'ID'],
            ['column' => 'name', 'label' => 'Name'],
            ['column' => 'age', 'label' => 'Age'],
            ['column' => 'sex', 'label' => 'Sex'],
            ['column' => 'blood_type', 'label' => 'Blood Type'],
            ['column' => 'phone', 'label' => 'Phone'],
        ]);
    }

    public function register()
    {
        //
    }
}
