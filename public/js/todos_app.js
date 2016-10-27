/*global jQuery, Handlebars, Router */
jQuery(function ($) {
    'use strict';
    
    Handlebars.registerHelper('eq', function (a, b, options) {
		return a === b ? options.fn(this) : options.inverse(this);
	});
    
    var DEBUG = 1;
    var ENTER_KEY = 13;
    var ESCAPE_KEY = 27;
    
    var App = {
        init: function () {
            if(DEBUG==1){console.log('in init');}
            this.todos = initTodos;// get todos from partials/scripts/todoListVarJs.blade.php
            this.options = initOptions; // from .../optionsVarJs.blade.php
            this.todoTemplate = Handlebars.compile($('#todo-template').html()); // get template for a item in the list
            this.footerTemplate = Handlebars.compile($('#footer-template').html()); 
            this.bindEvents();
            
            /*
            new Router({
                '/:filter': function (filter) {
                    this.filter = filter;
                    this.render();
                }.bind(this)
            }).init('/all'); 
            */
                       
                       
        },
        
        bindEvents: function () {
            //add other events
            
            $('#todo-list')
                
                
                
                .on('click', '.destroy', function(event){
                    console.log('in event hendeler for prevent default')
                    event.preventDefault();
        })
                .on('click', '.destroy', this.destroy.bind(this));
            
        },
        destroy: function (e) {
            
            var indexToDestroy=this.indexFromEl(e.target);
            console.log(JSON.stringify(indexToDestroy));
            console.log('was indexToDestroy');
            var thisTodo = this.todos[indexToDestroy]
            console.log(JSON.stringify(thisTodo));
            console.log('was thisTodo');
            this.destroyHome(thisTodo['id']);// add a ajax method here to remove the right item from the DB
            //requires the 'id' of the thing to destroy in the DB
            
            //DOM manipulation here
            this.destroyInDom($(e.target).closest('.row'))
            
            this.todos.splice(indexToDestroy, 1); //removing the todo from the js variable
            
            //this.render(); //needs a new render function maybe specific to destroy?
            
            //all actions are in triplicate first inform the DB then the DOM then the js variable
            
            
        },
        destroyHome: function (homeId) {
            console.log('in destroyHome');
            console.log('please insert a destroy home function.');
        },
        destroyInDom: function (RowRefference){
            console.log('in destroyInDom');
            console.log('please insert a destroy in DOM function.');
        },
        indexFromEl: function (el) {
            console.log('in indexFromEl');
            //console.log(JSON.stringify(el));
            var id = $(el).closest('.row').data('id'); //needs to be changed to divs of class row and those need a data-id="..." added to be checked
            console.log(JSON.stringify(id));
            var todos = this.todos;
            //console.log(todos.length);
            //console.log('todos.length');
            var i = todos.length;
            console.log(i);
            console.log('=i');

            while (i--) {
                console.log(JSON.stringify(i));
                console.log(JSON.stringify(todos[i]));
                console.log(JSON.stringify(todos[i].id));
                if (todos[i].id == id) {
                    console.log('found');
                    return i;
                }
            }
        }/*,
             * 
        render: function () {
            var todos = this.getFilteredTodos();
            $('#todo-list').html(this.todoTemplate(todos));
            $('#main').toggle(todos.length > 0);
            $('#toggle-all').prop('checked', this.getActiveTodos().length === 0);
            this.renderFooter();
            $('#new-todo').focus();
            util.store('todosjquery', this.todos);
        },
        getFilteredTodos: function () {
            if (this.filter === 'active') {
                    return this.getActiveTodos();
            }

            if (this.filter === 'completed') {
                    return this.getCompletedTodos();
            }

            return this.todos;
        },
        */
        
    };
   
    //window.addEventListener('load',App.init());
    App.init();
    
});