<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use DB;
use File;
use Mail;
use PDF;
use App\Mail\Notification;
use Illuminate\Support\Facades\Auth;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->dateRange)) {
            // dd($request->dateRange);
            $date = explode("@", $request->dateRange);
        } else {
            $date = array();
        }
        $userId = Auth::user()->userId;
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_customer_appointments.inVoice as inVoice',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            ->where('wp_bookly_customer_appointments.status', 'approved')
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->where('wp_bookly_customer_appointments.inVoice', '!=', '')
            ->where(function ($q) use ($date) {
                if (sizeof($date) == '2') {
                    $q->whereBetween('wp_bookly_customer_appointments.updated_at', [$date[0] . " 00:00:00", $date[1] . " 23:59:59"]);
                    //whereBetween('reservation_from', [$date, $to])
                } else {
                }
            })
            ->get();
        //dd($data['users']);
        return view('reports.list', $data);
    }
}
