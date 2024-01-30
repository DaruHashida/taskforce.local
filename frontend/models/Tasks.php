<?php

namespace frontend\models;

use Yii;
use frontend\models\Replies;
use frontend\models\Users;
use src\logic\Task;
use src\logic\CancelAction;
use src\logic\ReactAction;
use src\logic\FinishAction;
use src\logic\DenyAction;
use app\helpers\YandexMapHelper;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use DateTime;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string|null $task_creation_date
 * @property string|null $task_title
 * @property string|null $task_description
 * @property string|null $task_host
 * @property string|null $task_performer
 * @property string|null $task_expire_date
 * @property string|null $task_status
 * @property string|null $task_actions
 * @property string|null $task_coordinates
 * @property float $task_price
 * @property string|null $task_category
 */
class Tasks extends ActiveRecord
{
    public $noResponses;
    public $noLocation;
    public $filterPeriod;
    public $loc_validation;
    public $attach_file;
    const STATUS_NEW = 'new';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_title', 'task_category','task_price','task_description','task_expire_date'],'required'/*,'on'=>self::SCENARIO_DEFAULT*/],
            [['task_creation_date'], 'safe'],
            [['task_price'], 'number'],
            [['task_title', 'task_host', 'task_performer', 'task_expire_date', 'task_actions', 'task_coordinates', 'task_category'], 'string'],
            [['task_description'], 'string', 'max' => 1000],
            ['task_expire_date', 'default', 'value' => null],
            ['task_creation_date', 'default', 'value' => date("Y-m-d H:i:s")],
            ['task_status', 'default', 'value' => "STATUS_NEW"],
            ['task_expire_date', 'valiDate'],
            ['loc_validation', 'validateL'],
            ['loc_validation', 'default', 'value' => 'Адрес не определен!'],
            [['attach_file'],'file'],
            [['attach_file'], 'file', 'maxSize' => 1024 * 1024 * 100, 'skipOnEmpty' => true, 'message' => 'Ваш файл-описание задания не должен быть больше 100 Мб'],
            [['attach_file'], 'file', 'extensions' => 'jpg, jpeg, png, pdf, docx, txt, doc', 'message' => 'Ваш фай должен иметь либо формат jpg, либо jpeg, либо png, либо pdf, либо docx, либо doc, либо txt!'],
            [['noResponses', 'noLocation'], 'boolean'],
            [['filterPeriod'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Task ID',
            'task_creation_date' => 'Дата публикации',
            'task_title' => 'Заголовок задания',
            'task_description' => 'Описание задания',
            'task_host' => 'Заказчик',
            'task_performer' => 'Исполнитель',
            'task_expire_date' => 'Время окончания задания',
            'task_status' => 'Статус',
            'task_actions' => 'Допустимые действия',
            'task_coordinates' => 'Местоположение',
            'task_price' => 'Цена',
            'task_category' => 'Категория',
            'task_city' => 'Город, где требуется исполнить задание',
            'noResponses' => 'Без откликов',
            'noLocation' => 'Без адреса'
        ];
    }
    public function getFile()
    {
        return $this->hasMany(File::class, ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Reply]].
     *
     * @return ActiveQuery
     */
//    public function getReplies()
//    {
//        return Replies::find()->where(['task_id'=>$this->task_id])->all();
//    }


    /**
     * Gets query for [[Category]].
     *
     * @return ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['name' => 'task_category']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return ActiveQuery
     */

    public function getStatus()
    {
        return $this->hasOne(Status::class, ['name' => 'task_status']);
    }

    /**
     * @return string|null
     */

    /**
     * @return mixed
     */

    public function getOwner()
    {
        return Users::find()->where(['id' => $this->task_host])->one();
    }

    /**
     * @return mixed
     */
    public function getPerformer()
    {
        return Users::find()->where(['id' => $this->task_performer])->one();
    }
    /**
     * @return mixed
     */
    public function getReplies()
    {
        return $this->hasMany(Replies::className(), ['task_id' => 'id']);
    }

