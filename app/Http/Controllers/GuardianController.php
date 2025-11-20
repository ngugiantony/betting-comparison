<?php

namespace App\Http\Controllers;

use App\Models\Guardian;
class GuardianController extends Controller
{

    public function index()
    {
        $guardian = Guardian::where('user_id', auth()->user()->id)->first();
        $students = $guardian->students;
        return view('parents.dashboard', compact('students'));
    }  
    

    

    /**
     * Display the parent's Personal info .
     */

    public function parent_profile(){
        //Auth user (Guardian)
        $auth_user = auth()->user();
        $guardian = Guardian::where('user_id', $auth_user->id)->first();

        return view('parents.profile', compact( 'guardian'));
    }
}
