@extends('master')

@section('page_scripts')
    <script src="{{mix('js/recipe.js')}}"></script>
@endsection

@section('content')
    @auth
        
        @php
            $utensils = old('utensils');
            if (empty(old('utensils')) && isset($data)) {
                $utensils = $data['utensils'];
            }
        @endphp
        
        <div class="container">
            
            <div class="row white-bk pt-4 pb-4">
                
                @include('screens.user.partials._side_bar')
                
                <div class="col-12 col-lg-9 pl-3">
                    
                    @if (isset($recipe))
                        {{ Breadcrumbs::render('edit_recipe', $recipe)}}
                        <h1 class="mt-0">Edit Recipe</h1>
                    @else
                        {{ Breadcrumbs::render('new_recipe') }}
                        <h1 class="mt-0">New Recipe</h1>
                    @endif
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form 
                            id="recipe-form"
                            method="POST" 
                            action="{{ (isset($data) ? route('user.recipes.save.submit', ['recipe' => $recipe]) : route('user.recipes.create.submit') ) }}" 
                            enctype="multipart/form-data">
                        @csrf
                        
                        <div class="input-container">
                            <label for="recipe-title" class="required">Title</label>
                            <input 
                                type="text" 
                                name="title" 
                                class="form-control" 
                                id="recipe-title" 
                                value="{{ ($data['title'] ?? old('title'))  }}" 
                            />
                        </div>
                        
                        <div class="input-container">
                            <label for="recipe-desc" class="required">Description</label>
                            <textarea
                                    name="description"
                                    id="recipe-desc"
                                    class="form-control txt-area">{{ ($data['description'] ?? old('description'))  }}</textarea>
                        </div>

                        <div class="input-container">
                            <label for="cook_time">Cook time (HH:MM)</label>
                            <select id="cook_time" class="form-control" name="cook_time">
                                <option>Please select</option>
                                @for($hour = 0; $hour <= 23; $hour++)
                                    @for($min = 5; $min <= 55; $min += 5)
                                        @php
                                        $hourPadded = \Illuminate\Support\Str::padLeft($hour, 2, 0);
                                        $minPadded = \Illuminate\Support\Str::padLeft($min, 2, 0);
                                        $time = $hourPadded.':'.$minPadded;
                                        $selected = '';
                                        if (old('cook_time') && old('cook_time') == $time) {
                                            $selected = 'selected';    
                                        } else if (isset($data['cook_time']) && $data['cook_time'] == $time) {
                                            $selected = 'selected';
                                        }
                                        @endphp
                                        <option 
                                            value="{{$time}}"
                                            {{$selected}}>
                                            {{$time}}
                                        </option>
                                    @endfor
                                @endfor
                            </select>
                        </div>

                        <div class="input-container">
                            <label for="recipe-prep" class="required">Preparation</label>
                            <textarea  name="prep_directions"  id="recipe-prep"  class="form-control txt-area">{{ ($data['preparations'] ?? old('prep_directions'))  }}</textarea>
                        </div>

                        <div class="input-container">
                            <label for="recipe-utensils" class="required">
                                Utensils
                                <span class="hint">
                                    <i class="fa fa-info-circle">
                                        <span 
                                            class="hint-tooltip"
                                            data-balloon-length="large"
                                            aria-label="List the utensils needed for this recipe. Press the `enter` key to add it to the list!" 
                                            data-balloon-pos="right"></span>
                                    </i>
                                </span>
                            </label>
                            <input
                                type="text"
                                name="utensils"
                                id="recipe-utensils"
                                class="form-control tagify--outside tags-container"
                                value="{{ ($utensils ?? 'Spoon,Bowl') }}" 
                            />
                        </div>

                        <div class="input-container">
                            <label for="recipe-ingredients" class="required">
                                Ingredients
                                <span class="hint">
                                    <i class="fa fa-info-circle">
                                        <span
                                            class="hint-tooltip"
                                            data-balloon-length="large"
                                            aria-label="List the ingredients for this recipe. Press the `enter` key to add it to the list!"
                                            data-balloon-pos="right"></span>
                                    </i>
                                </span>
                            </label>
                            <input
                                    type="text"
                                    name="ingredients"
                                    id="recipe-ingredients"
                                    class="form-control tagify--outside tags-container"
                                    value="{{ ($data['ingredients'] ?? old('ingredients')) }}"
                            />
                        </div>
                        
                        
                        <div id="accordion" class="input-container ">
                            <label>
                                Cooking steps
                                <span class="hint">
                                    <i class="fa fa-info-circle">
                                            <span
                                                class="hint-tooltip"
                                                data-balloon-length="large"
                                                aria-label="Click on the grey banner top open the panel."
                                                data-balloon-pos="right"></span>
                                    </i>
                                </span>
                            </label>
                            <div class="panel single-accordion">
                                <h6>
                                    <a role="button" class="collapsed" aria-expanded="false" aria-controls="collapseTwo" data-parent="#accordion" data-toggle="collapse" href="#collapseTwo">
                                        Steps
                                        <span class="accor-open"><i class="fa fa-plus" aria-hidden="true"></i></span>
                                        <span class="accor-close"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    </a>
                                </h6>
                                <div id="collapseTwo" class="cooking-steps-container accordion-content collapse">
                                    <div class="cooking-steps-list">
                                        @if(isset($data) || !empty(old('cooking_steps')))
                                            @php
                                                $cookingSteps = !empty(old('cooking_steps')) ? old('cooking_steps') : $data['cooking_steps'];
                                            @endphp
                                            @foreach($cookingSteps as $index => $cookingStep)
                                                <div data-cooking-step="{{$index+1}}" class="cooking-step-container">
                                                    <textarea name="cooking_steps[]" class="form-control txt-area">{{ $cookingStep }}</textarea>
                                                    <div class="button-container">
                                                        <a href="#" class="btn-move-up btn chevron">Move up</a>
                                                        <a href="#" class="btn-move-down btn chevron chev-down">Move down</a>
                                                        <a data-cooking-step="{{$index+1}}" href="#" class="pull-right delete-cooking-step btn btn-red">Delete step<i class="fa fa-trash" ></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        
                                        <a href="#" class="btn cooking-steps-new-btn" role="button">Add step <i class="fa fa-plus" ></i></a>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-container">
                            <label for="recipe-photos" class="block">Recipe photos</label>
                            <input id="recipe-photos" type="file" name="photos[]" multiple="multiple" accept=".jpg,.png,.jpeg"/>    
                        </div>
                        
                        
                        <div class="input-container">
                            <label for="recipe-servings" class="required">Servings</label>
                            <input
                                    type="number"
                                    id="recipe-servings"
                                    name="servings"
                                    class="form-control num-counter"
                                    min="1" max="60"
                                    value="{{ ($data['servings'] ?? '1') }}"
                            />
                        </div>
                        
                        <div class="input-container">
                            <label class="label-switch switch-primary">
                                <span class="block mb-2">Set visibility</span>
                                <input 
                                    type="checkbox" 
                                    class="switch switch-bootstrap status" 
                                    name="visibility" id="visibility" 
                                    value="1" 
                                    @if(isset($data))
                                        {{$data['visibility'] == 'public' ? 'checked' : ''}}
                                    @endif
                                >
                                <span class="lable"></span>
                            </label>
                        </div>
                        
                        <div class="input-container">
                            <input type="submit" value="Save" class="btn btn-md pull-right" />
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    @endauth
@endsection