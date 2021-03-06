﻿<!doctype html>
<html lang="en" data-framework="jquery">
	<head>
		<meta charset="utf-8">
		<title>jQuery • TodoMVC</title>
		<link rel="stylesheet" href="{{asset('node_modules/todomvc-common/base.css')}}">
		<link rel="stylesheet" href="{{asset('node_modules/todomvc-app-css/index.css')}}">
		<link rel="stylesheet" href="{{asset('css/app_mvc.css')}}">
	</head>
	<body>
		<section id="todoapp">
			<header id="header">
				<h1>todos</h1>
				<input id="new-todo" placeholder="What needs to be done?" autofocus>
			</header>
			<section id="main">
				<input id="toggle-all" type="checkbox">
				<label for="toggle-all">Mark all as complete</label>
				<ul id="todo-list"></ul>
			</section>
			<footer id="footer"></footer>
		</section>
		<footer id="info">
			<p>Double-click to edit a todo</p>
		</footer>
		@include('handlebarsTemplates/todo')
                @include('handlebarsTemplates/footer')
		<script src="{{asset('node_modules/todomvc-common/base.js')}}"></script>
		<script src="{{asset('node_modules/jquery/dist/jquery.js')}}"></script>
		<script src="{{asset('node_modules/handlebars/dist/handlebars.js')}}"></script>
		<script src="{{asset('node_modules/director/build/director.js')}}"></script>
		<script src="{{asset('js/app_mvc.js')}}"></script>
	</body>
</html>