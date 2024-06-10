<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Models\Statistic;
use Illuminate\Http\Request;

class AdminStatsController extends Controller
{
    public function adminDashboard(){
        $stats=Statistic::all();
        return response()->json($stats,200);
    }
}
