<?php

namespace App\Http\Controllers;

use App\Models\Lead;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;

class LeadController extends Controller
{
    public function index($id)
    {
        $leads = Lead::where('apartment_id', '=', $id)->get();
        // $leads = Lead::all();

        return view('leads.index', compact('leads'));
    }

    public function show(Lead $lead)
    {
        return view('leads.show', compact('lead'));
    }
}
