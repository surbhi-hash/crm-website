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
use Exception;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {

        try {
           // dd($request->all());
            $userId = Auth::user()->userId;
            $remarks ='';
            $newSubTotal = 0;
            if ($request->service) {
                //echo sizeof($request->service);
                for ($s = 0; $s < sizeof($request->service); $s++) {
                    $insertSer = array(
                        'bid' => $request->bid,
                        'service_name' => $request->service[$s],
                        'price' => $request->price[$s],
                        'desc' => $request->desc[$s],
                        'created_by' => $userId
                    );
                    DB::table('extra_services')->insert($insertSer);
                    $newSubTotal+=$request->price[$s];
                }
                $paymentType = $request->paymentType;
                $subTotal = $request->subtotal+$newSubTotal;
                if($paymentType=='Cash'){
                    $taxAmount = '0';
                }else{
                    $taxAmount = ($subTotal*35)/1000;
                }
                
                $paidAmount = $request->paidAmount;
                $totalAmount = ($subTotal+$taxAmount)-$paidAmount;
                
                
                $remarksArr = array(
                    'extra_remarks' => $remarks,
                    'subtotal' => $subTotal,
                    'taxAmount' => $taxAmount,
                    'paidAmount' => $paidAmount,
                    'totalAmount' => $totalAmount,
                    'paymentType' => $paymentType
                );
            }
            else{
                $newSubTotal =0;
                $paymentType = $request->paymentType;
                $subTotal = $request->subtotal+$newSubTotal;
                if($paymentType=='Cash'){
                    $taxAmount = '0';
                }else{
                    $taxAmount = ($subTotal*35)/1000;
                }
                
                $paidAmount = $request->paidAmount;
                $totalAmount = ($subTotal+$taxAmount)-$paidAmount;
                
                
                $remarksArr = array(
                    'extra_remarks' => $remarks,
                    'subtotal' => $subTotal,
                    'taxAmount' => $taxAmount,
                    'paidAmount' => $paidAmount,
                    'totalAmount' => $totalAmount,
                    'paymentType' => $paymentType
                );
                
            }
            if ($request->docs_upload) {

                $image = $request->file('docs_upload');
                $input['imagename'] = date('Ymd') . '_' . time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/docs');
                $image->move($destinationPath, $input['imagename']);
                $uploadtSer = array(
                    'bid' => $request->bid,
                    'document' => $input['imagename'],
                    'created_by' => $userId
                );
                DB::table('uploads')->insert($uploadtSer);
            }
            if ($request->remarks) {
                $remarks = $request->remarks;
            }
            
            
                DB::table('wp_bookly_customer_appointments')->where('id', $request->bid)->update($remarksArr);
            $notification = array(
                'message' => "Bills Updated",
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
            //dd($request->all());
            //return view('customer.billinglist', $data);
        } catch (Exception $e) {
            //return $e->getMessage();
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
