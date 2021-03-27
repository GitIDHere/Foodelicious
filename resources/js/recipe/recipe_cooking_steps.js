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