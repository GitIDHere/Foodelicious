$(function()
{
    var inputEl = document.querySelector('#recipe-utensils');

    var tagifyObj = new Tagify(inputEl, {
        whitelist: [],
        // This is to convert the tags into json when form is submitted
        //originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value)),
        originalInputValueFormat: function(valuesArr){
            return JSON.stringify(valuesArr.map(item => item.value))
        },
        dropdown: {
            position: "input",
            enabled : 0 // always opens dropdown when input gets focus
        },
    });

    var getUtensilList = function(term)
    {
        var endpoint = APP_URL + 'api/tags/utensil';

        return new Promise(function(resolve, reject){
            $.ajax({
                url : endpoint,
                type: "GET",
                accept: 'application/json',
                data: {'term': term},
            })
                .done(resolve)
                .fail(reject)
            ;
        });
    };

    tagifyObj.on('input', function(e){
        $.fn.generateTagList(e.detail.value, tagifyObj, getUtensilList)
    });
});
