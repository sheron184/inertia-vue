<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Inertia\Inertia;
use App\Domain\Facades\StudentFacades;

class DashboardController extends Controller{
    public function index(Request $req){
        return Inertia::render('Dashboard',["students"=>StudentFacades::all()]);
    }
}
