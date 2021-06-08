$(function()
{
    var utensilInput = document.querySelector('#recipe-utensils');
    var utensilTagify = new Tagify(utensilInput, {
        whitelist: ['Knife', 'Non-stick pan', 'Spatula', 'Grater', 'Peeler'],
        dropdown: {
            position: "input",
            enabled : 0 // always opens dropdown when input gets focus
        },
        // This is to convert the tags into json when form is submitted
        originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value))
    });

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

    var controller = null;
    var apiCallTimer = null;

    /**
     * A generic function which helps to generate a Tagify list based on the callback
     * @param term
     * @param tagifyObj
     * @param apiCallback
     */
    var generateTagList = function(term, tagifyObj, apiCallback)
    {
        clearTimeout(apiCallTimer);

        apiCallTimer = setTimeout(function(){

            tagifyObj.settings.whitelist.length = 0;

            // End any existing API calls
            controller && controller.abort();
            controller = new AbortController();

            tagifyObj.loading(true).dropdown.hide.call(tagifyObj);

            apiCallback(term)
                .then(function(resp)
                {
                    if (resp.data !== undefined)
                    {
                        var itemList = resp.data;

                        tagifyObj.settings.whitelist.splice(0, itemList.length, ...itemList);

                        // render the suggestions dropdown
                        tagifyObj.loading(false).dropdown.show.call(tagifyObj, term);
                    }
                })
                .catch(function(error)
                {
                    // Hide the dropdown list
                    tagifyObj.loading(false).dropdown.hide.call(tagifyObj);
                })
            ;

        }, 400);
    };

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
        generateTagList(e.detail.value, ingTagify, getIngredientList)
    });
});


