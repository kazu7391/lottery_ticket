<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

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

    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {

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
