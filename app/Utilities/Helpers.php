<?php

if (! function_exists('generateUID')) {
    function generateUID($model, $length = 5): string
    {
        $attempts = 0;
        $maxAttempts = 10 * $length;  // Arbitrary: Giving it 10 times the length to attempt a unique ID generation

        do {
            $attempts++;

            $_uid = strtoupper(str_pad(mt_rand(0, pow(10, $length) - 1), $length, "0", STR_PAD_LEFT));

            $existingUID = $model::where('_uid', $_uid)->withTrashed()->first();

            if ($attempts >= $maxAttempts) {
                throw new Exception("Cannot generate a unique UID after {$maxAttempts} attempts.");
            }

        } while ($existingUID);

        return $_uid;
    }
}
