<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{


    public function index()
    {
        $reports = Report::query()
            ->where('user_id', Auth::id())
            ->get();
        return view('reports.index', compact('reports'));
    }

    public function all()
    {
        $reports = Report::query()
            ->get();
        return view('reports.all', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }



    public function store(Request $request)
    {
        $now = Carbon::now();
        $reportStartDate = clone $now;
        $reportStartDate = $reportStartDate->subDays($reportStartDate->dayOfWeekIso-1)->startOfDay();
        $reportEndDate = clone $reportStartDate;
        $reportEndDate = $reportEndDate->addDays(6)->endOfDay();

        $user_id = Auth::user()->id;
        $report = Report::create([
            'user_id' => $user_id,
            'plane_hours' => $request['plane_hours'],
            'fact_hours' => $request['fact_hours'],
            'week_hours' => $request['week_hours'],
            'effective_hours' => $request['effective_hours'],
            'report_start_date' =>  $reportStartDate,
            'report_end_date' => $reportEndDate
        ]);
        $report->save();
        return redirect(route('reports.index'))->with('status', 'Отчет успешно создан');
    }



    public function edit($id, Request $request)
    {
        $report = Report::find($id);

        return view('reports.edit', compact('report'));
    }



    public function update(Request $request, $id)
    {
        $report = Report::find($id);

        $report->plane_hours     = $request->input('plane_hours');
        $report->fact_hours      = $request->input('fact_hours');
        $report->week_hours      = $request->input('week_hours');
        $report->effective_hours = $request->input('effective_hours');


        $report->save();

        return redirect(route('reports.index'))->with('status', 'Отчет успешно обновлен');
    }



    public function destroy($id)
    {
        $report = Report::find($id);
        $report->delete();

        return redirect(route('reports.index'))->with('status', 'Отчет удален');
    }
}
