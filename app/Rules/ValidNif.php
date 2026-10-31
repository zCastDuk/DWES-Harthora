<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidNif implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $nif = strtoupper(trim((string) $value));

        if (! preg_match('/^[XYZ0-9]\d{7}[A-Z]$/', $nif)) {
            $fail('El :attribute no tiene un formato válido.');
            return;
        }

        $number = strtr(substr($nif, 0, 8), ['X' => '0', 'Y' => '1', 'Z' => '2']);
        $expectedLetter = 'TRWAGMYFPDXBNJZSQVHLCKE'[(int) $number % 23];

        if ($nif[8] !== $expectedLetter) {
            $fail('La letra del :attribute no es correcta.');
        }
    }
}
