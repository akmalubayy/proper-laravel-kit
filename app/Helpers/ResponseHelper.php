<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('ResponseError')) {
    function ResponseError(Throwable $e, string $message = 'Terjadi kesalahan', bool $log = true)
    {
        // if ($log) {
        //     Log::error($e);
        // }

        return redirect('/')->with('error', $message);
    }
}
