<section id="{{$id}}" 
         @if (isset($class))
         class="{{$class}}"
         @endif
         >
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>{{$id}}</h2>
                    <hr class="star-<?php if ($class=='success'){echo'light';}else{echo'primary';}?>">
                </div>
            </div>
            
            <div class="row">
                {!!$content!!}
            </div>
        </div>
</section>