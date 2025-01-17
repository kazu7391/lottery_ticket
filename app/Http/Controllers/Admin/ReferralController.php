<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Referral;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $pageTitle       = 'Manage Referral';
        $referrals       = Referral::get();
        $commissionTypes = [
            'lottery_purchase_commission' => 'Lottery Purchase Commission',
            'lottery_win_commission'      => 'Lottery Win Commission',
        ];
        return view('admin.referral.index', compact('pageTitle', 'referrals', 'commissionTypes'));
    }

    public function status($type)
    {
        return GeneralSetting::changeStatus(1, $type);
    }

    public function update(Request $request)
    {
        $request->validate([
            'percent'         => 'required',
            'percent*'        => 'required|numeric',
            'commission_type' => 'required|in:lottery_purchase_commission,lottery_win_commission',
        ]);
        $type = $request->commission_type;

        Referral::where('commission_type', $type)->delete();

        for ($i = 0; $i < count($request->percent); $i++) {
            $referral                  = new Referral();
            $referral->level           = $i + 1;
            $referral->percent         = $request->percent[$i];
            $referral->commission_type = $request->commission_type;
            $referral->save();
        }

        $notify[] = ['success', 'Referral commission setting updated successfully'];
        return back()->withNotify($notify);
    }
}
