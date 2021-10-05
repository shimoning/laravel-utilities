<?php

namespace Shimoning\LaravelUtilities\Seeders;

trait AskWithValidationTrait
{
    public function askWithValidation(
        string $question,
        callable $validator,
        $default = null
    ): string {
        $input = $this->command->ask($question, $default);
        if (! $validator($input)) {
            $this->command->error('Input invalid. [ input = ' . ($input ?? 'null') . ' ]');
            return $this->askWithValidation($question, $validator, $default);
        }

        return $input;
    }

    /**
     * Check input be null or numeric
     *
     * @param string $input
     * @return boolean
     */
    public function nullableNumeric($input) {
        return $input === null || \is_numeric($input);
    }
}
