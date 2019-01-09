<?php
/**
 * MyClass File Doc Comment
 * php version 7.2
 *
 * @category MyClass
 * @package  MyPackage
 * @author   Pugofka <info@pugofka.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 */
namespace App\Http\Controllers;
use App\Report;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * MyClass Class Doc Comment
 *
 * @category Class
 * @package  MyPackage
 * @author   Pugofka <info@pugofka.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.hashbangcode.com/
 */
class ReportController extends Controller
{
    protected $dateFormat = 'U';
    /**
     * Page for reports list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $reports = Report::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();
        return view('reports.index', compact('reports'));
    }

    /**
     * All list users for Admin
     *
     * @param Request $request The comment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function all(Request $request)
    {
        $userId = 'all';
        $users = User::query()
            ->get();

        $reports = Report::query()
            ->orderBy('created_at', 'desc')
            ->get();

        if ($request->user) {
            $userId = $request->user;
            if ($userId !== 'all') {
                $reports = Report::query()
                    ->where('user_id', $userId)
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
        }
        return view('reports.all', compact('users', 'reports'));
    }

    /**
     * Creating report for User
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $plane_hours = Auth::user()->plane_hours;
        return view('reports.create', compact('plane_hours'));
    }

    /**
     * Saving report for user
     *
     * @param Request $request The comment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $now = Carbon::now();
        $reportStartDate = clone $now;
        $reportStartDate = $reportStartDate
            ->subDays($reportStartDate->dayOfWeekIso-1)
            ->startOfDay();
        $reportEndDate = clone $reportStartDate;
        $reportEndDate = $reportEndDate->addDays(6)->endOfDay();
        $user_id = Auth::user()->id;
        $author = Auth::user()->name;
        $reportStartDate = Carbon::createFromFormat('Y-m-d H:i:s', $reportStartDate)
            ->format('d-m-Y');
        $reportEndDate = Carbon::createFromFormat('Y-m-d H:i:s', $reportEndDate)
            ->format('d-m-Y');

        Report::create(
            [
                'user_id' => $user_id,
                'author' => $author,
                'plane_hours' => Auth::user()->plane_hours,
                'fact_hours' => $request['fact_hours'],
                'week_hours' => $request['week_hours'],
                'effective_hours' => $request['effective_hours'],
                'report_start_date' =>  $reportStartDate,
                'report_end_date' => $reportEndDate
            ]
        );
        return redirect(route('reports.index'))
            ->with('status', 'Отчет успешно создан');
    }

    /**
     * Editing report for user
     *
     * @param int     $id      The comment
     * @param Request $request The comment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $report = Report::findOrFail($id);

        return view('reports.edit', compact('report'));
    }

    /**
     * Updating report for user
     *
     * @param Request $request The comment
     * @param int     $id      The comment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $report->plane_hours     = $request->input('plane_hours');
        $report->fact_hours      = $request->input('fact_hours');
        $report->week_hours      = $request->input('week_hours');
        $report->effective_hours = $request->input('effective_hours');
        $report->save();

        return redirect(route('reports.index'))
            ->with('status', 'Отчет успешно обновлен');
    }

    /**
     * Destroy report for user
     *
     * @param int $id The comment
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect(route('reports.index'))->with('status', 'Отчет удален');
    }
}
