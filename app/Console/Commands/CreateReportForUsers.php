<?php

namespace App\Console\Commands;

use App\Notifications\ReportCreated;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Role as RoleConst;

class CreateReportForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereHas('roles', function($q){
            $q->where('name', RoleConst::ROLE_USER);
        })->get();

        $now = Carbon::now();
        $lastMonthDayOfWeek = clone $now;
        $lastMonthDayOfWeek = $lastMonthDayOfWeek->subMonth(1)->endOfMonth();

        if ($lastMonthDayOfWeek->dayOfWeek < 5) {
            $weekDays = 7;
            $missingDays = $weekDays - $lastMonthDayOfWeek->dayOfWeek;
            $reportStartWeek = clone $now;
            $reportStartWeek = Carbon::createFromFormat('Y-m-d H:i:s', $reportStartWeek->subMonth(1)->endOfMonth()->addDays(1));
            $reportEndWeek = clone $now;
            $reportEndWeek = Carbon::createFromFormat('Y-m-d H:i:s', $reportEndWeek->subMonth(1)->endOfMonth()->addDays($missingDays));

            $users->each(function($user) use ($reportEndWeek, $reportStartWeek) {

                DB::table('reports')->insert(
                    [
                        'user_id' => $user->id,
                        'author' => $user->name . ' ' . $user->lastname,
                        'plane_hours' => $user->plane_hours,
                        'fact_hours' => 0,
                        'week_hours' => 0,
                        'effective_hours' => 0,
                        'report_start_date' => $reportStartWeek,
                        'report_end_date' => $reportEndWeek
                    ]
                );
            });
        } else {
            $users->each(function($user) {
                $reportStartWeek = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->startOfWeek())
                    ->format('d-m-Y');
                $reportEndWeek = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->endOfWeek())
                    ->format('d-m-Y');

                DB::table('reports')->insert(
                    [
                        'user_id' => $user->id,
                        'author' => $user->name . ' ' . $user->lastname,
                        'plane_hours' => $user->plane_hours,
                        'fact_hours' => 0,
                        'week_hours' => 0,
                        'effective_hours' => 0,
                        'report_start_date' => $reportStartWeek,
                        'report_end_date' => $reportEndWeek
                    ]
                );
            });
        }

        $firstUser = User::query()
            ->firstOrFail();

        Notification::send($firstUser, new ReportCreated());
    }
}

