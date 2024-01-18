<?php
namespace src\logic;

    use Exception;

    class TaskMaker
    {
        const STATUS_NEW = 'new';
        const STATUS_CANCELLED = 'cancelled';
        const STATUS_PROCESSING = 'processing';
        const STATUS_DONE = 'done';
        const STATUS_FAILED = 'failed';

        const ACTION_CANCEL = 'act_cancel';
        const ACTION_REACT = 'act_react';
        const ACTION_FINISH = 'act_finish';
        const ACTION_DENY = 'act_deny';

        public array $possible_action;
        public string $status = '';
        public string $task_header = '';
        public string $task_text = '';
        public int $host_id;
        public int $performer_id;

        public static int $object_counter = 0;

        /**
         * TaskMaker constructor.
         * @param int $host_id
         * @param string $task_header
         * @param string $task_text
         * @param int $performer_id
         */
        function __construct (int $host_id, string $task_header, string $task_text, int $performer_id)
        {	$this->task_id = ++self::$object_counter;
            $this->host_id = $host_id;
            $this->performer_id = $performer_id;
            $this->task_header = $task_header;
            $this->task_text = $task_text;
            $this->status = self::STATUS_NEW;
            $this->possible_action['host'] = $this->possibleAction($this->host_id, $this->status);
            $this->possible_action['performer'] = $this->possibleAction($this->performer_id, $this->status);
        }

        /**
         * @param int $user_id
         * @param string $status
         * @return object
         */

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

        /**
         * @param string $status
         * @return array
         */

        static function possibleActionsMap(string $status)
        {
            $possible_actions = ['host'=>NULL, 'performer' => NULL];
            $performer_actions = [
                self::STATUS_NEW => self::ACTION_REACT,
                self::STATUS_CANCELLED => NULL,
                self::STATUS_PROCESSING => self::ACTION_DENY,
                self::STATUS_DONE => NULL,
                self::STATUS_FAILED => NULL
            ];
            $host_actions = [
                self::STATUS_NEW =>self::ACTION_CANCEL,
                self::STATUS_CANCELLED => NULL,
                self::STATUS_PROCESSING => self::ACTION_FINISH,
                self::STATUS_DONE => NULL,
                self::STATUS_FAILED => NULL
            ];
            $possible_acrions['host'] = $host_actions[$status];
            $possible_actions['performer'] = $performer_actions[$status];
            return $possible_actions;
        }

        /**
         * @param string $action
         * @return mixed
         * @throws Exception
         */

        public function getStatusAfterAction (string $action)
        {
            $status_map = [
                self::ACTION_REACT => self::STATUS_PROCESSING,
                self::ACTION_CANCEL => self::STATUS_CANCELLED,
                self::ACTION_FINISH => self::STATUS_DONE,
                self::ACTION_DENY => self::STATUS_FAILED
            ];
            if(in_array(get_class($action), array_keys($status_map)))
            {
                return ($status_map[get_class($action)]);
            }
            else
            {
                throw new ActionException("Неизвестное действие: $action");
            }
        }

        /**Russian identities of statuses
         * @return array
         */
        public function getStatusMap()
        {
            return [
                self::STATUS_NEW => 'Новое',
                self::STATUS_CANCELLED => 'Отменено',
                self::STATUS_PROCESSING => 'В работе',
                self::STATUS_DONE => 'Выполнено',
                self::ACTION_DENY => 'Провалено'
            ];
        }

        /**Russian identities of actions
         * @return array
         */
        public function getActionsMap()
        {
            return [
                self::ACTION_REACT => 'Откликнуться',
                self::ACTION_CANCEL => 'Отменить',
                self::ACTION_FINISH => 'Завершить',
                self::ACTION_DENY => 'Отказаться'
            ];
        }

        /**
         * @param string $status
         * @throws StatusException
         */
        public function setStatus (string $status)
        {
            $available_statuses = [
                self::STATUS_NEW,
                self::STATUS_DONE,
                self::STATUS_FAILED,
                self::STATUS_PROCESSING,
                self::STATUS_CANCELLED
            ];
            if (in_array($status, $available_statuses)) {
                $this->status = $status;
            }
            else
            { throw new StatusException("Неизвестный статус: $status"); }
        }
}

