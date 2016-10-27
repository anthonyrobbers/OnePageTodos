@include('partials/scripts/todoListVarJs')
@include('partials/scripts/optionsVarJs')

@include('handlebarsTemplates/todo')
@include('handlebarsTemplates/footer')

<script src="{{asset('node_modules/todomvc-common/base.js')}}"></script>
<script src="{{asset('node_modules/handlebars/dist/handlebars.js')}}"></script>
<script src="{{asset('node_modules/director/build/director.js')}}"></script>
<script src="{{asset('js/todos_app.js')}}"></script>