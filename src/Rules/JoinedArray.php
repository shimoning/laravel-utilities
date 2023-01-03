<?php

namespace Shimoning\LaravelUtilities\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\ValidationRuleParser;
use Illuminate\Support\Str;

/**
 * 文字で区切られた配列のバリデーション
 * ex) 1,2,3,4
 */
class JoinedArray implements Rule
{
    use ValidatesAttributes;

    /**
     * 配列内の個々の値のルール
     *
     * @var any
     */
    public $rule = null;

    /**
     * 区切り文字
     * @var string
     */
    public $separator = ',';

    /**
     * 最小数
     * @var int|null
     */
    public $min = null;

    /**
     * 最大数
     * @var int|null
     */
    public $max = null;

    /**
     * エラーメッセージ
     *
     * @var string|null
     */
    protected $customMessage = null;

    /**
      * @param any $validator
      * @param array|null $options
      */
    public function __construct($rule = null, $options = null)
    {
        $this->rule = $rule;

        if (!empty($options['separator'])) {
            $this->separator = $options['separator'];
        }

        if (isset($options['min'])) {
            $this->min = (int)$options['min'];
        }
        if (isset($options['max'])) {
            $this->max = (int)$options['max'];
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $values = \explode($this->separator, \str_replace(' ', '', $value));

        if (! \is_null($this->min) && \count($values) < $this->min) {
            $this->customMessage = trans(
                'laravel-utilities::validation.joined-array-min',
                [ 'separator' => $this->separator, 'min' => $this->min ],
            );
            return false;
        }
        if (! \is_null($this->max) && \count($values) > $this->max) {
            $this->customMessage = trans(
                'laravel-utilities::validation.joined-array-max',
                [ 'separator' => $this->separator, 'max' => $this->max ],
            );
            return false;
        }

        foreach ($values as $v) {
            if (! $this->validate($attribute, $v)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 配列内のバリデーション
     *
     * @see \Illuminate\Validation\Validator validateAttribute
     * @param string $attribute
     * @param string $value
     * @return bool
     */
    private function validate($attribute, $value)
    {
        if (! $this->rule) {
            return true;
        }

        [$rule, $parameters] = ValidationRuleParser::parse($this->rule);
        if ($rule === '') {
            return true;
        }

        if ($rule instanceof Rule) {
            $validated = $rule->passes($attribute, $value);
            if (!$validated) {
                $this->customMessage = $rule->message();
            }
            return $validated;
        }

        $method = "validate{$rule}";
        if (\method_exists($this, $method)) {
            $validated = $this->$method($attribute, $value, $parameters);
            if (!$validated) {
                $lowerRule = Str::snake($rule);
                $this->customMessage = trans("validation.{$lowerRule}");
            }
            return $validated;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->customMessage ?? trans(
            'laravel-utilities::validation.joined-array',
            [ 'separator' => $this->separator ]
        );
    }
}
