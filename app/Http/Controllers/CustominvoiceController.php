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
use Illuminate\Support\Carbon;

class CustominvoiceController extends Controller
{

    public function __construct()
    {
        DB::enableQueryLog();
    }

    

    public function customInvoiceList(){
        $userId = Auth::user()->userId;
        $list = $userId = Auth::user()->userId;
        $dateShow =  "2023-01-19";
        $userQuery = DB::table('wp_bookly_customer_appointments')
    ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
    ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
    ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
    ->select(
        'wp_bookly_customer_appointments.id as bid',
        'wp_bookly_staff.full_name as staffname',
        'wp_bookly_customers.*'
    )
    ->where('wp_bookly_customer_appointments.status', 'approved')
    ->where('wp_bookly_appointments.staff_id', $userId)
    ->where('wp_bookly_customers.custom_invoice', '2')
    ->whereDate('wp_bookly_customer_appointments.created', '>=', $dateShow)
    ->whereNull('wp_bookly_customer_appointments.inVoice')
    ->orderBy('wp_bookly_customer_appointments.id', 'DESC');

//dd($userQuery->toSql()); // Dump and die to see the SQL query

$user = $userQuery->get();
return view("customInvoice.custom_invoice", compact('user'));
    }
    public function customInvoiceadd(){
        return view("customInvoice.addcustomer");
    }

    public function custom_customer_store(Request $request){
        $userId = Auth::user()->userId;
        $customerData = [
            'full_name' => $request->customer_fname . $request->customer_lname,
            'first_name' => $request->customer_fname,
            'last_name' => $request->customer_lname,
            'phone' => $request->phone,
            'email' => $request->email,
            'street_number' => $request->street_number,
            'city' => $request->city,
            'state' => $request->state,
            'postcode' => $request->postcode,
            'source' => $request->source,
            'custom_invoice' => '2',
            'created' => Carbon::now(),
        ];
       
        $customerId = DB::table('wp_bookly_customers')->insertGetId($customerData);
      


       
        $staffId = [
            'staff_id' => $userId,
            
            'created' => Carbon::now(),
        ];

        $tech_id = DB::table('wp_bookly_appointments')->insertGetId($staffId);

        
        DB::table('wp_bookly_customer_appointments')->insert([
            'customer_id' => $customerId,
            'appointment_id' => $tech_id,
            'created' => Carbon::now(),
        ]);
        
    
        return redirect()->back()->with('success', 'Customer added successfully!');
    }

    public function custominvoiceshow($id)
    {

        try {

            $data['invoiceData'] = DB::table('wp_bookly_customer_appointments')
                ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
               
                ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
               
                ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
                ->select(
                    'wp_bookly_customer_appointments.id as bid',
                    'wp_bookly_customer_appointments.paymentType as paymentType',
                    'wp_bookly_customer_appointments.paidAmount as paidAmount',
                    'wp_bookly_customer_appointments.inVoice as inVoice',
                    'wp_bookly_customer_appointments.updated_at as updated_at',
                   
                    'wp_bookly_appointments.start_date as sstart_date',
                    'wp_bookly_appointments.end_date as send_date',
                    'wp_bookly_staff.full_name as staffname',
                    'wp_bookly_customers.*',
                    
                )
                ->where('wp_bookly_customer_appointments.id', $id)
                ->get();
            $data['extraService'] = DB::table('extra_services')->where('bid', $id)->get()->toArray();
            //dd(DB::getQueryLog());
            //dd($data['invoiceData']);
            return view('customInvoice.view', $data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('success', $e->getMessage());
        }
    
}




// generate pdf 

public function generatecustomPDF(Request $request)
    {
        // $data = [
        //     'title' => 'Welcome to Thinkers Media com',
        //     'date' => date('m/d/Y')
        // ];

        try {

            $data = $request->all();


            $id = $data['nid'];


            $data['invoiceData'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
           
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
           
            ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
            ->select(
                'wp_bookly_customer_appointments.id as bid',
                'wp_bookly_customer_appointments.paymentType as paymentType',
                'wp_bookly_customer_appointments.subtotal as subtotal',
                'wp_bookly_customer_appointments.taxAmount as taxAmount',
                'wp_bookly_customer_appointments.paidAmount as paidAmount',
                'wp_bookly_customer_appointments.totalAmount as totalAmount',
                'wp_bookly_customer_appointments.inVoice as inVoice',
                'wp_bookly_customer_appointments.updated_at as invoice_date',
               
                'wp_bookly_appointments.start_date as sstart_date',
                'wp_bookly_appointments.end_date as send_date',
                'wp_bookly_staff.full_name as staffname',
                'wp_bookly_customers.*',
                
            )
            ->where('wp_bookly_customer_appointments.id', $id)
            ->get();
        $data['extraService'] = DB::table('extra_services')->where('bid', $id)->get()->toArray();


            $filename = "INVOICE_" . $id;
            //$path = asset('invoice/');
            $path = public_path() . '/invoice';

            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0755, true, true);
            } else {
            }

            $pdf = PDF::loadView('pdf.custominvoice', $data)->save($path . '/' . $filename . '.pdf');;

          

            //return $pdf->download($filename.".pdf");

            $value = array(
                'inVoice' => $filename
            );

            $userName =  trim($data['invoiceData'][0]->first_name) . ' ' . trim($data['invoiceData'][0]->last_name);
            $userEmail = trim($data['invoiceData'][0]->email);
            //$userTotal = number_format($data['invoiceData'][0]->totalAmount);
            $userTotal = $data['invoiceData'][0]->totalAmount;
            $data['paymentLink'] = base64_encode("name=" . $userName . "&email=" . $userEmail . "&amount=" . $userTotal);

            DB::table('wp_bookly_customer_appointments')->where('id', $id)->update($value);

            $subject = "Payment Invoice for your Service with Pest City USA";
            $emails = $data['invoiceData'][0]->email;
            $path = public_path() . '/invoice';
            $from = "admin@gmail.com";
            $attachPath = $path . '/' . $filename . '.pdf';
            //$data['message'] = "";


            Mail::send('invoiceEmail', ["data" => $data], function ($message) use ($from, $subject, $emails, $attachPath) {
                $message->to($emails);
                $message->from($from);
                $message->subject($subject);
                $message->attach($attachPath);
                //return redirect()->back()->with('success', 'Mail sent successfully.');
            });


            $notification = array(
                'message' => 'Invoice Generated',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        } 
        catch (\Exception $ex) {
            dd($ex->getMessage());
            $notification = array(
                'message' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
}
