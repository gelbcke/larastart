<?php

namespace Tests\Feature\Backend\Permissions;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class PermissionTest.
 */
class PermissionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_the_create_permission_page()
    {
        $this->loginAsAdmin();

        $this->get('/permissions/create')->assertOk();
    }
}
