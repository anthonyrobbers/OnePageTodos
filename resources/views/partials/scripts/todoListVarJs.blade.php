<script id="todo-list-init" >
    var initTodos = [
        <?php
        $translatedList=array();
            foreach($todos as $todo){
                $translatedList[] = '{"id":"'.$todo['id'].'","task":"'.$todo['task']
                        .'","priority":"'.$todo['priority'].'","group":"'.$todo['group']
                        .'","complete":"'.$todo['complete'].'"}';  
                // should look like{"id":"2","title":"test","completed":false},
                // ['task', 'priority', 'group', 'complete']
            }
            echo implode(',',$translatedList);
        ?>
    
    ];
</script>