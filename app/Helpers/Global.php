<?php

use Carbon\Carbon;

function greetings()
{
    $timeOfDay = Carbon::now()->setTimezone('Asia/Jakarta')->format('H');

    if ($timeOfDay < 11) {
        return 'Good Morning';
    } elseif ($timeOfDay < 17) {
        return 'Good Afternoon';
    } else {
        return 'Good Evening';
    }
}
