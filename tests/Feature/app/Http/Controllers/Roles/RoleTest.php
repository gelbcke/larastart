<?php

namespace Tests\Feature\Backend\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class RoleTest.
 */
class RoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_the_create_role_page()
    {
        $this->loginAsAdmin();

        $this->get('/roles/create')->assertOk();
    }
}
