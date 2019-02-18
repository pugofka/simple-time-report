<?php

namespace Tests\Feature;

use App\Report;
use App\Role as RoleConst;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;


class UserAccessTest extends TestCase
{
    use RefreshDatabase;

    /**
     * setUp test with seeding database
     */
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed');

        $this->admin = factory(User::class)->create();
        $this->user = factory(User::class)->create();

        $this->admin->assignRole(RoleConst::ROLE_ADMIN);
        $this->user->assignRole(RoleConst::ROLE_USER);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUserAccess() {
        $firstUser = User::query()->first();

        $response = $this->actingAs($this->admin)->get('/users');
        $response->assertStatus(200);
        $response = $this->actingAs($this->admin)->get('/users/create');
        $response->assertStatus(200);
        $response = $this->actingAs($this->admin)->get('/users/'. $firstUser->id .'/edit');
        $response->assertStatus(200);

        // CRUD reports
        factory(Report::class)->create();
        $firstReport = Report::query()->first();
        $response = $this->actingAs($this->user)->get('/my-reports');
        $response->assertStatus(200);
        $response = $this->actingAs($this->user)->get('/my-reports/'. $firstReport->id . '/edit');
        $response->assertStatus(200);

        // Reports
        $firstReport = Report::query()->first();
        $response = $this->actingAs($this->admin)->get('/reports?user='. $firstReport->id);
        $response->assertStatus(200);
        $response = $this->actingAs($this->admin)->get('/reports?user=all');
        $response->assertStatus(200);
        $response = $this->actingAs($this->admin)->get('/reports/'. $firstReport->id . '/edit');
        $response->assertStatus(200);

        // CLear fake data from tests
        User::findOrFail($this->admin->id)->delete();
        User::findOrFail($this->user->id)->delete();

        $this->admin->removeRole(RoleConst::ROLE_ADMIN);
        $this->user->removeRole(RoleConst::ROLE_USER);
    }

}
