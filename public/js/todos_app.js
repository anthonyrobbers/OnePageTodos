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
            this.primaryOptions = initOptions; // from .../optionsVarJs.blade.php
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
        // watches for any events that need to be watched for the app and calls the right functions in responce
        bindEvents: function () {
            //add other events
            //$('#AddTask').on('keyup',this.create.bind(this)); //disabled since it is redundant add button catches enter
            $('#add').on('click',this.create.bind(this));
            $('.filter').on('click',this.setFilter.bind(this));
            $('#clear-completed').on('click',this.clearCompleted.bind(this));
            $('#complete-all').on('click',this.completeAll.bind(this));
            $('#todo-list')
                .on('click','.task-edit', this.openEdit.bind(this))
                .on('keyup', this.pressedEsc.bind(this))
                .on('click','.update', this.edit.bind(this))
                .on('click', '.glyphicon-ok', this.toggleComplete.bind(this))
                .on('click', '.glyphicon-unchecked', this.toggleComplete.bind(this))
                .on('click', 'task-edit', this.openEdit.bind(this))
                .on('click', '.destroy', this.destroy.bind(this));
                
            
        },
        pressedEsc: function (e) {
            // e = an event from presing the escape key
            // returns nothing, but clears the edit field, the new todo field, and resets priority to 5
            if (e.which !== ESCAPE_KEY) {
                return;
            }
            this.renderList();
            $('#new-todo').val('');
            $('#priority').val('5');
            
        },
        openEdit: function (e) {
            // e = an event from clicking on the link that is the task name
            // returns nothing but updates DOM and updates prepares functions for editing
            if(DEBUG==1){console.log('in openEdit');} 
            e.preventDefault();
            
            var indexToEdit=this.indexFromEl(e.target);
            var task=this.todos[indexToEdit].task;
            var priority=this.todos[indexToEdit].priority;
            var id=this.todos[indexToEdit].id;
            
            $(e.target).html('<input id="edit-todo" name="new-todo" value="'+task+
                '" autofocus="" class=""><input id="priority" name="priority" type="number" value="'
                +priority+'">'); //replace link contents with inputs
        
            $(e.target).closest('.row').children('.listButton').html('<a class="btn btn-success btn-sm update" '+
                'href="'+this.primaryOptions.homeUrl+'TodoItem/'+id+'/edit" >Update</a>'); //replace button
            
        },
        edit: function (e) {
            // e = an event from clicking on the add button or hitting enter
            // returns nothing but sends ajax, updates DOM, and updates internal variables
            if(DEBUG==1){console.log('in edit');} 
            e.preventDefault();
            
            // go into css and make priority class by renaming the id priority to that
            // make open edit give id to priority = edit-priority
            
            var newTodo = $('#edit-todo').val();
            var priority = $('#edit-priority').val();
            
            this.sendHome('TodoItem',{"new-todo":newTodo, "priority":priority},
                'create new todo: '+newTodo,'POST', this.renderList, this.editFailed, this);
            
            // find the index of edited task in this.todos
            // edit it there
            
            this.renderList();
            
        },
        editFailed: function (reply, that) {
            if(DEBUG==1){console.log('in createFailed'+reply);} 
            alert('Failed to edit task.');
            if(DEBUG==1){console.log('leaving createFailed function todos = '+JSON.stringify(that.todos));}
        },
        create: function (e) {
            // e = an event from clicking on the add button or hitting enter
            // returns nothing but sends ajax, updates DOM, and updates internal variables
            if(DEBUG==1){console.log('in create function todos = '+JSON.stringify(this.todos));}
            e.preventDefault();
            
            var newTodo = $('#new-todo').val();
            var priority = $('#priority').val();
            
            this.sendHome('TodoItem',{"new-todo":newTodo, "priority":priority},
                'create new todo: '+newTodo,'POST', this.createContinued, this.createFailed, this);
            
            
        },
        createContinued: function (reply, that) {
            if(DEBUG==1){console.log('entering createContinued function reply = '+JSON.stringify(reply));}
            that.todos.push(reply);
            
            that.todos.sort(function(a, b) {
                return parseFloat(a.priority) - parseFloat(b.priority);
            });
            that.renderList();
            
            if(DEBUG==1){console.log('leaving createContinued function todos = '+JSON.stringify(that.todos));}
        },
        createFailed: function (reply, that) {
            if(DEBUG==1){console.log('in createFailed'+reply);} 
            alert('Failed to create new task.');
            if(DEBUG==1){console.log('leaving createFailed function todos = '+JSON.stringify(that.todos));}
        },
        // sets the filter to the value of the button clicked accepts an event and 
        // returns nothing or 1 if the filter is already the one in the event
        setFilter: function (e) {
             if(DEBUG==1){console.log('in setFilter');}   
             e.preventDefault();
             var newFilter = $(e.target).val(); //get the value of the button pressed
             if(this.primaryOptions.filter==newFilter){// test if this is the active filter
                 return 1;  // leave the function when it is not needed
             }
             // if not the active filter
             $('.filter').removeClass('active');// find and remove the active class from the filter buttons 
             $(e.target).addClass('active'); //set this button to the active class 
             
             this.primaryOptions.filter=newFilter;// then set the local variable to the new filter
             
             this.sendHome('optionList/1',{"filter":newFilter},'set filter to '+newFilter,'PUT'); //send ajax to change the filter
             this.renderList();// nuke and pave with new filter deleting all the html in the just-todos id div and recountingthe active count
        },
        
        // deletes all completed todos
        clearCompleted: function (e) {
            if(DEBUG==1){console.log('in clearCompleted function todos = '+JSON.stringify(this.todos));}
            e.preventDefault();
            $('.glyphicon-ok').closest('.row').remove(); //look up proper syntax for each() 
            this.clearCompletedHome(this.primaryOptions.group); //for a // DELETE  /TodoItem/{group}/scour
            for(var i=0; i<this.todos.length;i++){
                if (this.todos[i].complete == 1) {
                    this.todos.splice(i, 1); //removing the todo from the js variable
                }
            }
            if(DEBUG==1){console.log('leaving clearCompleted function todos = '+JSON.stringify(this.todos));}
        },
        clearCompletedHome: function (group) {
            if(DEBUG==1){console.log('in clearCompletedHome function ');}
            // DELETE  /TodoItem/{group}/scour
            if(!$('#new-todo').hasClass('loading')){
                //ajax to DELETE /TodoItem/{id}
                var reply=' ';
                $.ajax({ 
                    url: "TodoItem/"+group+'/scour', 
                    data: {
                        _method: 'delete',
                        _token :this.primaryOptions.token,
                        ajax:1, 
                        beforeSend: function() {
                            if(DEBUG==1){console.log('sending ajax to scour'+group);}
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
                    if(DEBUG==1){console.log('ajax finished clear all complete');}
                });
            }
        },
        // marks all todos complete
        completeAll: function (e) {
            if(DEBUG==1){console.log('in completeAll function todos = '+JSON.stringify(this.todos));}
            e.preventDefault();
            
            this.completeAllHome();
            //if(DEBUG==1){console.log('in completeAll function todos = '+JSON.stringify($('.glyphicon-unchecked')));}
            $( '.glyphicon-unchecked' ).addClass('glyphicon-ok').removeClass('glyphicon-unchecked');
            // glyphiconReference.removeClass('glyphicon-unchecked');
              //  glyphiconReference.addClass('glyphicon-ok');
            //for each one todo in list
            for(var i=0;i<this.todos.length;i++){
                this.todos[i].complete=1;
            }
            this.primaryOptions.activeCount = 0;
            $('#active-count').html(this.primaryOptions.activeCount+' Active Tasks');
            if(DEBUG==1){console.log('leaving completeAll function todos = '+JSON.stringify(this.todos));}    
        },
        completeAllHome: function   (){
            if(DEBUG==1){console.log('in completeAllHome');}  
            if(!$('#new-todo').hasClass('loading')){
                //ajax to GET at /complete  //GET at /complete
                
                var reply=' ';
                $.ajax({ 
                    url: 'complete', 
                    data: {
                        _token :this.primaryOptions.token,
                        ajax:1, 
                        beforeSend: function() {
                            if(DEBUG==1){console.log('sending ajax to complete all');}
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
                    if(DEBUG==1){console.log('ajax complete all finished');}
                });
            }
        },
        // toggleComplete (  e (an event assumed to point to the complete checkbox)  )
        //  switches the complete in the this.todos variable, the database, and changes the checkbox 
        //  from checked to unchecked or vice versa
        // returns nothing
        toggleComplete: function (e) {
            if(DEBUG==1){console.log('in toggleComplete function todos = '+JSON.stringify(this.todos));}
            e.preventDefault();
            var indexToToggle=this.indexFromEl(e.target);
            if(DEBUG==1){console.log(JSON.stringify(indexToToggle)+' was indexToToggle');}
            var thisTodo = this.todos[indexToToggle];
            if(DEBUG==1){console.log(JSON.stringify(thisTodo)+' was thisTodo');}
            
            if (this.todos[indexToToggle].complete==0) {this.primaryOptions.activeCount-=1;}
            else {this.primaryOptions.activeCount+=1;}
            
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
                        _token :this.primaryOptions.token,
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
            
            $('#active-count').html(this.primaryOptions.activeCount+' Active Tasks');
            
            if(DEBUG==1){console.log('complete toggled');}
            
        },
        // destroy (  e (an event assumed to point to a todo indirectly)  )
        //  removes the todo pointed to by the event from the DOM, this.todos variable, and the database.
        // returns nothing
        destroy: function (e) {
            if(DEBUG==1){console.log('in destroy function todos = '+JSON.stringify(this.todos));}
            e.preventDefault();
            var indexToDestroy=this.indexFromEl(e.target);
            if(DEBUG==1){console.log(JSON.stringify(indexToDestroy)+' was indexToDestroy');}
            var thisTodo = this.todos[indexToDestroy];
            if(DEBUG==1){console.log(JSON.stringify(thisTodo)+' was thisTodo');}
            this.destroyHome(thisTodo['id']);
            if (this.todos[indexToDestroy].complete == 0){
                this.primaryOptions.activeCount-=1;  } 
            
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
                        _token :this.primaryOptions.token,
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
            $('#active-count').html(this.primaryOptions.activeCount+' Active Tasks');
            if(DEBUG==1){console.log('row removed');}
        },
        hideTask: function (RowRefference) {
         if(DEBUG==1){console.log('in hideTask');}   
         
        },
        revealTask: function (RowRefference) {
            
        },
        // renderList () a function to clear the html of old todos and reload the list as html and update the active count
        //  returns nothing
        renderList: function () {
             if(DEBUG==1){console.log('in renderlist todos: '+JSON.stringify(this.todos));}   
             if(DEBUG==1){console.log('in renderlist options: '+JSON.stringify(this.primaryOptions));}   
            var listHtml = '';
            var activeCount = 0;
            var localOptions = this.primaryOptions;
            var template = this.todoTemplate;
            this.todos.forEach(function(todo, index){
                 //if(DEBUG==1){console.log(JSON.stringify($().extend({},todo, localOptions)));} 
                var longTodo= $().extend({},todo, localOptions); 
                //if(DEBUG==1){console.log(longTodo.complete);}
                //if (longTodo.complete == "0") {longTodo.complete=0;}
                if (longTodo.filter==2 || longTodo.filter==longTodo.complete){
                    listHtml = listHtml + template(longTodo);
                }
                if(todo.complete != 1){
                    activeCount+=1;
                }
            });
            $('#just-todos').html(listHtml);
            this.primaryOptions.activeCount=activeCount;
            $('#active-count').html(activeCount+' Active Tasks');
            
        },
        // this.sendHome(
        //  url (a string that is the url: X, in the ajax function),
        //  extra data(any data besides method field, token, ajax:1, and the beforesend function), 
        //  debuginfo(a string to display in debug console comandes so ajax gets labeled for easier debuging), 
        //  method ('GET','POST','DELETE','PUT',or other method.  get requests must be 'GET' caps required),
        //  that (what this should normally point to in the 
        //      function calling sendHome  functions called should use that.todos)
        //  )
        // returns nothing.  sends an ajax request as expected for the laravel setup running the backend.
        sendHome: function (url, extraData, debugInfo, method, successFunction, failFunction, that) {
            if(DEBUG==1){console.log('in sendHome for '+debugInfo);}
            if(!$('#new-todo').hasClass('loading')){
                //ajax to url
                var reply=' ';
                var argsLength= arguments.length;
                var baseData={
                        _method: method,
                        _token :this.primaryOptions.token,
                        ajax:1, 
                        beforeSend: function() {
                            if(DEBUG==1){console.log('sending ajax to '+debugInfo);}
                            $('#new-todo').addClass('loading');
                        }
                    };
                if(method!='GET'){ var baseMethod = 'POST'; }
                else { var baseMethod = 'GET';}
                
                $.ajax({ 
                    url: url, 
                    data: $.extend(baseData,extraData), 
                    type: baseMethod
                }).done(function(responce){
                    reply = responce;
                    if(DEBUG==1){console.log('arg length: '+argsLength);}
                    if (argsLength > 6) {
                        if(DEBUG==1){console.log('ajax success function');}
                        successFunction(reply, that);
                    }
                    if(DEBUG==1){console.log('ajax success'+responce);}
                }).fail( function(xhr, status, errorThrown){ 
                    if (argsLength > 6) {
                        if(DEBUG==1){console.log('ajax fail function');}
                        failFunction(status, that);
                    }
                
                    if(DEBUG==1){console.log('ajax failed'+errorThrown+status);}
                    alert(errorThrown+status);
                }).always(function(xhr, status){
                    $('#new-todo').removeClass('loading');
                    if(DEBUG==1){console.log('ajax finished for '+debugInfo);}
                });
            }
        },
        //indexFromEl (
        //  el(an element) 
        //  )
        //  returns the index of the element in the todos variable this is a intiger
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