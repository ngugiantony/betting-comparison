<?php

namespace App\Http\Controllers;

use App\Jobs\SendTeacherAccountEmail;
use App\Jobs\SendTeacherAccountSms;
use App\Models\BrainGame;
use App\Models\ChartOfAccounts;
use App\Models\MpesaTransaction;
use App\Models\Sms;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTeacherRequest;
use App\Models\User;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Teacher;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\TeacherCreated;
use Illuminate\Support\Facades\Session;



class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    

      
        return view('admin.dashboard');
    }


    public function get_sms(){
        $messages = Sms::all();
        return view('admin.sms', compact('messages'));
    }



    //Display Transaction Details
    public function get_transactions(){
    
        return view('admin.transactions');
    }

  
    public function get_customers(){
        $customers = Guardian::with('user')->get();
        return view('admin.customers', compact('customers'));
    }
  

  
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

   


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    

}
