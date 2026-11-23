<?php

use App\Models\User;

function makeAdmin(array $attrs = []): User
{
    $user = User::factory()->create($attrs);
    $user->forceFill(['is_admin' => true])->save();

    return $user;
}

it('redirects guests from the admin panel to the login page', function () {
    $this->get('/admin')->assertRedirect(route('admin.login'));
    $this->get('/admin/projects')->assertRedirect(route('admin.login'));
});

it('lets an admin log in and see the dashboard', function () {
    $admin = makeAdmin(['password' => 'secret-pass-1']);

    $this->post(route('admin.login.submit'), ['email' => $admin->email, 'password' => 'secret-pass-1'])
        ->assertRedirect(route('admin.dashboard'));

    $this->get('/admin')->assertOk()->assertSee('Dashboard');
    expect($admin->fresh()->last_login_at)->not->toBeNull();
});

it('rejects users who are not admins', function () {
    $user = User::factory()->create(['password' => 'secret-pass-1']);

    $this->post(route('admin.login.submit'), ['email' => $user->email, 'password' => 'secret-pass-1'])
        ->assertSessionHasErrors('email');
    $this->assertGuest();

    // Even when logged in some other way, a non-admin is thrown out of /admin.
    $this->actingAs($user)->get('/admin')->assertRedirect(route('admin.login'));
});

it('locks the login after repeated wrong passwords', function () {
    $admin = makeAdmin(['password' => 'secret-pass-1']);

    foreach (range(1, 5) as $i) {
        $this->post(route('admin.login.submit'), ['email' => $admin->email, 'password' => 'wrong']);
    }

    // Even the correct password is refused while locked out.
    $this->post(route('admin.login.submit'), ['email' => $admin->email, 'password' => 'secret-pass-1'])
        ->assertSessionHasErrors('email');
    expect(session('errors')->first('email'))->toStartWith('Too many login attempts.');
    $this->assertGuest();
});

it('changes the password only with the correct current password', function () {
    $admin = makeAdmin(['password' => 'secret-pass-1']);

    $this->actingAs($admin)->put(route('admin.profile.password'), [
        'current_password' => 'nope', 'password' => 'newpass123', 'password_confirmation' => 'newpass123',
    ])->assertSessionHasErrors('current_password');

    $this->actingAs($admin)->put(route('admin.profile.password'), [
        'current_password' => 'secret-pass-1', 'password' => 'newpass123', 'password_confirmation' => 'newpass123',
    ])->assertSessionHasNoErrors();

    expect(Hash::check('newpass123', $admin->fresh()->password))->toBeTrue();
});

it('creates an admin from the console command', function () {
    $this->artisan('admin:create', ['--name' => 'Site Admin', '--email' => 'boss@example.com'])
        ->expectsQuestion('Password (min. 8 characters)', 'longenough1')
        ->assertSuccessful();

    expect(User::where('email', 'boss@example.com')->first()->isAdmin())->toBeTrue();
});
