<script id="options-init" >
    var initOptions = {
        group : "{{$options['group']}}",
        filter: {{$options['filter']}},
        token: "{{csrf_token()}}"
    };
</script>