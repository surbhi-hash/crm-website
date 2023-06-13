<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}
if (!function_exists('status')) {
    function status()
    {
        return array('Pending' => 'pending', 'Approved' => 'approved', 'Cancelled' => 'cancelled', 'Rejected' => 'rejected');
    }
}
if (!function_exists('servicesList')) {
    function servicesList()
    {
        return array('Industrial Pest Control', 'Bed Bugs Control', 'Mice/Rats Control', 'Wildlife Control', 'Mosquito Control', 'Bees/Wasp/Hornets', 'Fleas/Ticks', 'Ants/Spider/Bugs', 'Birds/Bats', 'Roaches Control', 'Inspection/estimate');
    }
}
