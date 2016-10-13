		<script id="footer-template" type="text/x-handlebars-template">
			<span id="todo-count"><strong>{{activeTodoCount}}</strong> {{activeTodoWord}} left</span>
			<ul id="filters">
				<li>
					<a {{#eq filter 'all'}}class="selected"{{/eq}} href="#/all">All</a>
				</li>
				<li>
					<a {{#eq filter 'active'}}class="selected"{{/eq}}href="#/active">Active</a>
				</li>
				<li>
					<a {{#eq filter 'completed'}}class="selected"{{/eq}}href="#/completed">Completed</a>
				</li>
			</ul>
			{{#if completedTodos}}<button id="clear-completed">Clear completed</button>{{/if}}
		</script>