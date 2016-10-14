<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class viewtodo extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTitle(){
        
        $this->visit('/')
             ->see('Todos');
        
    }
    
    public function testContent(){
        
        $this->visit('/')
             ->see('Todos');
        // change to look at database and find something to look for
        
    }
}
