<?php

namespace App\Http\Controllers;

use App\Library\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ArtisanController extends Controller
{
    public function storageLink () {
        $exitCode = Artisan::call('storage:link', []);
        echo $exitCode;
    }

    public function migrateDb () {
        $exitCode = Artisan::call('migrate', []);
        echo $exitCode;
    }

    public function migrateRefresh () {
        $exitCode = Artisan::call('migrate:refresh', []);
        echo $exitCode;
    }

    public function migrateFresh () {
        $exitCode = Artisan::call('migrate:fresh', []);
        echo $exitCode;
    }

    public function dbSeed () {
        $exitCode = Artisan::call('db:seed', []);
        echo $exitCode;
    }

    public function runSchedule () {
        Artisan::call('schedule:run', []);
    }

    public function clearCache () {
        Artisan::call('cache:clear', []);

        return back()->with('success', 'All cache files have been cleared.');
    }
}
