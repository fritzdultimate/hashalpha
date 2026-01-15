<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-sqlite-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() {
        $tables = DB::connection('sqlite_old')
            ->select("
                SELECT name FROM sqlite_master 
                WHERE type='table' 
                AND name NOT LIKE 'sqlite_%'
                AND name != 'migrations'
                AND name NOT IN ('migrations', 'cache', 'cache_locks', 'sessions')
            ");
        $orderedTables = [
            'users',
            'wallets',
            'user_wallets',
            'staking_plans',
            'stakes',
            'transactions',
            'referrals',
            'withdrawals',
            'deposits',
            // 'admin_transactions',
            'roles',
            'permissions',
            'model_has_roles',
            'model_has_permissions',
            'payment_settings',
            'payouts',
            'ranks',
            'referral_levels',
            'rewards',
            'referral_rewards',
            'role_has_permissions',
            'user_ranks',
            'validator_keys'
        ];

        foreach ($orderedTables as $name) {

            if (!Schema::hasTable($name)) {
                continue;
            }

            $rows = DB::connection('sqlite_old')->table($name)->get();

            if ($rows->isEmpty()) {
                continue;
            }

            $columns = Schema::getColumnListing($name);
            $data = $rows->map(function ($row) use ($columns, $name) {
                $row = (array) $row;

                foreach ($row as $column => $value) {
                    if ($value === null) {
                        continue;
                    }

                    if ($column === 'rules') {
                        // If value is plain text, convert each line to JSON array
                        $lines = preg_split('/\r\n|\r|\n/', $value);
                        $row[$column] = json_encode(array_map('trim', $lines));
                    }

                    if (Schema::getColumnType($name, $column) === 'json') {
                        if (!is_array($value) && !is_object($value)) {
                            $decoded = json_decode($value, true);

                            // If invalid JSON → wrap it safely
                            if (json_last_error() !== JSON_ERROR_NONE) {
                                $row[$column] = json_encode($value);
                            } else {
                                $row[$column] = json_encode($decoded);
                            }
                        }
                    }
                }
                return $row;
            })->toArray();

            DB::table($name)->insert($data);

            $this->info("Migrated: {$name}");
        }
        $this->info('SQLite → MySQL migration completed');
    }
}
