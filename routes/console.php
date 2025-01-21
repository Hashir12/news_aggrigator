<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\GetNewsArticles;

Schedule::command(GetNewsArticles::class)->daily()->runInBackground();
