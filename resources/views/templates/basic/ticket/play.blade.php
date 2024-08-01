@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="ticket-card--container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8">
                    <div class="ticket-card">
                        <div class="ticket-card__content">
                            <div class="result-card__name justify-content-center justify-content-md-start">
                                <div class="result-card__image">
                                    <img alt="image" class="result-card__img" src="{{ getImage(getFilePath('lottery') . '/' . $lottery->image) }}">
                                </div>
                                <div class="result-card__name-info">
                                    <h4 class="m-0">
                                        {{ __($lottery->name) }}
                                    </h4>
                                    <span class="result-card__sub-title">
                                        {{  number_format($lottery->maxPrize()) }}  {{ $lottery->currency ?? gs()->cur_text }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ticket-card__content">
                            <div class="countdown show" data-Date="{{ $lottery->activePhase->draw_date, 'd-m-Y H:i:s' }}">
                                <div class="running">
                                    <timer class="lottery-card__countdown-content">
                                        <span class="days lottery-card__counter"></span>
                                        <span class="lottery-card__counter-separator">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <span class="hours lottery-card__counter"></span>
                                        <span class="lottery-card__counter-separator">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <span class="minutes lottery-card__counter"></span>
                                        <span class="lottery-card__counter-separator">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </span>
                                        <span class="seconds lottery-card__counter"></span>
                                    </timer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section--sm">
        <div class="container">
            <div class="row g-4">
                <div class="col-xl-3 order-xl-2">
                    <div class="summery-card">
                        <form action="{{ route('user.lottery.pickTicket', $lottery->id) }}" method="POST">
                            @csrf
                            <input name="phase_id" type="hidden" value="{{ $lottery->activePhase->id }}">
                            <div class="summery-card__head">
                                <h5 class="summery-card__title">
                                    @lang('Summary')
                                </h5>
                            </div>
                            <div class="summery-card__body">
                                <div class="summery-card__body-container">
                                    <ul class="list gap-5" style="--gap: .5rem;">
                                        <li>
                                            <div class="summery-card__data">
                                                <span class="summery-card__data-name">
                                                    @lang('Total Tickets')
                                                </span>
                                                <span class="summery-card__data-amount totalTicket"></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="summery-card__data">
                                                <span class="summery-card__data-name">
                                                    @lang('Ticket Price') (<span class="totalTicket"></span>x{{ showAmount($lottery->price, exceptZeros: true) }})
                                                </span>
                                                <span class="summery-card__data-amount totalPrice"></span>
                                            </div>
                                        </li>
                                        <li class="multiDrawLi">
                                            <div class="summery-card__data">
                                                <span class="summery-card__data-name">
                                                    @lang('Total Draws')
                                                </span>
                                                <span class="summery-card__data-amount totalDraw"></span>
                                            </div>
                                        </li>
                                        <li class="multiDrawLi">
                                            <div class="summery-card__data">
                                                <span class="summery-card__data-name">
                                                    @lang('Sub Total')
                                                </span>
                                                <span class="summery-card__data-amount subTotal"></span>
                                            </div>
                                        </li>
                                        <li class="multiDrawLi">
                                            <div class="summery-card__data">
                                                <span class="summery-card__data-name">
                                                    @lang('Multi-draw discount') <small>(<span class="discountPercent"></span>)</small>
                                                </span>
                                                <span class="summery-card__data-amount multiDrawDiscount"></span>
                                            </div>
                                        </li>
                                    </ul>
                                    <hr class="summery-card__hr">
                                    <div class="summery-card__total">
                                        <span class="summery-card__total-name">
                                            @lang('Total Amount')
                                        </span>
                                        <span class="summery-card__total-amount totalAmount"></span>
                                    </div>
                                </div>
                            </div>
                            <nav aria-label="Page navigation example">
                                <div class="d-none hiddenFields"></div>
                                <div class="m-3 d-none">
                                    <p class="fw-bold mb-0">@lang('Payment Via')</p>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked id="balance" name="payment_via" type="radio" value="balance">
                                        <label class="form-check-label sm-text" for="balance">
                                            @lang('From Balance')
                                        </label>
                                    </div>
                                </div>
                                <div class="summery-card__footer text-center">
                                    <button class="btn btn--md btn--base buyTicketBtn" type="submit">@lang('Buy Tickets')</button>
                                </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-9 order-xl-1">
                    <div class="lottery-head">
                        <ul class="list list--row flex-wrap justify-content-center lottery-head__menu">
                            @foreach ([10,25,50,100,1000] as $line)
                                <li>
                                    <a class="incDecTicket t-link lottery-head__link" data-total_line="{{ $line }}" href="javascript:void(0)">
                                        {{ $line }} @if ($line > 1)
                                            @lang('Numbers')
                                        @else
                                            @lang('Number')
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                            <input type="hidden" id="hd_total_numbers" value="10" />
                        </ul>
                        <div class="lottery-head__action">
                            <ul class="list list--row d-flex justify-content-center align-items-center" style="--gap: .5rem;">
                                <li>
                                    <button class="btn btn--base btn--common allQuickPickBtn">
                                        <span class="btn--common__icon">
                                            <i class="fas fa-magic"></i>
                                        </span>
                                        <span class="btn--common__text">
                                            @lang('Quick Pick')
                                        </span>
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn--base btn--remove allRemoveBtn">
                                        <i class="las la-trash-alt"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="col-12 mb-3 pickedNumbersContainer">
                                <p>@lang('Picked Numbers')</p>
                                <ul class="list--row flex-wrap picked_numbers_list">
                                </ul>
                            </div>

                            <ul class="list list--row flex-wrap justify-content-center justify-content-sm-start lotteryContainer">
                                @php
                                    $no_of_tickets = "";
                                    for ($i = 0; $i < $lottery->no_of_ball; $i++) {
                                        $no_of_tickets .= "9";
                                    }

                                    $normalBallLimit = $lottery->no_of_ball;

                                    if ($lottery->pw_ball_start_from) {
                                        $pwBallLimit = $lottery->no_of_pw_ball + 1;
                                    } else {
                                        $pwBallLimit = $lottery->no_of_pw_ball;
                                    }
                                @endphp

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="quickPickModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('How many numbers do you want to pick?')</h5>
                </div>
                <div class="modal-body">
                    <input type="number" id="qb-numbers" value="" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-qb-modal-save btn-primary">@lang('Apply')</button>
                    <button type="button" class="btn btn-qb-modal-close btn-secondary" data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset($activeTemplateTrue . 'js/multi-countdown.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).ready(function() {
                $('.incDecTicket').first().click();
            });

            let nbMinLimit = parseInt('{{ $lottery->ball_disable_range ?? 0 }}');
            let nbMaxLimit = {{ intval($no_of_tickets) }};
            let nbPick = {{ $lottery->total_picking_ball }};
            let ticketPrice = {{ $lottery->price }};

            $('.buyTicketBtn').attr('disabled', true);
            updateDOM();

            $(document).on('click', '.normalBtn', function() {
                let ticket = $(this).parents('.ticket');
                let ticketNumber = ticket.data('ticket_number');
                let normalBallLength = ticket.find('.normalBtn.active').length;
                let ballNo = $(this).data('no');

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    removeInputField(ballNo);
                    $('.picked_numbers_list').find(`[data-number="${ballNo}"]`).remove();

                    if (normalBallLength - 1 < nbMaxLimit) {
                        ticket.find('.normalBtn').not('.active').removeAttr('disabled');
                    }
                } else {
                    if (normalBallLength >= nbMaxLimit) {
                        return false;
                    }

                    $(this).addClass('active');
                    appendInputField(ticketNumber, ballNo);
                    $('.picked_numbers_list').append('<li data-number="' + ballNo + '">' + $(ticket).find(`.normalBtn[data-no=${ballNo}]`).text() + '</li>');

                    if (normalBallLength + 1 == nbMaxLimit) {
                        ticket.find('.normalBtn').not('.active').attr('disabled', true);
                    }
                }
                updateDOM();
                enableDisableSubmit();
            });

            $('.allQuickPickBtn').on('click', function() {
                $('#quickPickModal').modal('show');
            });

            $('.btn-qb-modal-save').on('click', function() {
                let qbNumbers = $('#qb-numbers').val();
                if(qbNumbers !== '') {
                    $('.picked_numbers_list').html('');
                    qbNumbers = parseInt(qbNumbers);

                    $('.hd-picked-number').remove();
                    $('.ticket').remove();
                    getNewLotteryAndPick(qbNumbers);

                    $('.incDecTicket').removeClass('active');
                    $('.buyTicketBtn').removeAttr('disabled');

                    let totalTicket = qbNumbers;
                    let totalPrice = totalTicket * ticketPrice;
                    let totalAmount = totalPrice;
                    $('.totalTicket').text(totalTicket);
                    $('.totalPrice').text(parseFloat(totalPrice).toFixed(2) + " {{ gs()->cur_text }}");
                    $('.totalAmount').text(parseFloat(totalAmount).toFixed(2) + " {{ gs()->cur_text }}");
                    $('#quickPickModal').modal('hide');
                } else {
                    alert("@lang('Input your number!')");
                }
            });

            $('.btn-qb-modal-close').on('click', function() {
                $('#quickPickModal').modal('hide');
            });

            $('.allRemoveBtn').on('click', function() {
                $('.picked_numbers_list').html('');
                $('.hiddenFields').html('');
                $('button.active').removeClass('active');
                $('button:disabled').removeAttr('disabled');
                $('.buyTicketBtn').attr('disabled', true);
            })

            function selectBall(ball, ticket) {
                let normalBalls = ball.normal_balls;
                let ticketNumber = ticket.data('ticket_number');

                $('.hd-picked-number').remove();
                normalBalls.forEach(normal => {
                    $(ticket).find(`.normalBtn[data-no=${normal}]`).addClass('active');
                    appendInputField(ticketNumber, normal);
                    $('.picked_numbers_list').append('<li data-number="' + normal + '">' + $(ticket).find(`.normalBtn[data-no=${normal}]`).text() + '</li>');
                });
            }

            //ballType = 'normal_ball' / 'power_ball'
            function appendInputField(ticketNumber, ballNo, ballType = 'normal_ball') {
                let hiddenFieldDiv = $('.hiddenFields');
                let inputs = '';
                inputs += `<input type="hidden" class="hd-picked-number" name="ticket[${ticketNumber}][${ballType}][]" data-ticket_number="${ticketNumber}" data-${ballType}="${ballNo}" value="${ballNo}">`;
                hiddenFieldDiv.append(inputs);
            }

            function removeInputField(ballNo, ballType = 'normal_ball') {
                $('.hiddenFields').find(`input[data-${ballType}="${ballNo}"]`).remove();
            }

            $('.incDecTicket').on('click', function() {
                $('.picked_numbers_list').html('');
                if ($(this).hasClass('active')) {
                    return false;
                }

                let totalLine = $(this).data('total_line') * 1;
                $('.hd-picked-number').remove();
                $('.ticket').remove();
                getNewLotteryAndPick(totalLine);

                $('.incDecTicket').removeClass('active');
                $(this).addClass('active');

                let totalTicket = totalLine;
                let totalPrice = totalTicket * ticketPrice;
                let totalAmount = totalPrice;
                $('.totalTicket').text(totalTicket);
                $('.totalPrice').text(parseFloat(totalPrice).toFixed(2) + " {{ gs()->cur_text }}");
                $('.totalAmount').text(parseFloat(totalAmount).toFixed(2) + " {{ gs()->cur_text }}");
            });

            function getNewLotteryAndPick(totalLine) {
                let lotteryId = '{{ $lottery->id }}';
                let data = {
                    lottery_id: lotteryId,
                };
                $.get("{{ route('ticket.single') }}", data,
                    function(response, status, jqXHR) {
                        if (response.status) {
                            $('.lotteryContainer').append(response.html);
                            pickRandomNumbers(totalLine);
                        }
                    }
                );

                updateDOM();
            }

            function pickRandomNumbers(totalLine) {
                let tickets = $('.ticket');
                $.each(tickets, function(index, element) {
                    let normalBalls = generateRandomNumbers(totalLine, nbMinLimit, nbMaxLimit);
                    let ball = {
                        normal_balls: normalBalls
                    }
                    selectBall(ball, $(element));
                });
                $('.buyTicketBtn').removeAttr('disabled');
            }

            function updateDOM() {
                let totalTicket = $('.hd-picked-number').length;
                let totalPrice = totalTicket * ticketPrice;
                let totalAmount = totalPrice;

                $('.totalTicket').text(totalTicket);
                $('.totalPrice').text(parseFloat(totalPrice).toFixed(2)+" {{ gs()->cur_text }}");
                $('.totalAmount').text(parseFloat(totalAmount).toFixed(2)+" {{ gs()->cur_text }}");
            }

            function enableDisableSubmit() {
                let buyBtn = $('.buyTicketBtn');
                let totalTicket = $('.hd-picked-number').length;
                if (totalTicket > nbMaxLimit) {
                    buyBtn.attr('disabled', true);
                } else {
                    buyBtn.removeAttr('disabled');
                }
            }

            function generateRandomNumbers(pickNumbers, min, max) {
                let number = [];

                if(typeof(pickNumbers) == 'number' && max > 0) {
                    if(pickNumbers <= max) {
                        for (var i = 0; i < pickNumbers; i++) {
                            let generatedNumber = parseInt((Math.random() * (max - min)) + min);
                            let isExist;
                            do {
                                let isExist = number.indexOf(generatedNumber);
                                if (isExist >= 0) {
                                    generatedNumber = parseInt((Math.random() * (max - min)) + min);
                                    i--;
                                } else {
                                    number.push(generatedNumber);
                                    isExist = -2;
                                }
                            }
                            while (isExist > -1);
                        }
                    } else {
                        alert("@lang('Can not choose numbers more than ')" + max)
                    }
                }

                return number;
            }
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .summery-card__hr {
            margin: 0.5rem 0;
        }

        .breadcrumb {
            text-align: center;
            margin-bottom: 40px;
        }
        .picked_numbers_list {
            gap: 10px;
        }
        .picked_numbers_list li {
            padding: 5px;
            border: 1px solid hsl(var(--border) / 0.5);
        }

        .lottery__list li {
            width: auto;
        }
    </style>
@endpush
