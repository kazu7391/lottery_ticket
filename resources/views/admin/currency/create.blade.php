@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.currencies.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="txt_name">@lang('Currency')</label>
                                    <input id="txt_name" class="form-control" name="currency" required type="text" value="{{ old('currency') }}">
                                </div>

                                <div class="form-group">
                                    <label for="txt_symbol">@lang('Symbol')</label>
                                    <input id="txt_symbol" class="form-control" name="symbol" required type="text" value="{{ old('symbol') }}">
                                </div>

                                <button class="btn btn--primary h-45 w-100 mt-3" type="submit">@lang('Submit')</button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/bootstrap-clockpicker.min.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/vendor/bootstrap-clockpicker.min.css') }}" rel="stylesheet">
@endpush

@push('style')
    <style>
        button.icon-btn {
            border-top-left-radius: 3px !important;
            border-bottom-left-radius: 3px !important;
        }

        .popover{
            position: absolute;
        }
    </style>
@endpush
