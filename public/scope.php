<?php

$global_variable = 'connu dans tout le fichier';

class MyClass 
{

    public $myProperty;
    public $anotherProperty;
 
    public function __construct($message){
         $this->myProperty = $message;
         $this->anotherProperty = myFunction();
     }
     
     public function myMethod($message){
         echo $message;
     }
}


function myFunction()
{
    $functionscope = 'connu dans la fonction';
    return $functionscope;
}        


// echo $functionscope;

$myObject = new MyClass('Lucas');
$myOtherObject = new MyClass('Hamza');

echo $myOtherObject->myProperty;


// echo $myProperty;
// echo $anotherProperty;

myFunction();
$myObject->myProperty;
$myObject->myMethod('hey ca marche');

