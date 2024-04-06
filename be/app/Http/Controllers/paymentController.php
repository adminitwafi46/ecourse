<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
//model payment
use App\Models\payment;
//model course
use App\Models\course;

class paymentController extends Controller
{
    //store
    public function store(Request $request)
    {
        

        //external_id = INV + user_id-course_id + date ddmmyyyyss + 5 random number
        $external_id = 'INV' . $request->user_id . '-' . $request->course_id . date('dmYHis') . rand(10000, 99999);
        $course_price = course::find($request->course_id)->price;
        //create invoice
        $invoice = $this->createInvoice([
            'external_id' => $external_id,
            'amount' => $course_price + 5000,
            'invoice_duration' => 6000,
        ]);

        //create payment
        $payment = payment::create([
            'user_id' => $request->user_id,
            'course_id' => $request->course_id,
            'invoice' => $external_id,
            'status' => 'PENDING',
            'price' => $course_price + 5000,
            'payment_url' => $invoice['invoice_url'],
        ]);

        return response()->json([
            'message' => 'Payment created',
            'payment' => $payment,
        ]);

    }

    public function createInvoice($request)
    {
        $api_key = base64_encode(env('XENDIT_SECRET_KEY'));
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $api_key,
        ];

        $res = Http::withHeaders($headers)->post('https://api.xendit.co/v2/invoices', [
            'external_id' => $request['external_id'],
            'amount' => $request['amount'],
            'invoice_duration' => $request['invoice_duration'],
        ]);

        return json_decode($res->body(), true);
    }

    //tagihan where user_id == auth()->user()->id
    public function tagihan()
    {
        //$tagihan join dengan courses (course_id) where user_id == auth()->user()->id 
        $tagihan = payment::join('courses', 'payments.course_id', '=', 'courses.id')
            ->where('payments.user_id', auth()->user()->id)
            ->select('payments.*', 'courses.name as course_name')
            ->get();

        return response()->json([
            'message' => 'Tagihan',
            'tagihan' => $tagihan,
        ]);
    }

    //invoice
    public function invoice($invoice)
    {
        //find invoice where invoice == $invoice, join dengan courses dan user
        $invoice = payment::join('courses', 'payments.course_id', '=', 'courses.id')
            ->join('users', 'payments.user_id', '=', 'users.id')
            ->where('payments.invoice', $invoice)
            ->select('payments.*', 'courses.name as course_name', 'users.name as user_name')
            ->first();

        if (!$invoice) {
            return response()->json([
                'message' => 'Invoice not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Invoice founded',
            'invoice' => $invoice,
        ]);
    }
    
}
