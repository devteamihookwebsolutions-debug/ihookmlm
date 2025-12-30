<?php

namespace User\App\Http\Controllers\Scheduler\Rank;

use User\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use User\App\Models\Scheduler\Rank\MRank;

class RankController extends Controller
{
    /**
     * This function is used to update cron rank
     *
     * @return \Illuminate\Http\Response
     */
    public function updateMembersRank()
    {
        MRank::updateMembersRank();
        return response('cron execute', 200);
    }

    public function createpdf()
    {
        $output['invoice'] = MRank::createpdf();
        // Old Bin_Template::createTemplate equivalent (view render)
        return response('cron execute', 200);
    }

    public function binresponse()
    {
        MRank::binresponse();
        return response('cron execute', 200);
    }

    public function transaction1()
    {
        MRank::transaction1();
        return response('cron execute', 200);
    }

    public function rewardsoverview1()
    {
        MRank::rewardsoverview();
        return response()->noContent();
    }

    public function rewardsoverview()
    {
        $output['value'] = MRank::rewardsoverview();
        // Blade render equivalent
        return view('components.common.testcheck', $output);
    }

    public function topsellers()
    {
        MRank::topsellers();
        return response()->noContent();
    }

    public function completedschedule()
    {
        MRank::completedschedule();
        return response()->noContent();
    }

    public function loginbackurl()
    {
        MRank::loginbackurl();
        return response()->noContent();
    }

    public function getresponce()
    {
        MRank::getresponce();
        return response()->noContent();
    }

    public function squareup()
    {
        MRank::squareup();
        return response()->noContent();
    }
}
