<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Currencies';
        $currencies = Currency::paginate(getPaginate());
        return view('admin.currency.index', compact('pageTitle', 'currencies'));
    }

    public function create()
    {
        $pageTitle = 'Add New Currency';
        return view('admin.currency.create', compact('pageTitle'));
    }

    public function edit($id)
    {
        $pageTitle = 'Edit Currency';
        $currency = Currency::where('id', $id)->first();
        return view('admin.currency.edit', compact('pageTitle', 'currency'));
    }

    public function store(Request $request)
    {
        $this->currencyValidation($request);

        $currency      = new Currency();
        $notification = 'Currency created successfully';

        DB::beginTransaction();
        try {
            $currency->currency  = $request->currency;
            $currency->symbol = $request->symbol;
            $currency->save();
            $notify[] = ['success', $notification];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        return to_route('admin.currencies.index')->withNotify($notify);
    }

    public function update(Request $request, $id)
    {
        $this->currencyValidation($request);

        $currency = Currency::where('id', $id)->first();
        $notification = 'Currency updated successfully';

        DB::beginTransaction();
        try {
            $currency->currency  = $request->currency;
            $currency->symbol = $request->symbol;
            $currency->save();
            $notify[] = ['success', $notification];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        return to_route('admin.currencies.index')->withNotify($notify);
    }

    public function delete($id)
    {
        $currency = Currency::where('id', $id)->first();
        $notification = 'Currency deleted successfully';

        DB::beginTransaction();
        try {
            $currency->delete();
            $notify[] = ['success', $notification];
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $notify[] = ['error', $e->getMessage()];
            return back()->withNotify($notify);
        }

        return to_route('admin.currencies.index')->withNotify($notify);
    }

    public function currencyValidation(Request $request)
    {
        $rules = [
            'currency' => 'required|string',
            'symbol'   => 'required|string'
        ];

        $messages = [
            'currency' => 'Currency is required.',
            'symbol'   => 'Currency Symbol is required.'
        ];

        $request->validate($rules, $messages);
    }
}
