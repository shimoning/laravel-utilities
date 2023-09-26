<?php

namespace Shimoning\LaravelUtilities\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Truncate tables all
 */
class TruncateAllTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run($auto = false)
    {
        if ($this->command && $auto === false) {
            $yn = \str_starts_with(
                $this->command->askWithCompletion('Should you truncate data from tables all? [y/N]', ['y', 'n'], 'n'),
                'y'
            );

            if (! $yn) {
                $this->command->warn('Canceled.');
                return;
            }
        }

        $this->command?->info('Start: Truncate');

        Schema::disableForeignKeyConstraints();

        foreach ($this->getTargetTableNames() as $tableName) {
            $this->command?->getOutput()?->writeln("<comment>Truncating:</comment> {$tableName}");
            DB::table($tableName)->truncate();
            $this->command?->getOutput()?->writeln("<info>Truncated:</info>  {$tableName}");
        }

        Schema::enableForeignKeyConstraints();

        $this->command?->info('End: Truncate');
    }

    /**
     * @return string[]
     */
    private function getTargetTableNames($excludes = ['migrations']): array
    {
        return array_diff($this->getAllTableNames(), $excludes);
    }

    /**
     * @return string[]
     */
    private function getAllTableNames(): array
    {
        return DB::connection()->getDoctrineSchemaManager()->listTableNames();
    }
}
