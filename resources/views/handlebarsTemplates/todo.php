		<script id="todo-template" type="text/x-handlebars-template">
			{{#this}}
			<li {{#if completed}}class="completed"{{/if}} data-id="{{id}}">
				<div class="view">
					<input class="toggle" type="checkbox" {{#if completed}}checked{{/if}}>
					<label>{{title}}</label>
					<button class="destroy"></button>
				</div>
				<input class="edit" value="{{title}}">
			</li>
		{{/this}}
		</script>