@extends('admin.layouts.app')

@section('panel')
    @php
        $lottery = $phase->lottery;
    @endphp
    <div class="row gy-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Select Balls') ({{ $lottery->total_picking_ball }})</h5>
                </div>
                <div class="card-body">
                    <div class="lottery-balls">
                        @for ($row = 0; $row < $lottery->no_of_ball; $row++)
                            @for($i = 0; $i < 10; $i++)
                            <span data-row="{{ $row }}" class="normalBtn" data-normal_ball="{{ $i }}">{{ $i }}</span>
                            @endfor
                            <hr>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Winning Balls')</h5>
                </div>
                <div class="card-body">
                    <div class="winning-balls-area text-center">
                        <div class="winning-balls">
                            @for ($i = 0; $i < $lottery->total_picking_ball; $i++)
                                <span class="normalBall" data-row="{{ $i }}" data-normal_ball="{{ $i }}">#</span>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.draw.previewTicket', $phase->id) }}" method="post">
                        @csrf
                        <div class="hiddenFields d-none"></div>
                        <button class="btn btn--primary h-45 w-100 submitBtn" type="submit" disabled>@lang('Next')<i class="las la-angle-double-right"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            let nbPick = "{{ $lottery->total_picking_ball }}" * 1;
            let winningBalls = $('.winning-balls');
            let hiddenFields = $('.hiddenFields');

            $(document).on('click', '.normalBtn', function() {
                if($(this).hasClass('disabled')) return false;

                let ballNo = $(this).data('normal_ball');
                let type = 'normal_ball';
                let className = 'normalBtn';
                let winningClassName = 'normalBall';
                let balls = winningBalls.find('.normalBall');
                let pickCount = nbPick;
                let row = $(this).data('row');

                console.log(ballNo, row);

                if ($(this).hasClass('selected')) {
                    winningBalls.find(`[data-row="${row}"]`).removeClass('added').text('#').attr(`data-${type}`, 0);
                    // winningBalls.find(`[data-${type}="${ballNo}"]`).text('#');
                    // winningBalls.find(`[data-${type}="${ballNo}"]`).attr(`data-${type}`, 0);
                    $(`.${className}`).not('.selected').removeClass('disabled');
                    removeInput(ballNo, type, row);
                    $(this).removeClass('selected');
                } else {
                    if (pickCount <= winningBalls.find(`.${winningClassName}.added`).length) {
                        return false;
                    }

                    $(this).addClass('selected');
                    let ballElement = winningBalls.find(`[data-row="${row}"]`);
                    ballElement.text(ballNo);
                    ballElement.attr(`data-${type}`, ballNo);
                    ballElement.addClass('added');

                    $(`.${className}[data-row="${row}"]`).not('.selected').addClass('disabled');

                    appendInput(ballNo, type, row);
                }

                enableDisableBtn();
            });

            function appendInput(ballNo, type, row) {
                hiddenFields.append(`<input type="hidden" name="winning_${type}[]" data-row="${row}" data-${type}="${ballNo}" value="${ballNo}">`);
            }

            function removeInput(ballNo, type, row) {
                hiddenFields.find(`input[data-row="${row}"]`).remove();
            }

            function enableDisableBtn() {
                let submitBtn = $('.submitBtn');
                let normalBall = winningBalls.find('.normalBall.added').length;
                if (nbPick == normalBall) {
                    submitBtn.removeAttr('disabled');
                } else {
                    submitBtn.attr('disabled', true);
                }
            }
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .phase-card {
            min-height: 236px;
        }

        .winning-balls-area .winning-balls span {
            height: 7#px;
            width: 70px;
            display: inline-block;
            text-align: center;
            line-height: 70px;
            border-radius: 50px;
            font-size: 30px;
            border: 1px solid #d3d3d3;
            background: #e5e5e5;
            color: #8d8d8d;
            margin: 5px;
        }

        .winning-balls-area .winning-balls span.added {
            color: #fff;
            border: 1px solid #4634ff;
            background: #4634ff;
        }

        .winning-balls-area .winning-balls span.pwb {
            border: 1px solid #959595;
            background: #a1a0a0;
            color: #d9d9d9;
        }

        .winning-balls-area .winning-balls span.pwb.added {
            color: #fff;
            border: 1px solid #e35353;
            background: #e35353;
        }

        .winning-balls-area .winning-balls span.selected {
            opacity: 0.5;
        }

        .lottery-balls span {
            display: inline-block;
            height: 90px;
            width: 90px;
            border-radius: 50px;
            text-align: center;
            line-height: 90px;
            font-size: 45px;
            color: #fff;
            border: 1px solid #4634ff;
            background: #4634ff;
            cursor: pointer;
            margin: 5px;
            transition: all .3s
        }

        .lottery-balls span:hover {
            background: #1808aa;
            border-color: #1808aa;
        }

        .lottery-balls span.pwb {
            border: 1px solid #e35353;
            background: #e35353;
        }

        .lottery-balls span.pwb:hover {
            background: #c91d1d;
            border-color: #c91d1d;
        }

        .lottery-balls span.selected {
            opacity: 0.5;
        }

        .lottery-balls span.disabled,
        .lottery-balls span.pwb.disabled {
            cursor: no-drop;
        }
    </style>
@endpush
