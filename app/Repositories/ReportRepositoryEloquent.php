<?php
/**
 * Created by PhpStorm.
 * User: karmov
 * Date: 2019-04-15
 * Time: 17:24
 */

namespace App\Repositories;

use App\Contracts\ReportRepositoryContract;
use App\Model\Report;
use Illuminate\Support\Facades\Auth;


class ReportRepositoryEloquent implements ReportRepositoryContract
{
    public function getMyReports($reportCount, $sort)
    {
        $reports = Report::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', $sort)
            ->paginate($reportCount);

        return $reports;
    }
}