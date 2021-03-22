$(() => 
{
    let cookTimeEl = $('#cook_time');
    let maxHours = 23;

    let pad = (num) => {
        num = num.toString();
        while (num.length < 2) num = "0" + num;
        return num;
    };
    
    let genTimeOptions = (maxHours, selectEl) => 
    {
        for(let hours = 0; hours <= maxHours; hours++) 
        {
            for (let min = 5; min <= 55; min += 5) {
                selectEl.append('<option value="">'+pad(hours)+':'+pad(min)+'</option>');
            }    
        }    
    };
    
    genTimeOptions(maxHours, cookTimeEl);
    
});