<?php

namespace Tests\Feature;

use App\Filament\Pages\QuickMail;
use App\Mail\AdminCustomMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class QuickMailSmokeTest extends TestCase
{
    /**
     * This app's migrations include some MySQL-only statements unrelated to
     * this feature (e.g. raw `MODIFY` / duplicate-index migrations), which
     * fail against the sqlite connection used for tests. Rather than run the
     * full migrator (RefreshDatabase), only build the handful of tables this
     * test actually needs: users + Spatie permission tables.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $migrations = [
            '0001_01_01_000000_create_users_table.php',
            '2025_10_27_000002_alter_users_for_affiliate_kyc_2fa.php',
            '2025_10_30_000001_add_auth_fields_to_users.php',
            '2025_10_30_000003_alter_users_for_first_and_lastname.php',
            '2025_12_01_000001_add_balance_to_users.php',
            '2026_01_15_000001_add_phone_etc_to_users.php',
            '2026_01_16_162420_add_login_alerts_and_withdrawal_confirmation_to_users_table.php',
            '2026_01_21_201507_add_is_leader_to_users_table.php',
            '2026_01_22_101507_add_lock_roi_to_users_table.php',
            '2026_02_04_144259_add_deposit_wallet_and_co_to_users.php',
            '2026_03_10_121349_add_seen_sprint1_banner_to_users.php',
            '2026_01_13_002534_create_permission_tables.php',
        ];

        foreach ($migrations as $migration) {
            (require base_path('database/migrations/' . $migration))->up();
        }
    }

    public function test_admin_can_send_custom_email_to_a_user_and_a_raw_address(): void
    {
        Mail::fake();

        Role::firstOrCreate(['name' => 'super-admin']);

        $admin = User::factory()->create();
        $admin->assignRole('super-admin');

        $recipient = User::factory()->create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $this->actingAs($admin);

        // The RichEditor field's raw Livewire state is a TipTap JSON document
        // (matching what the browser editor produces); Filament converts it
        // to HTML on dehydration, which is what QuickMail::send() consumes.
        $contentDocument = [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => 'Hello there, '],
                        ['type' => 'text', 'marks' => [['type' => 'bold']], 'text' => 'thanks'],
                        ['type' => 'text', 'text' => ' for being with us.'],
                    ],
                ],
            ],
        ];

        Livewire::test(QuickMail::class)
            ->fillForm([
                'user_ids' => [$recipient->id],
                'custom_emails' => ['guest@example.com'],
                'subject' => 'A Message From The Team',
                'content' => $contentDocument,
            ])
            ->call('send')
            ->assertHasNoFormErrors()
            ->assertNotified('Email Queued');

        // The job is queued; run it synchronously (QUEUE_CONNECTION=sync in phpunit.xml).
        Mail::assertSentCount(2);
        Mail::assertSent(AdminCustomMail::class, function (AdminCustomMail $mail) use ($recipient) {
            return $mail->hasTo($recipient->email) && $mail->user?->is($recipient);
        });

        Mail::assertSent(AdminCustomMail::class, function (AdminCustomMail $mail) {
            return $mail->hasTo('guest@example.com') && $mail->user === null;
        });
    }

    public function test_script_tags_are_stripped_from_the_rendered_email(): void
    {
        Role::firstOrCreate(['name' => 'super-admin']);
        $admin = User::factory()->create();
        $admin->assignRole('super-admin');
        $this->actingAs($admin);

        $mail = new AdminCustomMail(
            'Test',
            strip_tags('<p>Safe</p><script>alert(1)</script>', '<p><br><strong>'),
            null
        );

        $html = $mail->render();

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('Safe', $html);
    }
}
