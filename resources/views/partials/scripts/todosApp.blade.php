@include('partials/scripts/todoListVarJs')
@include('partials/scripts/optionsVarJs')

@include('partials/scripts/todoTemplate', ['verbose'=>FALSE])
@include('handlebarsTemplates/footer')
@include('partials/scripts/statusTemplate')

<script src="{{asset('node_modules/todomvc-common/base.js')}}"></script>
<script src="{{asset('node_modules/handlebars/dist/handlebars.js')}}"></script>
<script src="{{asset('node_modules/director/build/director.js')}}"></script>
<script src="{{asset('js/todos_app.js')}}"></script>