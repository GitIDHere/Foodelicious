$(function()
{
    var wordCounters = $('.word_counter');

    var updateWordCount = function(wordCounterElement)
    {
        var counter = $(wordCounterElement);
        var wordLimit = counter.attr('data-char-limit');

        var linkedInputId = counter.attr('data-link');
        var linkedInput = $('#'+linkedInputId);

        // Skip if the linked input isn't found
        if (linkedInput === undefined || linkedInput.length === 0) {
            return true;
        }

        wordLimit = Number(wordLimit);

        if (isNaN(wordLimit) || wordLimit < 0) {
            return true;
        }

        var totalCharCount = linkedInput.val().replace(/[\r\n ]/g,'').length;

        var remainingCharCount = wordLimit - totalCharCount;

        if (remainingCharCount < 0) {
            remainingCharCount = 0;
        }

        counter.text("");

        var textP = $('<p>Characters remaining:</p>');
        var strongTxt = $('<strong>');
        strongTxt.text(" "+remainingCharCount);
        if (totalCharCount > wordLimit) {
            strongTxt.addClass('red');
        }
        textP.append(strongTxt);
        counter.append(textP);
    }


    $.each(wordCounters, function(index, ele)
    {
        var counter = $(ele);
        var linkedInputId = counter.attr('data-link');
        var linkedInput = $('#'+linkedInputId);

        $(linkedInput).on('keyup', function(){
            updateWordCount(ele);
        });

        updateWordCount(ele);
    });

});
