$(function()
{
    let inputElm = document.querySelector('#ingredients');
    let ingTagify = new Tagify(inputElm, {whitelist: []});
    let controller = null;
    let apiCallTimer = null;
    
    var getIngredientList = function(term)
    {
        let endpoint = APP_URL + 'api/ingredient';
        
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
    
    ingTagify.on('input', function(e)
    {
        let value = e.detail.value;
        
        clearTimeout(apiCallTimer);
        
        apiCallTimer = setTimeout(function(){

            ingTagify.settings.whitelist.length = 0;

            // https://developer.mozilla.org/en-US/docs/Web/API/AbortController/abort
            controller && controller.abort();
            controller = new AbortController();

            ingTagify.loading(true).dropdown.hide.call(ingTagify);

            getIngredientList(value)
                .then(function(resp)
                {
                    if (resp.response !== undefined)
                    {
                        let ingredientList = resp.response;

                        ingTagify.settings.whitelist.splice(0, ingredientList.length, ...ingredientList);

                        // render the suggestions dropdown
                        ingTagify.loading(false).dropdown.show.call(ingTagify, value);
                    }
                })
                .catch(function(error)
                {
                    // Hide the dropdown list
                    ingTagify.loading(false).dropdown.hide.call(ingTagify);
                })
            ;
            
        }, 400);
    });
    
});


