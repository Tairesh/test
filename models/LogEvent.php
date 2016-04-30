<?php

namespace app\models;

use Yii,
    yii\base\Model,
    app\models\LogEventQuery;

/**
 * Description of LogFile
 *
 * @author ilya
 * 
 * @property string $errorLine
 */
class LogEvent extends Model
{
    public $i;
    public $datetime;
    public $namespace;
    public $errorType;
    public $userId;
    public $sourceFile;
    public $lineNumber;
    public $message;
    
    public function __construct($config = array())
    {
        $this->i = $config[0];
        $this->datetime = strtotime($config[1]);
        if ($config[2]) {
            $this->namespace = $config[2];
        }
        $this->errorType = $config[3];
        if (count($config) === 6) {
            switch ($config[4][0]) {
                case '#':
                    $this->userId = intval(str_replace('#', '', $config[4]));
                    break;
                case '@':
                    list($this->sourceFile, $this->lineNumber) = explode(':', str_replace('@', '', $config[4]));
                    break;
            }
            $this->message = $config[5];
        } else {
            $this->message = $config[4];
        }
        
        return parent::__construct();
    }

        /**
     * 
     * @return LogEventQuery
     */
    public static function find()
    {
        return new LogEventQuery(Yii::$app->basePath."/web/files/log.txt");
    }
    
    public function getErrorLine()
    {
        if ($this->sourceFile && $this->lineNumber) {
            $file = Yii::$app->fs->read($this->sourceFile);
            $line = explode(PHP_EOL, $file)[$this->lineNumber-1];
            return trim($line);
        }
        
        return null;
    }
    
}
