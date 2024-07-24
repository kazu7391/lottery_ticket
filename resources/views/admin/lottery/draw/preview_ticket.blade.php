@extends('admin.layouts.app')

@section('panel')
    <div class="d-flex justify-content-end flex-wrap gap-2 mb-1">
        <div class="d-flex justify-content-start align-items-center gap-1">
            <div class="ball message">
                <span class="normal winning_ball"></span>
            </div>
            <h6>@lang('Winning Normal Ball')</h6>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-lg-12">
            <div class="card  ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('User')</th>
                                    <th>@lang('Normal Balls')</th>
                                    <th>@lang('Prize Money')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($winners as $winner)
                                    <tr>
                                        <td><span class="fw-bold">{{ __($winner['name']) }}</span></td>

                                        <td>
                                            <div class="ball">
                                                <span class="normal winning_ball">{{ $winner['winning_ball'] }}</span>
                                            </div>
                                        </td>
                                        <td>{{ showAmount($winner['prize_money']) }}</td>
                                    </tr>
                                @endforeach
                                @php
                                    $colspan = 2;
                                @endphp
                                <tr>
                                    <td class="text-end fw-bold" colspan="{{ $colspan }}">@lang('Total Prize')</td>
                                    <td class="fw-bold">{{ showAmount($winningAmount) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end fw-bold" colspan="{{ $colspan }}">@lang('Sold Amount')</td>
                                    <td class="fw-bold">{{ showAmount($phase->sold_amount) }}</td>
                                </tr>
                                <tr>
                                    @if ($phase->sold_amount > $winningAmount)
                                        <td class="text-end fw-bold" colspan="{{ $colspan }}">@lang('Loss')</td>
                                        <td class="fw-bold">{{ showAmount($phase->sold_amount - $winningAmount) }}</td>
                                    @else
                                        <td class="text-end fw-bold" colspan="{{ $colspan }}">@lang('Profit')</td>
                                        <td class="fw-bold">{{ showAmount($winningAmount - $phase->sold_amount) }}</td>
                                    @endif
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- card end -->
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.draw.submit', $phase->id) }}" method="post">
                        @csrf

                        @foreach ($winningNormalBalls as $normal)
                            <input name="winning_normal_ball[]" type="hidden" value="{{ $normal }}">
                        @endforeach
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Confirm')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.draw.ball.select', $phase->id) }}" />
@endpush

@push('style')
    <style>
        .ball span {
            display: inline-block;
            width: 30px;
            height: 30px;
            text-align: center;
            background: #d7d7d7;
            color: #757575;
            border-radius: 50%;
            line-height: 30px;
            font-size: 12px !important;
        }

        .ball.message span {
            width: 25px;
            height: 25px;
        }

        .ball .power.winning_ball {
            background: #e38308;
            color: #fff;
        }

        .ball .normal.winning_ball {
            background: #609f4c;
            color: #fff;
        }
    </style>
@endpush
