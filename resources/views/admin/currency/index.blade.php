@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card  bg--transparent shadow-none">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two bg-white">
                            <thead>
                            <tr>
                                <th>@lang('Currency')</th>
                                <th>@lang('Symbol')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($currencies as $currency)
                                <tr>
                                    <td>
                                        <div class="user">
                                            <a href="{{ route('admin.currencies.edit', $currency->id) }}">
                                                <span class="fw-bold ms-2">{{ __($currency->currency) }}</span>
                                            </a>
                                        </div>

                                    </td>
                                    <td>{{ $currency->symbol }}</td>
                                    <td>
                                        <button aria-expanded="false" class="btn btn-sm dropdown-toggle btn-outline--primary" data-bs-toggle="dropdown" type="button"> <i class="las la-down-arrow"></i> @lang('Action')</button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.currencies.edit', $currency->id) }}"><i class="la la-pencil-alt"></i> @lang('Edit')</a>
                                            <a class="dropdown-item" href="{{ route('admin.currencies.delete', $currency->id) }}"><i class="la la-trash"></i> @lang('Delete')</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($currencies->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($currencies) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Search..." />
    <a class="btn btn-outline--primary h-45" href="{{ route('admin.currencies.create') }}"><i class="las la-plus"></i>@lang('Add New')</a>
@endpush

@push('style')
    <style>
        .table-responsive {
            background: transparent;
            min-height: 350px;
        }

        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }
    </style>
@endpush


@push('script')
    <script>
    </script>
@endpush
