<?php
require_once '/vendor/autoload.php';
use logic\TaskMaker;
$task = new TaskMaker(1,'Поесть колбасы','Нужна колбаса!',2);
var_dump($task->possibleActionsMap('new'));
$task->setStatus('ndbbdb');
var_export($task);
