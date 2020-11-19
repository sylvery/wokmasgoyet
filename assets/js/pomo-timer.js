import { Toast } from "bootstrap";
import $ from "jquery";
$(function () {
    var $timer = $('#countdown-timer');
    var $timerMinutes = $('#pomoTimeMinutes');
    $timerMinutes[0].innerText = 25;
    var $timerSeconds = $('#pomoTimeSeconds');
    var $start = $('button#startPomo');
    // var $stop = $('button#stopPomo');
    // var $reset = $('button#resetPomo');
    
    $start.on('click',(e)=>{
        $start.addClass('d-none')
        $timer.addClass('rounded-circle rounded-egg');
        // $stop.removeClass('d-none')
        // $reset.removeClass('d-none')
        var $pomominutes = 24;
        const $multiple = 60;
        $timerMinutes[0].innerText = $pomominutes;
        var $secondsInterval;
        function secondsInterval(){
            var $seconds = $multiple-1;
            $secondsInterval = setInterval((e) => {
                // console.log($seconds);
                $timerSeconds[0].innerText = $seconds;
                $seconds -= 1;
            }, 1000);
        }
        secondsInterval();
        var $minutesInterval = setInterval(() => {
            $pomominutes = $pomominutes-1;
            // console.log($pomominutes);
            $timerMinutes[0].innerText = $pomominutes;
            $timerSeconds[0].innerText = 0;
            clearInterval($secondsInterval)
            secondsInterval();
            if ($pomominutes<0){
                clearInterval($secondsInterval)
                resetCount();
                clearMinutes();
            }
        }, 1000*$multiple);
        function clearMinutes() {
            clearInterval($minutesInterval);
        }
        function resetCount() {
            alert('Pomodoro has ended')
            $timerMinutes[0].innerText=25;
            $timerSeconds[0].innerText=0;
            $start.removeClass('d-none');
            // $stop.addClass('d-none');
            // $reset.addClass('d-none');
        }
    })
});