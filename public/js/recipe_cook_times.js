$(() => 
{
    let cookTimeHours = $('.cook-time-hours');
    let cookTimeMinutes = $('.cook-time-minutes');
    
    let restrictTimeInput = function(inputEl, event, maxVal)
    {
        let keyNum = Number(event.which);

        // If they keystroke isn't a backspace
        if (keyNum !== 8)
        {
            if (inputEl !== undefined || isNaN(e.key) === false)
            {
                let elVal = inputEl.val();
                let keyVal = Number(event.key);
                let inputVal = Number(elVal + keyVal);
                
                // If the digits in the input are > 2.
                // Doing +1 to account for this current keystroke
                if (elVal.length + 1 > 2) {
                    event.preventDefault();
                }
                // Check if the value exceeds 15
                else if (isNaN(inputVal) || inputVal > maxVal) {
                    event.preventDefault();
                }
            }
            else {
                event.preventDefault();
            }
        }
    };
    
    cookTimeHours.on('keydown', function(e) {
        restrictTimeInput($(this), e, 15);
    });

    cookTimeMinutes.on('keydown', function(e) {
        restrictTimeInput($(this), e, 59);
    });
    
});