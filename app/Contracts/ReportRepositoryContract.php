<?php
/**
 * Created by PhpStorm.
 * User: karmov
 * Date: 2019-04-15
 * Time: 17:25
 */

namespace App\Contracts;


interface ReportRepositoryContract
{
    public function getMyReports($reportCount, $sort);
}