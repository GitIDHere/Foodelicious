$(() =>
{
    let cookingStepsContainer = $('.cooking-steps-container');
    let addNewStepBtn = $('.cooking-steps-new-btn');
    let cookingStepCounter = 0;
    
    addNewStepBtn.on('click', () => 
    {
        cookingStepCounter++;
        
        // Add the textarea
        let txtArea = $('<textarea data-cooking-step="'+cookingStepCounter+'" name="cooking_steps[]">'); 
        txtArea.addClass('cooking-steps');
        cookingStepsContainer.append(txtArea);
        
        // Add the delete button
        let cookingStepDelBtn = $('<a data-cooking-step="'+cookingStepCounter+'" href="#">Delete step</a>');
        cookingStepDelBtn.addClass('delete-cooking-step btn-delete');
        cookingStepsContainer.append(cookingStepDelBtn);
    });

    /**
     * Click handler to delete the cooking step
     */
    cookingStepsContainer.on('click', '.delete-cooking-step', (e) =>
    {
        let cookingStepNum = $(e.target).attr('data-cooking-step');
        
        if (cookingStepNum !== undefined)
        {
            // Show a modal dialog to confirm they want to delete this step
            var allow = confirm("Are you sure you want to delete this step?");

            if (allow) 
            {
                let textarea = cookingStepsContainer.find('textarea[data-cooking-step="'+cookingStepNum+'"]');
                if (textarea !== undefined)
                {
                    textarea.remove();
                    $(e.target).off();
                    $(e.target).remove();
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