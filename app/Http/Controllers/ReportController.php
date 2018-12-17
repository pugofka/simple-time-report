<?php

namespace App\Http\Controllers;

use App\Report;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    protected $dateFormat = 'U';

    public function index()
    {
        $reports = Report::query()
            ->where('user_id', Auth::id())
            ->get();
        return view('reports.index', compact('reports'));
    }

    public function all(Request $request)
    {
        $userId = 'all';

        $users = User::query()
            ->get();

        $reports = Report::query()
            ->orderBy('report_start_date')
            ->get();

        if ($request->user) {
            $userId = $request->user;
            if ($userId !== 'all') {
                $reports = Report::query()
                    ->where('user_id', $userId)
                    ->get();
            }
        }
        return view('reports.all', compact('users', 'reports'));
    }

    public function reports() {
        return redirect(route('reports.all'));
    }

    public function create()
    {
        $plane_hours = Auth::user()->plane_hours;
        return view('reports.create', compact('plane_hours'));
    }



    public function store(Request $request)
    {

        $now = Carbon::now();
        $reportStartDate = clone $now;
        $reportStartDate = $reportStartDate->subDays($reportStartDate->dayOfWeekIso-1)->startOfDay();
        $reportEndDate = clone $reportStartDate;
        $reportEndDate = $reportEndDate->addDays(6)->endOfDay();
        $user_id = Auth::user()->id;
        $author = Auth::user()->name;
        $reportStartDate = Carbon::createFromFormat('Y-m-d H:i:s', $reportStartDate)
            ->format('d-m-Y');
        $reportEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $reportEndDate)
            ->format('d-m-Y');

        Report::create([
            'user_id' => $user_id,
            'author' => $author,
            'plane_hours' => Auth::user()->plane_hours,
            'fact_hours' => $request['fact_hours'],
            'week_hours' => $request['week_hours'],
            'effective_hours' => $request['effective_hours'],
            'report_start_date' =>  $reportStartDate,
            'report_end_date' => $reportEndDate
        ]);
        return redirect(route('reports.index'))->with('status', 'Отчет успешно создан');
    }



    public function edit($id, Request $request)
    {
        $report = Report::findOrFail($id);

        return view('reports.edit', compact('report'));
    }



    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->plane_hours     = $request->input('plane_hours');
        $report->fact_hours      = $request->input('fact_hours');
        $report->week_hours      = $request->input('week_hours');
        $report->effective_hours = $request->input('effective_hours');
        $report->save();

        return redirect(route('reports.index'))->with('status', 'Отчет успешно обновлен');
    }



    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect(route('reports.index'))->with('status', 'Отчет удален');
    }
}
