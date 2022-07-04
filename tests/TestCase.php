<?php

namespace Tests;

use App\Http\Middleware\CheckUserStatus;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');

        $this->withoutMiddleware(RequirePassword::class);
        $this->withoutMiddleware(CheckUserStatus::class);
    }

    protected function getAdminRole()
    {
        return Role::where('name', 'administrator')->first();
    }

    protected function getMasterAdmin()
    {
        return User::first();
    }

    protected function loginAsAdmin($admin = false)
    {
        if (!$admin) {
            $admin = $this->getMasterAdmin();
        }

        $this->actingAs($admin);

        return $admin;
    }
}