    public function getSearchQuery()
    {
        $query = self::find();

        $query->andFilterWhere(['task_category' => $this->task_category]);

        if ($this->noLocation) {
            $query->andWhere('task_coordinates IS NULL');
        }

        if ($this->noResponses) {
            $query->joinWith('replies r')->andWhere('r.id IS NULL');
        }
        if ($this->filterPeriod) {
            $query->andWhere('UNIX_TIMESTAMP(tasks.task_creation_date) > UNIX_TIMESTAMP()-:period', [':period' => $this->filterPeriod]);
        }
        return $query->orderBy('task_creation_date DESC');
    }
    /*
     *
     */
    public function getTask($id)
    {
        $query = self::findOne($id);
        return $query;
    }
    /**
     *
     */
    public function possibleAction(int $user_id, ?string $status)
    {
        $possible = [];
        if (!isset($status) || !$status) {
            $status = 'STATUS_NEW';
        }
        $actions_map = [
            'STATUS_NEW' => [ReactAction::class, CancelAction::class],
            'STATUS_PROCESSING' => [DenyAction::class, FinishAction::class],
            'STATUS_FAILED' => [],
            'STATUS_DONE' => []
        ];

        $possible_actions = $actions_map[$status];

        foreach ($possible_actions as $action) {
            if ($action::getUserProperties($user_id, $this)) {
                array_push($possible, new $action($this->task_host, $this->task_performer));
            }
        }
        return $possible;
    }
/*
 *
 */
    public function getRussianStatusName()
    {
        $status_map = [
        'STATUS_NEW' => 'Новое',
        'STATUS_PROCESSING' => 'Выполняется',
            'STATUS_FAILED' => 'Отказ исполнителя',
            'STATUS_DONE' => 'Выполнено'
        ];
        return ($status_map[$this->task_status]);
    }
/*
 *
 */
    public function validateL($attribute)
    {
        if ($this->task_coordinates && $this->loc_validation) {
            $this->addError($attribute, $this->loc_validation);
        }
    }

    public function valiDate($attributes = null, $clearErrors = true)
    {
        $d = DateTime::createFromFormat('Y-m-d', $this->task_expire_date);

        return ($d && $d->format('Y-m-d') === $this->task_expire_date);
    }
    /*
     *
     */
    public function upload()
    {
        $user = Yii::$app->getUser()->getIdentity();
        $id = $user->id;
        $path = '\uploads\\' . $id . '\\' . $this->attach_file->baseName . '.' . $this->attach_file->extension;
        $full_path_to_save = Yii::$app->basePath . '\web' . $path;
        if (!is_dir(Yii::$app->basePath . '\web\uploads\\' . $id)) {
            mkdir(Yii::$app->basePath . '\web\uploads\\' . $id, 0777, true);
        }
        $this->task_file = $path;
        $this->task_file_name = $this->attach_file->baseName . '.' . $this->attach_file->extension;
        $this->task_file_size = $this->attach_file->size;
        if ($this->task_file_size > 1024 * 1024) {
            $this->task_file_size = round($this->task_file_size / (1024 * 1024), 1) . ' мб';
        }
        if ($this->task_file_size > 1024) {
            $this->task_file_size = round($this->task_file_size / 1024, 1) . ' кб';
        }
        $this->attach_file->saveAs($full_path_to_save);
        $this->attach_file = null;
    }
//    public function beforeSave($insert)
//    {
//        if ($this->task_coordinates) {
//            $yandexHelper = new YandexMapHelper(getenv('YANDEX_API_KEY'));
//            $coords = $yandexHelper->getCoordinates($this->task_city, $this->task_coordinates);
//
//            if ($coords) {
//                [$lat, $long] = $coords;
//
//                $this->lat = $lat;
//                $this->long = $long;
//            }
//        }
//
//        parent::beforeSave($insert);
//
//        return true;
//    }
}
