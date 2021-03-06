$(function()
{
    var cookingStepsContainer = $('.cooking-steps-container');
    var addNewStepBtn = $('.cooking-steps-new-btn');
    // Set the number of cooking steps. If none then length will be 0
    var cookingStepCounter = $('.cooking-step-container').length;

    addNewStepBtn.on('click', () =>
    {
        cookingStepCounter++;

        // The step container
        var stepContainer = $('<div data-cooking-step="'+cookingStepCounter+'">');
        stepContainer.addClass('cooking-step-container');

        // Add the textarea
        var txtArea = $('<textarea name="cooking_steps[]" id="cooking-step-'+cookingStepCounter+'">');
        txtArea.addClass("form-control txt-area ck-editor");
        txtArea.ckeditor();
        stepContainer.append(txtArea);

        // Button container
        var btnsContainer = $('<div>');
        btnsContainer.addClass('button-container');

        // Move up button
        var moveUpBtn = $('<a href="#">Move up</a>');
        moveUpBtn.addClass('btn-move-up btn');
        btnsContainer.append(moveUpBtn);

        // Move down button
        var moveDownBtn = $('<a href="#">Move down</a>');
        moveDownBtn.addClass('btn-move-down btn');
        btnsContainer.append(moveDownBtn);

        // Delete button
        var cookingStepDelBtn = $('<a data-cooking-step="'+cookingStepCounter+'" href="#">Delete</a>');
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
    cookingStepsContainer.on('click', '.btn-move-up, .btn-move-down', function(event)
    {
        var eventTarget = $(event.target);

        var parent = eventTarget.parent().parent('.cooking-step-container');
        var txtAreaId = parent.find('.txt-area').attr('id');

        if (eventTarget.hasClass('btn-move-up'))
        {
            // Ref https://ckeditor.com/old/forums/CKEditor/CKEditor-Becomes-Disabled-When-Moved-with-Javascript
            CKEDITOR.instances[txtAreaId].destroy();
            CKEDITOR.remove(txtAreaId);

            parent.insertBefore(parent.prev('div'));

            CKEDITOR.replace( txtAreaId );
        }
        else if (eventTarget.hasClass('btn-move-down'))
        {
            // Ref https://ckeditor.com/old/forums/CKEditor/CKEditor-Becomes-Disabled-When-Moved-with-Javascript
            CKEDITOR.instances[txtAreaId].destroy();
            CKEDITOR.remove(txtAreaId);

            parent.insertAfter(parent.next('div'));

            CKEDITOR.replace( txtAreaId );
        }

        event.preventDefault();
    });


    /**
     * Click handler to delete the cooking step
     */
    cookingStepsContainer.on('click', '.delete-cooking-step', function(event)
    {
        // Get the cooking step number from the delete button
        var cookingStepNum = $(event.target).attr('data-cooking-step');

        if (cookingStepNum !== undefined)
        {
            // Show a modal dialog to confirm they want to delete this step
            var allow = confirm("Are you sure you want to delete this step?");

            if (allow)
            {
                var cookingStep = cookingStepsContainer.find('div[data-cooking-step="'+cookingStepNum+'"]');
                if (cookingStep !== undefined)
                {
                    $('.cooking-step-container .btn').off();

                    // Remove the step
                    cookingStep.remove();
                }
            }
            else {
                event.preventDefault();
            }
        }
        else {
            console.debug('Cooking step undefined');
        }
    });

});
