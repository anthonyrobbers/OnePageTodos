@if (($statusArgs['msg'] and $statusPartial) and ($options['verbosity']!=0))
    <?php $options['verbosity']=2;?>
        <section id="status" class="success">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Status</h2>
                        <hr class="star-light">
                    </div>
                </div>

                @include('partials/status/'.$statusPartial, $statusArgs)
                
            </div>
        </section>
    @endif