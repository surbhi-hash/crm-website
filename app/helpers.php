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
if (!function_exists('leadCount')) {
    function leadCount()
    {
        $dateShow =  "2023-01-19";
        $userId = Auth::user()->userId;
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            ->whereIn('wp_bookly_customer_appointments.status', ['pending'])
            ->whereDate('wp_bookly_customer_appointments.created',  '>=', $dateShow)
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->whereNull('wp_bookly_customer_appointments.inVoice')
            ->orderBy('wp_bookly_customer_appointments.id', 'DESC')
            ->get()->count();
        return $data['users'];
    }
}
if (!function_exists('invoiceCount')) {
    function invoiceCount()
    {
        $dateShow =  "2023-01-19";
        $userId = Auth::user()->userId;
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            ->where('wp_bookly_customer_appointments.status', 'approved')
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->whereDate('wp_bookly_customer_appointments.created',  '>=', $dateShow)
            ->whereNull('wp_bookly_customer_appointments.inVoice')
            ->orderBy('wp_bookly_customer_appointments.id', 'DESC')
            ->get()->count();
        return $data['users'];
    }
}
