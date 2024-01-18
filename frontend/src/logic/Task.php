<?php
namespace logic;

use logic\CancelAction;
use logic\ReactAction;
use logic\FinishAction;
use logic\DenyAction;
use Exception;

class TaskMaler

{
const STATUS_NEW = 'new';
const STATUS_CANCELED = 'canceled';
const STATUS_PROCESSING = 'processing';
const STATUS_DONE = 'done';
const STATUS_FAILED = 'failed';

const ACTION_CANCEL = 'act_cancel';
const ACTION_REACT = 'act_react';
const ACTION_FINISH = 'act_finish';
const ACTION_DENY = 'act_deny';

public $possible_actions = [];
public $status = '';
public $task_header = '';
public $task_text = '';
protected $host_id = null;
protected $performer_id = null;

public static object_counter = 0;

function __construct (int $host_id, string $task_header, string $task_text, int $performer_id)
{	$this->task_id = ++self::counter;
	$this->host_id = $host_id;
	$this->performer_id = $performer_id; 
	$this->task_header = $task_header;
	$this->task_text = $task_text;
	$this->status = $this->STATUS_NEW;
	$this->possible_actions = $this->possibleAction($this->status); 
}

protected function possibleAction (int $user_id, string $status): object
{
	$actions_map = [
	self::STATUS_NEW => [ReactAction::class, CancelAction::class],
	self::STATUS_PROCESSING => [DenyAction::class, FinishAction::class]
	];
	
	$possible_actions = $actions_map[$status];
	
	foreach ($possible_actions as $action)
	{ if ($action::getUserProperties($user_id,$this))
		{
			$possible = new $action($this->host_id, $this->performer_id);
	}
	}
	return $possible;
}
/*private static function possibleActionsMap(string $status, int $user_id)
{$possible_actions = ['host'=>NULL, 'performer' => NULL];
$performer_actions = [
	STATUS_NEW => ACTION_REACT,
	STATUS_CANCELLED => NULL,
	STATUS_PROCESSING => ACTION_DENY,
	STATUS_DONE => NULL,
	STATUS_FAILED => NULL
	];
$host_actions = [
	STATUS_NEW =>ACTION_CANCEL,
	STATUS_CANCELLED => NULL,
	STATUS_PROCESSING => ACTION_FINISH,
	STATUS_DONE => NULL,
	STATUS_FAILED => NULL
	];
	$possible_acrions['host'] = $host_actions[$status];
	$possible_actions['performer'] = $performer_actions[$status];
	return $possible_actions;
}*/

private static function getStatusAfterAction (string $action): ?string
{ 
	$status_map = [
		ReactAction::class => self::STATUS_PROCESSING,
		CancelAction::class=> self::STATUS_CANCELED,
		FinishAction::class=> self::STATUS_DONE,
		DenyAction::class => self::STATUS_FAILED
];
if(in_array(get_class($action), array_keys($status_map)))
{
return ($status_map[get_class($action)]);
}
else
{ 
	throw new Exception("Неизвестное действие: $action");
	}
}

protected function setStatus (string $status): void
{ $available_statuses = [$this->STATUS_NEW, $this->STATUS_DONE, 
						$this -> STATUS_FAILED, $this -> STATUS_PROCESSING, 
						$this->STATUS_CANCELED];
	if (in_array($status, $available_statuses)
	{
		$this->status = $status;
		}
	else {
		throw new Exception("Неизвестный статус: $status");
		}
}


}

