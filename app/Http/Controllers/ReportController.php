<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('report.index');
    }

    public function reportSuccess()
    {
        return view('report.success');
    }

    public function listTps()
    {
        return view('tps.index');
    }
    public function detailTps($a)
    {
        return view('tps.detail', compact('a'));
    }
}
