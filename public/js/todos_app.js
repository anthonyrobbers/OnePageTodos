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
                
                .on('click', '.glyphicon-ok', function(event){
                if(DEBUG==1){console.log('in event hendeler for prevent default glyphicon-ok');}
                event.preventDefault();
                })
                .on('click', '.glyphicon-ok', this.toggleComplete.bind(this))
                .on('click', '.glyphicon-unchecked', function(event){
                    if(DEBUG==1){console.log('in event hendeler for prevent default glyphicon-unchecked');}
                    event.preventDefault();
                    })
                .on('click', '.glyphicon-unchecked', this.toggleComplete.bind(this))
                .on('click', '.destroy', function(event){
                    if(DEBUG==1){console.log('in event hendeler for prevent default destroy');}
                    event.preventDefault();
        })
                .on('click', '.destroy', this.destroy.bind(this));
            
        },
        toggleComplete: function (e) {
            if(DEBUG==1){console.log('in toggleComplete function todos = '+JSON.stringify(this.todos));}
            var indexToToggle=this.indexFromEl(e.target);
            if(DEBUG==1){console.log(JSON.stringify(indexToToggle)+' was indexToToggle');}
            var thisTodo = this.todos[indexToToggle];
            if(DEBUG==1){console.log(JSON.stringify(thisTodo)+' was thisTodo');}
            this.toggleCompleteHome(thisTodo['id']);
            this.toggleCompleteInDom($(e.target));
            
            this.todos[indexToToggle].complete=1-this.todos[indexToToggle].complete;
            
            if(DEBUG==1){console.log('leaving toggleComplete function todos = '+JSON.stringify(this.todos));}
        },
        toggleCompleteHome: function (homeId){
            if(DEBUG==1){console.log('in toggleCompleteHome');}
            if(!$('#new-todo').hasClass('loading')){
                //ajax to GET at /TodoItem/{id}/complete
                
                var reply=' ';
                $.ajax({ 
                    url: "TodoItem/"+homeId+'/complete', 
                    data: {
                        _token :initOptions.token,
                        ajax:1, 
                        beforeSend: function() {
                            if(DEBUG==1){console.log('sending ajax to toggle complete '+homeId);}
                            $('#new-todo').addClass('loading');
                        }
                    }, 
                    type: "GET"
                }).done(function(responce){
                    reply = responce;
                    if(DEBUG==1){console.log('ajax success'+responce);}
                }).fail( function(xhr, status, errorThrown){ 
                    if(DEBUG==1){console.log('ajax failed'+errorThrown+status);}
                    alert(errorThrown+status);
                }).always(function(xhr, status){
                    $('#new-todo').removeClass('loading');
                    if(DEBUG==1){console.log('ajax finished');}
                });
            }
        },
        toggleCompleteInDom: function (glyphiconReference) {
            if(DEBUG==1){console.log('in toggleCompleteInDom');}
            if(glyphiconReference.hasClass('glyphicon-ok')){
                glyphiconReference.removeClass('glyphicon-ok');
                glyphiconReference.addClass('glyphicon-unchecked');
            }
            else {
                glyphiconReference.removeClass('glyphicon-unchecked');
                glyphiconReference.addClass('glyphicon-ok');
            }
            if(DEBUG==1){console.log('row removed');}
            
        },
        destroy: function (e) {
            if(DEBUG==1){console.log('in destroy function todos = '+JSON.stringify(this.todos));}
            var indexToDestroy=this.indexFromEl(e.target);
            if(DEBUG==1){console.log(JSON.stringify(indexToDestroy)+' was indexToDestroy');}
            var thisTodo = this.todos[indexToDestroy];
            if(DEBUG==1){console.log(JSON.stringify(thisTodo)+' was thisTodo');}
            this.destroyHome(thisTodo['id']);
            
            this.destroyInDom($(e.target).closest('.row'));
            
            this.todos.splice(indexToDestroy, 1); //removing the todo from the js variable
            
            //this.render(); //needs a new render function maybe specific to destroy?
            
            //all actions are in triplicate first inform the DB then the DOM then the js variable
            
            if(DEBUG==1){console.log('leaving destroy function todos = '+JSON.stringify(this.todos));}
        },
        destroyHome: function (homeId) {
            if(DEBUG==1){console.log('in destroyHome');}
            if(!$('#new-todo').hasClass('loading')){
                //ajax to DELETE /TodoItem/{id}
                var reply=' ';
                $.ajax({ 
                    url: "TodoItem/"+homeId, 
                    data: {
                        _method: 'delete',
                        _token :initOptions.token,
                        ajax:1, 
                        beforeSend: function() {
                            if(DEBUG==1){console.log('sending ajax to delete '+homeId);}
                            $('#new-todo').addClass('loading');
                        }
                    }, 
                    type: "POST"
                }).done(function(responce){
                    reply = responce;
                    if(DEBUG==1){console.log('ajax success'+responce);}
                }).fail( function(xhr, status, errorThrown){ 
                    if(DEBUG==1){console.log('ajax failed'+errorThrown+status);}
                    alert(errorThrown+status);
                }).always(function(xhr, status){
                    $('#new-todo').removeClass('loading');
                    if(DEBUG==1){console.log('ajax finished');}
                });
            }
        },
        destroyInDom: function (RowRefference){
            if(DEBUG==1){console.log('in destroyInDom');}
            RowRefference.remove();
            if(DEBUG==1){console.log('row removed');}
        },
        hideTask: function (RowRefference) {
            
        },
        revealTask: function (RowRefference) {
            
        },
        NukeAndPave: function () {
            
        },
        indexFromEl: function (el) {
            if(DEBUG==1){console.log('in indexFromEl');}
            var id = $(el).closest('.row').data('id'); //needs to be changed to divs of class row and those need a data-id="..." added to be checked
            //if(DEBUG==1){console.log(JSON.stringify(id)+' = target id');}
            var todos = this.todos;
            //if(DEBUG==1){console.log(todos.length+'todos.length');}
            var i = todos.length;
            //if(DEBUG==1){console.log(i+'=i');}
            
            while (i--) {
                //if(DEBUG==1){console.log(JSON.stringify(i)+' =i in loop');}
                //if(DEBUG==1){console.log(JSON.stringify(todos[i])+'=todo[i]');}
                //if(DEBUG==1){console.log(JSON.stringify(todos[i].id)+'=id of todo[i]');}
                if (todos[i].id == id) {
                    if(DEBUG==1){console.log('found the right id in i');}
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