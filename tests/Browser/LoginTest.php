<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/admin')
                    ->assertSee('Laravel');
        });
    }

    public function testingExample(): void
    {
    $this->browse(function (Browser $browser) {
        $browser->loginAs(User::find(1))
              ->visit('/admin');
    });
}
}
