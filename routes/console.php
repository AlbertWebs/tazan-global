<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about:tazan', function () {
    $this->comment('Tazan Global website is ready for development.');
})->purpose('Show the Tazan Global application status');
