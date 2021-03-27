$(() =>
{
    let cookingStepsContainer = $('.cooking-steps-container');
    let addNewStepBtn = $('.cooking-steps-new-btn');
    // Set the number of cooking steps. If none then length will be 0
    let cookingStepCounter = $('.cooking-step-container').length;
    
    addNewStepBtn.on('click', () => 
    {
        cookingStepCounter++;
        
        // The step container
        let stepContainer = $('<div data-cooking-step="'+cookingStepCounter+'">');
        stepContainer.addClass('cooking-step-container');
        
        // Add the textarea
        let txtArea = $('<textarea name="cooking_steps[]">'); 
        txtArea.addClass("form-control txt-area");
        txtArea.ckeditor();
        stepContainer.append(txtArea);
        
        // Button container
        let btnsContainer = $('<div>');
        btnsContainer.addClass('button-container');
        
        // Move up button
        let moveUpBtn = $('<a href="#">Move up</a>');
        moveUpBtn.addClass('btn-move-up btn chevron');
        btnsContainer.append(moveUpBtn);
        
        // Move down button
        let moveDownBtn = $('<a href="#">Move down</a>');
        moveDownBtn.addClass('btn-move-down btn chevron chev-down');
        btnsContainer.append(moveDownBtn);
                
        // Delete button
        let cookingStepDelBtn = $('<a data-cooking-step="'+cookingStepCounter+'" href="#">Delete step<i class="fa fa-trash" ></i></a>');
        cookingStepDelBtn.addClass('pull-right delete-cooking-step btn btn-red');
        btnsContainer.append(cookingStepDelBtn);
        
        // Add the button container to the cooking step container
        stepContainer.append(btnsContainer);
        
        // Add the cooking step to the parent container
        addNewStepBtn.before(stepContainer);
    });

    
    /**
     * Handler for the move up/down buttons
     */
    cookingStepsContainer.on('click', '.btn-move-up, .btn-move-down', (e) =>
    {
        let eventTarget = $(e.target);
        
        var parent = eventTarget.parent().parent('.cooking-step-container');
        
        if (eventTarget.hasClass('btn-move-up')) {
            parent.insertBefore(parent.prev('div'));
        }
        else if (eventTarget.hasClass('btn-move-down')) {
            parent.insertAfter(parent.next('div'));
        }  
        
        e.preventDefault();
    });
    
    
    /**
     * Click handler to delete the cooking step
     */
    cookingStepsContainer.on('click', '.delete-cooking-step', (e) =>
    {
        // Get the cooking step number from the delete button
        let cookingStepNum = $(e.target).attr('data-cooking-step');
        
        if (cookingStepNum !== undefined)
        {
            // Show a modal dialog to confirm they want to delete this step
            var allow = confirm("Are you sure you want to delete this step?");

            if (allow) 
            {
                let cookingStep = cookingStepsContainer.find('div[data-cooking-step="'+cookingStepNum+'"]');
                if (cookingStep !== undefined)
                {
                    $('.cooking-step-container .btn').off();
                    
                    // Remove the step
                    cookingStep.remove();
                }
            }
            else {
                e.preventDefault();
            }   
        }
        else {
            console.debug('Cooking step undefined');
        }
    });
    
});
$(() => {

    let deletedPhotoContainer = $('.deleted-photos');
    
    
    $('.photo-delete').on('click', function(e)
    {
        let delBtn = $(this);
        let photoEl = delBtn.siblings('img');
        let photoId = delBtn.attr('data-photo');

        if (photoId !== undefined && isNaN(photoId) === false)
        {
            if (photoEl !== undefined && photoEl.length > 0)
            {
                photoEl.toggleClass('del');

                if (photoEl.hasClass('deleted'))
                {
                    // Remove the deleted photo ID ref from container
                    let photoIdRef = deletedPhotoContainer.find('#photo-deleted-'+photoId);
                    
                    if (photoIdRef !== undefined && photoIdRef.length > 0) {
                        photoIdRef.remove();
                    }
                    
                    photoEl.removeClass('deleted');

                    // Add `Delete` button text
                    $(this).text('Delete');
                }
                else {
                    photoEl.addClass('deleted');
                    
                    // Add the deleted photo ID ref from the container
                    deletedPhotoContainer.append('<input id="photo-deleted-'+photoId+'" type="hidden" name="delete_photos[]" value="'+photoId+'" />');

                    // Add `Undo delete` button text
                    $(this).text('Undo delete');
                }
            }
        }
        
        e.preventDefault();
    });
    
});
$(function()
{
    let utensilInput = document.querySelector('#recipe-utensils');
    let utensilTagify = new Tagify(utensilInput, {
        whitelist: ['Knife', 'Non-stick pan', 'Spatula', 'Grater', 'Peeler'],
        dropdown: {
            position: "input",
            enabled : 0 // always opens dropdown when input gets focus
        },
        // This is to convert the tags into json when form is submitted
        originalInputValueFormat: valuesArr => JSON.stringify(valuesArr.map(item => item.value))
    });
    
    let ingredientInput = document.querySelector('#recipe-ingredients');
    let ingTagify = new Tagify(ingredientInput, {
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
                    if (resp.data !== undefined)
                    {
                        let itemList = resp.data;

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


