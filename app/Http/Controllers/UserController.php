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

class UserController extends Controller
{

    public function __construct()
    {
        DB::enableQueryLog();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->userId;

        $data['completed'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->select('wp_bookly_customer_appointments.status', DB::raw('count(*) as total'))
            ->where(function ($q) use ($userId) {
                if (!is_null($userId)) {
                    $q->where('wp_bookly_appointments.staff_id', $userId);
                } else {
                }
            })
            ->groupBy('wp_bookly_customer_appointments.status')
            ->get();

        //dd($data['users']);
        //dd(DB::getQueryLog());
        if (!is_null($userId)) {
            $data['customer'] = 0;
        } else {
            $data['customer'] = DB::table('wp_bookly_customers')->count();
        }

        //dd($data);
        //
        return view('dashboard', $data);
    }

    public function invoicestore(Request $request)
    {

        try {
            //
            $request->validate([
                'paidAmount' => 'required'
            ]);

            $data = $request->all();

            $value = array(
                'paidAmount' => $data['paidAmount']
            );

            $id = $data['nid'];

            DB::table('wp_bookly_customer_appointments')->where('id', $id)->update($value);

            $notification = array(
                'message' => 'Amount Added',
                'alert-type' => 'success'
            );

            return back()->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function generatePDF(Request $request)
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
                ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
                ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
                ->join('wp_bookly_payments', 'wp_bookly_customer_appointments.payment_id', '=', 'wp_bookly_payments.id')
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
                    'wp_bookly_services.title as sname',
                    'wp_bookly_services.price as sprice',
                    'wp_bookly_appointments.start_date as sstart_date',
                    'wp_bookly_appointments.end_date as send_date',
                    'wp_bookly_staff.full_name as staffname',
                    'wp_bookly_customers.*',
                    'wp_bookly_payments.paid as paidaamount',
                    'wp_bookly_payments.type as pm_type',
                    'wp_bookly_payments.total as pm_total',
                    'wp_bookly_payments.paid as pm_paid',
                    'wp_bookly_payments.paid_type as pm_paid_type',
                    'wp_bookly_payments.status as pm_status',
                )
                ->where('wp_bookly_customer_appointments.id', $id)
                ->get();

            //dd($data['invoiceData']);

            //);

            $data['extraService'] = DB::table('extra_services')->where('bid', $id)->get()->toArray();


            $filename = "INVOICE_" . $id;
            //$path = asset('invoice/');
            $path = public_path() . '/invoice';

            if (!File::exists($path)) {
                File::makeDirectory($path, $mode = 0755, true, true);
            } else {
            }

            $pdf = PDF::loadView('pdf.invoice', $data)->save($path . '/' . $filename . '.pdf');;

            //$pdf = PDF::loadView('myPDF', $data)->save('public/invoice/'.$path.'.pdf');
            //$pdf = PDF::loadView('pdf.orderConfirmationPdf', $data)->save('storage/app/public/'.$path.'.pdf');

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
        } catch (\Exception $ex) {
            dd($ex->getMessage());
            $notification = array(
                'message' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    public function upcomingInvoice()
    {
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
            ->get();
        return view('invoice.upcoming', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['users'] = DB::table('users')->select('*')->get();
        return view('users.list', $data);
    }

    public function useradd()
    {
        //
        return view('users.add');
    }

    public function customersService($id)
    {
        $data['users'] = DB::table('wp_bookly_customer_appointments')
            ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
            ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
            ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
            ->select('wp_bookly_services.*', 'wp_bookly_appointments.*', 'wp_bookly_staff.*')
            ->where('wp_bookly_customer_appointments.customer_id', $id)
            //->where('wp_bookly_customer_appointments.status', 'approved')
            ->get();
        // dd($data);
        return view('customer.servicelist', $data);
    }

    public function customers()
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
            //->where('wp_bookly_appointments.staff_id', $userId)
            ->where(function ($q) use ($userId) {
                if (!is_null($userId)) {
                    $q->where('wp_bookly_appointments.staff_id', $userId);
                } else {
                }
            })
            ->get();
        //dd($data['users']);
        //dd(DB::getQueryLog());
        return view('customer.list', $data);
    }

    public function interaction()
    {
        $userId = Auth::user()->userId;

        //echo convertYmdToMdy('2022-12-15');
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
            ->whereIn('wp_bookly_customer_appointments.status', status())
            ->where(function ($q) use ($userId) {
                if (!is_null($userId)) {
                    $q->where('wp_bookly_appointments.staff_id', $userId);
                } else {
                }
            })
            // ->where('wp_bookly_appointments.staff_id', '6')
            ->get();
        //dd($data);
        return view('customer.interactionlist', $data);
    }

    public function notes(Request $request)
    {
        try {
            $userId = Auth::user()->userId;
            $data = $request->all();

            //dd($data);
            $update = array(
                'status' => $data['_action'],
                'crmStatus' => $data['_action'],
                'notes' => $data['notes']
            );
            DB::table('wp_bookly_customer_appointments')->where('id', $data['bid'])->update($update);

            $bca  = $data['bid'];
            //$getData = "Call QUery";
            $getData = DB::table('wp_bookly_customer_appointments')
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
                    'wp_bookly_staff.email as staffemail',
                    'wp_bookly_staff.phone as staffphone',
                    'wp_bookly_customers.*'
                )
                ->where('wp_bookly_customer_appointments.id', $bca)
                ->get();
            //dd($getData);

            //$getData[0]->email = "shashiranjan54@gmail.com";

            $staffName = $getData[0]->staffname;
            $serviceName = $getData[0]->sname;

            $inserArr = array(
                'book_id' => $bca,
                'staff_id' => $userId,
                'customer_id' => $data['cid'],
                'status' => $data['_action'],
                'remarks' => $data['notes']
            );

            if ($data['_action'] == 'approved') {
                //dd("approved1");
                Interaction::insert($inserArr);
                $subject = $staffName . ' will serve your request for ' . $serviceName;
                $emails = $getData[0]->email;
                //dd($emails);
                Mail::send('email.customer.approved', ["data" => $getData[0]], function ($message) use ($subject, $emails) {
                    $message->to($emails);
                    $message->subject($subject);
                    // $message->attach($filename);
                    //return redirect()->back()->with('success', 'Mail sent successfully.');
                });
            } elseif ($data['_action'] == 'cancelled') {
                //dd("approved2");
                Interaction::insert($inserArr);
                $subject = 'Booking cancellation';
                $emails = $getData[0]->email;
                Mail::send('email.customer.cancel', ["data" => $getData[0]], function ($message) use ($subject, $emails) {
                    $message->to($emails);
                    $message->subject($subject);
                    // $message->attach($filename);
                    //return redirect()->back()->with('success', 'Mail sent successfully.');
                });
            } elseif ($data['_action'] == 'rejected') {
                //dd("approved3");
                Interaction::insert($inserArr);
                $subject = 'Booking rejection';
                $emails = $getData[0]->email;
                Mail::send('email.customer.rejected', ["data" => $getData[0]], function ($message) use ($subject, $emails) {
                    $message->to($emails);
                    $message->subject($subject);
                    // $message->attach($filename);
                    //return redirect()->back()->with('success', 'Mail sent successfully.');
                });
            } else {
                Interaction::insert($inserArr);
            }

            //dd("approved4");





            $notification = array(
                'message' => 'Notes Updated',
                'alert-type' => 'success'
            );

            return redirect()->route('invoice.list')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //
            $request->validate([
                'userId' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'conf_password' => 'required_with:password|same:password|min:6',
                'mobile' => 'required|digits:10',
                'role' => 'required|integer',
            ]);

            $data = $request->all();

            $value = array(
                'userId' => $data['userId'],
                'role' => $data['role'],
                'name' => $data['name'],
                'email' => $data['email'],
                'mobile' => $data['mobile'],
                'password' => Hash::make($data['password'])
            );

            DB::table('users')->insert($value);

            $notification = array(
                'message' => 'user Added',
                'alert-type' => 'success'
            );

            return redirect("dashboard")->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => $ex->getMessage(),
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
    }
    public function leads()
    {
        //DB::enableQueryLog();
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
            ->where('wp_bookly_customer_appointments.status', 'pending')
            ->get();
        //dd($data);

        //dd(DB::getQueryLog());
        return view('customer.leads', $data);
    }

    public function email()
    {
        $data['emails'] = DB::table('wp_bookly_customers')->select('email')->get();

        return view('email', $data);
    }

    public function sendemail(Request $request)
    {
        try {
            $filename = '';
            $getData = $request->all();

            $input = $request->validate([
                'toemail' => 'required',
                //'attachment' => 'required',
            ]);




            $emails = $request->toemail;
            $subject = $request->subject;

            $data['message'] = $request->mailcontent;
            if (isset($getData['attachment']) && !empty($getData)) {


                $path = public_path('uploads');
                File::cleanDirectory($path);
                $attachment = $request->file('attachment');
                //dd($attachment);


                $name = time() . '.' . $attachment->getClientOriginalExtension();;

                // create folder
                if (!File::exists($path)) {
                    File::makeDirectory($path, $mode = 0777, true, true);
                }
                $attachment->move($path, $name);

                $filename = $path . '/' . $name;
                // dd($filename);
            }

            //Mail::to($emails)->send(new Notification($filename));


            Mail::send('notification', ["data" => $data], function ($message) use ($subject, $emails, $filename) {
                $message->bcc($emails);
                $message->subject($subject);

                if (!empty($filename)) {
                    $message->attach($filename);
                }
            });
            return redirect()->back()->with('success', 'Mail sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function invoiceshow($id)
    {

        try {

            $data['invoiceData'] = DB::table('wp_bookly_customer_appointments')
                ->join('wp_bookly_appointments', 'wp_bookly_customer_appointments.appointment_id', '=', 'wp_bookly_appointments.id')
                ->join('wp_bookly_services', 'wp_bookly_appointments.service_id', '=', 'wp_bookly_services.id')
                ->join('wp_bookly_staff', 'wp_bookly_appointments.staff_id', '=', 'wp_bookly_staff.id')
                ->join('wp_bookly_payments', 'wp_bookly_customer_appointments.payment_id', '=', 'wp_bookly_payments.id')
                ->join('wp_bookly_customers', 'wp_bookly_customer_appointments.customer_id', '=', 'wp_bookly_customers.id')
                ->select(
                    'wp_bookly_customer_appointments.id as bid',
                    'wp_bookly_customer_appointments.paymentType as paymentType',
                    'wp_bookly_customer_appointments.paidAmount as paidAmount',
                    'wp_bookly_customer_appointments.inVoice as inVoice',
                    'wp_bookly_customer_appointments.updated_at as updated_at',
                    'wp_bookly_services.title as sname',
                    'wp_bookly_services.price as sprice',
                    'wp_bookly_appointments.start_date as sstart_date',
                    'wp_bookly_appointments.end_date as send_date',
                    'wp_bookly_staff.full_name as staffname',
                    'wp_bookly_customers.*',
                    'wp_bookly_payments.type as pm_type',
                    'wp_bookly_payments.total as pm_total',
                    'wp_bookly_payments.paid as pm_paid',
                    'wp_bookly_payments.paid_type as pm_paid_type',
                    'wp_bookly_payments.status as pm_status',
                )
                ->where('wp_bookly_customer_appointments.id', $id)
                ->get();
            $data['extraService'] = DB::table('extra_services')->where('bid', $id)->get()->toArray();
            //dd(DB::getQueryLog());
            //dd($data['invoiceData']);
            return view('invoice.view', $data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('success', $e->getMessage());
        }
    }
    public function extraDelete($id)
    {

        try {
            //dd($id);
            $delete = DB::table('extra_services')->where('id', $id)->delete();
            if ($delete) {
                $message = "Service Delete Succesfully!";

                $notification = array(
                    'message' => 'Service Delete Succesfully!',
                    'alert-type' => 'success'
                );
                return redirect()->back()->with($notification);
            } else {

                $notification = array(
                    'message' => 'Service Not Found!',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            $message = $e->getMessage();
            $message = "Something Went Wrong!";
            $notification = array(
                'message' => $message,
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
