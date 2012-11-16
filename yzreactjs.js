
window.word_showing = false;
if (orientation == correct_orientation)
{
    var is_orientation_correct = 1;
}
else
{
    var is_orientation_correct = 0;
}

function showWord()
{
    if(orientation == "U")
    {
        $("#yzreact-row-text-top").text(word);
    }
    else if(orientation == "D")
    {
        $("#yzreact-row-text-bottom").text(word);
    }
};

function microtime (get_as_float) {
  var now = new Date().getTime() / 1000;
  var s = parseInt(now, 10);

  return (get_as_float) ? now : (Math.round((now - s) * 1000) / 1000) + ' ' + s;
}

$(document).ready(function(){
    $("#yzreact-row-text-middle").text(help_message);
});

$(document).ready(function(){
  $(document).keydown(function(event){
    if(!window.word_showing && event.which == 83) //These variables are bound to window to make them global
    {
        showWord();
        window.word_showing = true;
        window.starttime = microtime(true);
    }
    else
    {
        //Here we stop the clock and submit the results
        var time = microtime(true) - window.starttime;
        if((event.which == 65 && window.correct_orientation == "U") || (event.which == 68 && window.correct_orientation == "D"))
        {
            //alert("Correct" + time);
            var correct=true;
        }
        else if((event.which == 65 && correct_orientation == "D") || (event.which == 68 && correct_orientation == "U"))
        {
            //alert("Wrong");
            var correct = false;
        }
        $("#yzreact-row-text-middle").html("<a href='test_process.php?was_correct=" + correct + "&time="+ time +"&word="+ word +"&sem_field_id="+ sem_field_id +"&is_orientation_correct="+ is_orientation_correct + "'>Click here</a>");
    }
  });
});






