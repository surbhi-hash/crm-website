<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use Illuminate\Http\Request;
use App\Models\Interaction;
use Hash;
use Session;
use DB;
use File;
use Mail;
use PDF;
use App\Mail\Notification;
use Illuminate\Support\Facades\Auth;

class BillingController extends Controller
{


    public function billing()
    {
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
                'wp_bookly_customer_appointments.inVoice as inVoice',
                'wp_bookly_customers.*'
            )
            ->where('wp_bookly_customer_appointments.status', 'approved')
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->where('wp_bookly_customer_appointments.inVoice', '!=', '')
            ->get();
        return view('customer.billinglist', $data);
    }
}
