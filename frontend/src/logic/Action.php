<?php
namespace src\logic;
	abstract class Action 
	{	
		protected int $host_id;
		protected int $performer_id;
		function __construct (int $host_id, ?int $performer_id)
		{
		$this->host_id = $host_id;
		if(isset($performer_id))
        {$this->performer_id = $performer_id;}
		}
		abstract public function getName(): string;
		abstract protected function getInnerName(): string;
		abstract static function getUserProperties(int $user_id, object $obj): bool;
		abstract public function getButton(): string;
		abstract public function getForm($task_id): string;
	}