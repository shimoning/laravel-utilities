<?php

namespace Shimoning\LaravelUtilities\Seeders;

trait AskWithValidationTrait
{
    /**
     * コマンドライン入力をバリデートする
     *
     * @param string $question
     * @param callable $validator
     * @param string|int|null $default
     * @return string|int|null
     */
    public function askWithValidation(
        string $question,
        callable $validator,
        $default = null
    ): ?string {
        $input = $this->command->ask($question, $default);
        if (! $validator($input)) {
            $this->command->error('Input invalid. [ input = ' . ($input ?? 'null') . ' ]');
            return $this->askWithValidation($question, $validator, $default);
        }

        return $input ?? $default;
    }

    /**
     * Check input be null or numeric
      *
      * @param string|null $input
      * @return bool
      */
    public function nullableNumeric(?string $input): bool
    {
        return $input === null || \is_numeric($input);
    }
}
