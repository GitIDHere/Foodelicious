$(function()
{
    var ingredientInput = document.querySelector('#recipe-ingredients');

    var ingTagify = new Tagify(ingredientInput, {
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

    var getIngredientList = function(term)
    {
        var endpoint = APP_URL + 'api/tags/ingredient';

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

    ingTagify.on('input', function(e){
        $.fn.generateTagList(e.detail.value, ingTagify, getIngredientList)
    });
});
