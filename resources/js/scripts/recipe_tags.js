$(function()
{
    let utensilInput = document.querySelector('#recipe-utensils');
    let utensilTagify = new Tagify(utensilInput, {whitelist: []});
    
    let ingredientInput = document.querySelector('#recipe-ingredients');
    let ingTagify = new Tagify(ingredientInput, {whitelist: []});
    
    let controller = null;
    let apiCallTimer = null;
    
    /**
     * A generic function which helps to generate a Tagify list based on the callback
     * @param term
     * @param tagifyObj
     * @param apiCallback
     */
    let generateTagList = function(term, tagifyObj, apiCallback)
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
                    if (resp.response !== undefined)
                    {
                        let itemList = resp.response;

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
        let endpoint = APP_URL + 'api/tags/ingredient';

        return new Promise(function(resolve, reject){
            $.ajax({
                url : endpoint,
                datatype: "json",
                type: "POST",
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


