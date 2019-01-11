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
        if ($request->week_hours > $request->fact_hours) {
            return redirect(url('/my-reports/' . $id . '/edit'))
                ->with(
                    'status',
                    'Рабочие часы не могут превышать фактического рабочего времени.'
                );
        } elseif ($request->effective_hours > $request->week_hours) {
            return redirect(url('/my-reports/' . $id . '/edit'))
                ->with(
                    'status',
                    'Эффективные рабочие часы не могут превышать рабочих часов.'
                );
        } else {
            $report->plane_hours     = $request->input('plane_hours');
            $report->fact_hours      = $request->input('fact_hours');
            $report->week_hours      = $request->input('week_hours');
            $report->effective_hours = $request->input('effective_hours');
            $report->save();

            return redirect(route('reports.index'))
            ->with('status', 'Отчет успешно обновлен');
        }
    }
}
