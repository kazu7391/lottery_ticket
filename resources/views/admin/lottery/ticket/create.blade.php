@extends('admin.layouts.app')
@section('panel')
    <form action="{{ route('admin.tickets.store', @$lottery->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="hidden" name="is_ticket" value="1" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-4 col-lg-12 col-md-6">
                                <div class="form-group">
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('lottery') . '/' . @$lottery->image, getFileSize('lottery')) }})">
                                                    <button class="remove-image" type="button"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input accept=".png, .jpg, .jpeg" class="profilePicUpload d-none" id="lotteryImage" name="image" type="file">
                                                <label class="bg--success mt-2" for="lotteryImage">@lang('Upload Image')</label>
                                                <small class="mt-2  ">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into ') {{ getFileSize('lottery') . 'px' }} </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-lg-12 col-md-6">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group ">
                                            <label>@lang('Name')</label>
                                            <input class="form-control" name="name" required type="text" value="{{ old('name', @$lottery->name) }}">
                                        </div>
                                    </div>
                                    @php
                                        $amount = old('price', @$lottery->price);
                                    @endphp
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group ">
                                            <label>@lang('Price')</label>
                                            <div class="input-group">
                                                <input class="form-control" name="price" required step="any" type="number" value="{{ $amount > 0 ? getAmount($amount) : '' }}">
                                                <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group ">
                                            <label>@lang('No. Of Balls')</label>
                                            <input class="form-control" min="1" id="no_of_ball"  name="no_of_ball" required type="number" value="{{ old('no_of_ball', @$lottery->no_of_ball) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group ">
                                            <label>@lang('Ball Start From')  <i class="las la-info-circle text--primary" title="@lang('The ball starts from must be 0 or 1')"></i> </label>
                                            <input class="form-control" min="0" name="ball_start_from" required type="text" value="{{ old('ball_start_from', @$lottery->ball_start_from) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="form-group ">
                                            <label>@lang('Ball End') </label>
                                            <input class="form-control" min="0" name="ball_end" required type="text" value="{{ old('ball_end', @$lottery->ball_end) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <label>@lang('Ball Disable Range')  <i class="las la-info-circle text--primary" title="@lang('The Ball Disable Range must be smaller than :ball_end', ['ball_end' => @$lottery->ball_end ?? 'Ball End To'])"></i></label>
                                        <div class="row align-items-center">
                                            <div class="col-3">
                                                <span class="sp-ball-start-from">{{ old('ball_start_from', @$lottery->ball_start_from) }}</span> ~
                                            </div>
                                            <div class="col-9">
                                                <input class="form-control" name="ball_disable_range" type="text" value="{{ old('ball_disable_range', @$lottery->ball_disable_range) }}">
                                                <input type="hidden" name="ball_start" value="{{ old('ball_start', @$lottery->ball_start) }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input @checked(old('has_special_balls', @$lottery->has_special_balls)) class="form-check-input" id="hasSpecialBalls" name="has_special_balls" type="checkbox" value="1">
                                    <label class="form-check-label" for="hasSpecialBalls">@lang('Has Special Balls')</label>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>@lang('Special Winner Balls')</label>
                                    <input class="form-control specialBallInputs" name="special_winning_ball" required type="text" value="{{ old('special_winning_ball', @$lottery->special_winning_ball) }}">
                                </div>
                            </div>
                            @php
                                $special_winning_prize = old('special_winning_prize', @$lottery->special_winning_prize);
                            @endphp
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>@lang('Special Winner Prize')</label>
                                    <div class="input-group">
                                        <input class="form-control specialBallInputs" name="special_winning_prize" required step="any" type="number" value="{{ $special_winning_prize > 0 ? getAmount($special_winning_prize) : '' }}">
                                        <span class="input-group-text">{{ __($general->cur_text) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input @checked(old('has_power_ball', @$lottery->has_power_ball)) class="form-check-input" id="hasPowerBall" name="has_power_ball" type="checkbox" value="1">
                                    <label class="form-check-label" for="hasPowerBall">@lang('Has Power Ball')</label>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>@lang('No. Of Power Ball')</label>
                                    <input class="form-control powerBallInputs" min="0" name="no_of_pw_ball" type="number" value="{{ old('no_of_pw_ball', @$lottery->no_of_pw_ball) }}">
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="form-group">
                                    <label>@lang('Power Ball Start From')</label>
                                    <input class="form-control powerBallInputs" min="0" name="pw_ball_start_from" placeholder="" type="number" value="{{ old('pw_ball_start_from', @$lottery->pw_ball_start_from) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check">
                                    <input @checked(old('auto_creation_phase', @$lottery->auto_creation_phase)) class="form-check-input" id="autoCreationPhase" name="auto_creation_phase" type="checkbox" value="1">
                                    <label class="form-check-label" for="autoCreationPhase">@lang('Phase Auto Creation')</label>
                                </div>

                                <div class="phaseDayTimeDiv @if (!old('auto_creation_phase', @$lottery->auto_creation_phase)) d-none @endif">
                                    @php
                                        $phaseType = null;
                                        if (old('phase_type')) {
                                            $phaseType = old('phase_type');
                                        } elseif (@$lottery) {
                                            $phaseType = $lottery->phaseCreationSchedules->first()->phase_type ?? 0;
                                        }
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <input @checked($phaseType == 1) class="form-check-input" id="weekly" name="phase_type" type="radio" value="1">
                                        <label class="form-check-label" for="weekly">
                                            @lang('Weekly')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input @checked($phaseType == 2) class="form-check-input" id="monthly" name="phase_type" type="radio" value="2">
                                        <label class="form-check-label" for="monthly">
                                            @lang('Monthly')
                                        </label>
                                    </div>
                                    @php
                                        $oldDays = old('days') ?? null;
                                        $drawTimes = old('draw_times') ?? null;
                                    @endphp
                                    @if ($oldDays && count($oldDays) > 0)
                                        @foreach ($oldDays as $index => $oldDay)
                                            <div class="row parentDiv">
                                                <div class="col-xl-6 col-lg-6">
                                                    @if ($phaseType == 1)
                                                        <div class="form-group">
                                                            <label class="required">@lang('Draw Day')</label>
                                                            <select class="form-control" name="days[]" required>
                                                                <option disabled selected value="">@lang('Select One')</option>
                                                                @foreach (days() as $key => $day)
                                                                    <option @selected($oldDay == $key) value="{{ $key }}">{{ __($day) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <label class="required">@lang('Draw Date')</label>
                                                            <input autocomplete="off" class="form-control" max="31" min="1" name="days[]" placeholder="@lang('Enter a day of the month (1-31)')" required value="{{ $oldDay }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label class="required">@lang('Draw Time')</label>
                                                        <div class="input-group clockpicker">
                                                            <input autocomplete="off" class="form-control" name="draw_times[]" placeholder="--:--" required type="text" value="{{ $drawTimes[$index] ? showDateTime($drawTimes[$index], 'H:i') : '' }}">

                                                            <button class="input-group-text ms-2 btn icon-btn @if ($loop->first) btn--success addBtn @else btn--danger removeBtn @endif" data-type="{{ $phaseType }}" type="button">
                                                                @if ($loop->first)
                                                                    <i class="las la-plus"></i>
                                                                @else
                                                                    <i class="las la-times"></i>
                                                                @endif
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @elseif (@$lottery && $lottery->phaseCreationSchedules->count())
                                        @foreach ($lottery->phaseCreationSchedules as $schedule)
                                            <div class="row parentDiv">
                                                <div class="col-xl-6 col-lg-6">
                                                    @if ($schedule->phase_type == 1)
                                                        <div class="form-group">
                                                            <label class="required">@lang('Draw Day')</label>
                                                            <select class="form-control" name="days[]" required>
                                                                <option disabled selected value="">@lang('Select One')</option>
                                                                @foreach (days() as $key => $day)
                                                                    <option @selected($schedule->day == $key) value="{{ $key }}">{{ __($day) }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <label class="required">@lang('Draw Date')</label>
                                                            <input autocomplete="off" class="form-control" max="31" min="1" name="days[]" placeholder="@lang('Enter a day of the month (1-31)')" required value="{{ $schedule->day }}">
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="form-group">
                                                        <label class="required">@lang('Draw Time')</label>
                                                        <div class="input-group clockpicker">
                                                            <input autocomplete="off" class="form-control" name="draw_times[]" placeholder="--:--" required type="text" value="{{ showDateTime($schedule->time, 'H:i') }}">

                                                            <button class="input-group-text ms-2 btn icon-btn @if ($loop->first) btn--success addBtn @else btn--danger removeBtn @endif" data-type="{{ $lottery->phase_type }}" type="button">
                                                                @if ($loop->first)
                                                                    <i class="las la-plus"></i>
                                                                @else
                                                                    <i class="las la-times"></i>
                                                                @endif
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--primary h-45 w-100 mt-3" type="submit">@lang('Submit')</button>
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

@if ($lottery)
    @push('breadcrumb-plugins')
        <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.lottery.winning.setting', $lottery->id) }}"><i class="las la-cog"></i>@lang('Winning Setting')</a>
    @endpush
@endif

@push('script')
    <script>
        (function($) {
            "use strict";

            let hasPowerBall = "{{ @$lottery->has_power_ball ?? 0 }}" * 1;

            @if (old('has_power_ball'))
                hasPowerBall = 1;
            @endif

            updatePowerBallsDOM(hasPowerBall);

            $('[name=has_power_ball]').on('click', function() {
                let condition = $(this).is(':checked') ? true : false;
                updatePowerBallsDOM(condition);
            });

            function updatePowerBallsDOM(condition) {
                let powerBallInputs = $('.powerBallInputs');
                if (condition == true) {
                    powerBallInputs.prop('disabled', false);
                    powerBallInputs.attr('required', true);
                    powerBallInputs.siblings('label').addClass('required');
                    $('[name=pw_ball_start_from]').attr('placeholder', "@lang('Enter 0 or 1')");
                } else {
                    powerBallInputs.val('');
                    powerBallInputs.prop('disabled', true);
                    powerBallInputs.removeAttr('required');
                    powerBallInputs.siblings('label').removeClass('required');
                    $('[name=pw_ball_start_from]').attr('placeholder', "");
                }
            }

            let hasSpecialBalls = "{{ @$lottery->has_special_balls ?? 0 }}" * 1;
            @if (old('has_special_balls'))
                hasSpecialBalls = 1;
            @endif
            updateSpecialBallsDOM(hasSpecialBalls);
            $('[name=has_special_balls]').on('click', function() {
                let condition = !!$(this).is(':checked');
                updateSpecialBallsDOM(condition);
            });
            function updateSpecialBallsDOM(condition) {
                let specialBallInputs = $('.specialBallInputs');
                if (condition == true) {
                    specialBallInputs.prop('disabled', false);
                    specialBallInputs.attr('required', true);
                    specialBallInputs.closest('.form-group').find('label').addClass('required');
                } else {
                    specialBallInputs.val('');
                    specialBallInputs.prop('disabled', true);
                    specialBallInputs.removeAttr('required');
                    specialBallInputs.closest('.form-group').find('label').removeClass('required');
                }
            }

            let phaseDayTimeDiv = $('.phaseDayTimeDiv');
            $('[name=auto_creation_phase]').on('click', function() {
                phaseDayTimeDiv.find('[name=phase_type]').prop('checked', false);
                if ($(this).is(':checked')) {
                    phaseDayTimeDiv.removeClass('d-none');
                } else {
                    phaseDayTimeDiv.find('.parentDiv').remove();
                    phaseDayTimeDiv.addClass('d-none');
                }
            });

            $('[name=phase_type]').on('click', function() {
                phaseDayTimeDiv.find('.parentDiv').remove();
                phaseDayTimeDiv.append(weekMonthField($(this).val(), 'add'));

                $('.clockpicker').clockpicker({
                    placement: 'top',
                    align: 'left',
                    donetext: 'Done',
                    autoclose: true,
                });
            });

            $(document).on('click', '.addBtn', function() {
                let type = $(this).data('type');
                phaseDayTimeDiv.append(weekMonthField(type));

                $('.clockpicker').clockpicker({
                    placement: 'top',
                    align: 'left',
                    donetext: 'Done',
                    autoclose: true,
                });
            });

            $(document).on('click', '.removeBtn', function() {
                $(this).parents('.parentDiv').remove();
            });

            function weekMonthField(type, button = 'remove') {
                let buttonHtml = '';
                let weekMonthInput = '';
                if (button == 'remove') {
                    buttonHtml = `
                    <button type="button" class="input-group-text ms-2 btn icon-btn btn--danger removeBtn">
                        <i class="las la-times"></i>
                    </button>
                    `;
                } else {
                    buttonHtml = `
                    <button type="button" data-type="${type}" class="input-group-text ms-2 btn icon-btn btn--success addBtn">
                        <i class="las la-plus"></i>
                    </button>
                    `;
                }

                if (type == 1) {
                    weekMonthInput = `<div class="col-xl-6 col-lg-6">
                        <div class="form-group">
                            <label class="required">@lang('Draw Day')</label>
                            <select class="form-control" name="days[]" required>
                                <option value="" disabled selected>@lang('Select One')</option>
                                @foreach (days() as $key => $day)
                                    <option value="{{ $key }}" >{{ __($day) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>`;
                } else {
                    weekMonthInput = `<div class="col-xl-6 col-lg-6">
                        <div class="form-group">
                            <label class="required">@lang('Draw Date')</label>
                            <input autocomplete="off" class="form-control" min="1" max="31" placeholder="@lang('Enter a day of the month (1-31)')" name="days[]" required>
                        </div>
                    </div>`;
                }


                let html = `
                <div class="row parentDiv">
                    ${weekMonthInput}
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-group">
                            <label class="required">@lang('Draw Time')</label>
                            <div class="input-group clockpicker">
                                <input autocomplete="off" class="form-control" name="draw_times[]" placeholder="--:--" type="text" required>
                                ${buttonHtml}
                            </div>
                        </div>
                    </div>
                </div>
                `;

                return html;
            }

            $('.clockpicker').clockpicker({
                placement: 'top',
                align: 'left',
                donetext: 'Done',
                autoclose: true,
            });

            $('[name=no_of_ball]').on('change', function () {
                let value = $(this).val();
                $('[name=total_picking_ball]').val(value);

                let ballNumber = parseInt(value);
                let ballStartText = '';
                let ballEndText = 10;
                if(ballNumber > 1) {
                    for (let i = 0; i < ballNumber - 1; i++) {
                        ballStartText += '0';
                        ballEndText *= 10;
                    }
                    ballStartText += '1';
                    ballEndText = ballEndText - 1;
                } else {
                    ballStartText = '1';
                    ballEndText = '9';
                }
                $('[name=ball_start_from]').val(ballStartText);
                $('.sp-ball-start-from').html(ballStartText);
                $('[name=ball_end]').val(ballEndText);
                let ballDisableVal = $('[name=ball_disable_range]').val();
                if(ballDisableVal === '') {
                    $('[name=ball_start]').val(ballStartText);
                }
            });

            $('[name=ball_disable_range]').on('keyup', function () {
                let ballDisableVal = $('[name=ball_disable_range]').val();
                let ballDisableNumb = parseInt(ballDisableVal);
                $('[name=ball_start]').val(ballDisableNumb + 1);
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        button.icon-btn {
            border-top-left-radius: 3px !important;
            border-bottom-left-radius: 3px !important;
        }
    </style>
@endpush
