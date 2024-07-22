<li class="ticket" data-ticket_number="{{ $lotteryNumber }}">
    <div class="lottery">
        <div class="lottery__body">
            <ul class="list--row flex-wrap lottery__list nbBallList">
                @php
                    $no_of_tickets = "";
                    for ($i = 0; $i < $lottery->no_of_ball; $i++) {
                        $no_of_tickets .= "9";
                    }
                    $disable_range = intval($lottery->ball_disable_range);

                    $numbers = [];
                    for ($i = 1; $i <= intval($no_of_tickets); $i++) {
                        if($i > $disable_range && !in_array($i, $pickedNumbers)) {
                            $numbers[] = $i;
                        }
                    }
                    shuffle($numbers);
                @endphp
                @foreach($numbers as $number)
                    <li class="normalBallNo-{{ $number }}">
                        <button class="lottery__btn normalBtn" data-no="{{ $number }}">
                            {{ str_pad($number, $lottery->no_of_ball, '0', STR_PAD_LEFT) }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</li>

