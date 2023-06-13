<?php

namespace App\Http\Controllers;

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

class InteractionController extends Controller
{

    public function __construct()
    {
        DB::enableQueryLog();
    }

    public function add(Request $request, $bid)
    {

        $userId = Auth::user()->userId;
        //dd($userId);
        //dd(status());
        //dd(Auth::user()->id);
        // $data['users'] = DB::table('wp_bookly_customers')->select('*')->orderBy('id', 'desc')->get();
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_customer_appointments.notes as notes',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_appointments.internal_note as internal_note',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            ->whereIn('wp_bookly_customer_appointments.status', ['pending'])
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->where('wp_bookly_customer_appointments.id', $bid)
            ->get();
        //dd($data['users']);
        $data['interaction'] = Interaction::where('customer_id', $data['users'][0]->id)->get();
        //dd($data['interaction']);
        return view('customer.addinteraction', $data);
    }

    public function view(Request $request, $bid)
    {

        $userId = Auth::user()->userId;
        //dd($userId);
        //dd(status());
        //dd(Auth::user()->id);
        // $data['users'] = DB::table('wp_bookly_customers')->select('*')->orderBy('id', 'desc')->get();
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_customer_appointments.notes as notes',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_appointments.internal_note as internal_note',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            //->whereIn('wp_bookly_customer_appointments.status', ['pending'])
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->where('wp_bookly_customer_appointments.id', $bid)
            ->get();
        //dd($data['users']);
        $data['interaction'] = Interaction::where('customer_id', $data['users'][0]->id)->get();
        //dd($data['interaction']);
        return view('customer.viewinteraction', $data);
    }

    public function list()
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
                'wp_bookly_customers.*'
            )
            ->whereIn('wp_bookly_customer_appointments.status', ['pending'])
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->whereNull('wp_bookly_customer_appointments.inVoice')
            ->get();
        //dd($data['users']);
        return view('customer.leadlist', $data);
    }
    public function invoice()
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
                'wp_bookly_customers.*'
            )
            ->where('wp_bookly_customer_appointments.status', 'approved')
            ->where('wp_bookly_appointments.staff_id', $userId)
            ->whereNull('wp_bookly_customer_appointments.inVoice')
            ->get();
        return view('invoice.upcoming', $data);
    }

    public function show(Request $request, $bid)
    {
        $userId = Auth::user()->userId;
        //dd($userId);
        //dd(status());
        //dd(Auth::user()->id);
        // $data['users'] = DB::table('wp_bookly_customers')->select('*')->orderBy('id', 'desc')->get();
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_customer_appointments.notes as notes',
                'wp_bookly_services.title as sname',
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_appointments.internal_note as internal_note',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*'
            )
            // ->whereIn('wp_bookly_customer_appointments.status', ['pending'])
            ->where(function ($q) use ($userId) {
                if (!is_null($userId)) {
                    $q->where('wp_bookly_appointments.staff_id', $userId);
                } else {
                }
            })
            ->where('wp_bookly_customer_appointments.id', $bid)
            ->get();
        //dd($data['users']);
        $data['interaction'] = Interaction::where('customer_id', $data['users'][0]->id)->get();
        //dd($data['interaction']);
        return view('interaction.addinteraction', $data);
    }
}
