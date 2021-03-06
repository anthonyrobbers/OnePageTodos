<script id="status-template" type="text/x-handlebars-template">
    
        
    <section id="status" class="success">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Status</h2>
                    <hr class="star-light">
                </div>
            </div>

            <div class="listContainer">
                @{{{statusBody}}} @{{#if link}} <a class="@{{linkClass}}" id="@{{linkId}}" href="@{{link}}"> @{{linkText}} </a> @{{/if}}
            </div>
        </div>
    </section>
</script>