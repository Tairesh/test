<?php

namespace app\models;

use Yii,
    app\models\LogEvent;

/**
 * Description of LogFileQuery
 *
 * @author ilya
 */
class LogEventQuery
{
    const TAB = '::';

    /**
     *
     * @var LogEvent[]
     */
    private $_content = [];
    
    public function __construct($filename)
    {
        $text = Yii::$app->fs->read($filename);
        $strings = explode(PHP_EOL, $text);
                
        foreach ($strings as $i => $string) {
            $config = array_merge([$i+1], explode(self::TAB, $string));
            $this->_content[] = new LogEvent($config);
        }
    }
    
    /**
     * 
     * @return self
     */
    public function withUser()
    {
        $newcontent = [];
        while (count($this->_content)) {
            $event = array_shift($this->_content);
            if ($event->userId) {
                $newcontent[] = $event;
            }
        }
        $this->_content = $newcontent;
        
        return $this;
    }
    
    /**
     * 
     * @return self
     */
    public function withSystem()
    {
        $newcontent = [];
        while (count($this->_content)) {
            $event = array_shift($this->_content);
            if ($event->sourceFile && strpos($event->sourceFile, 'controllers') > -1) {
                $newcontent[] = $event;
            }
        }
        $this->_content = $newcontent;
        
        return $this;
    }
    
    /**
     * 
     * @param string $type 
     * @return self
     */
    public function byErrorType($type)
    {        
        $newcontent = [];
        while (count($this->_content)) {
            /* @var $event LogEvent */
            $event = array_shift($this->_content);
            if ($event->errorType && $event->errorType === $type) {
                $newcontent[] = $event;
            }
        }
        $this->_content = $newcontent;
        
        return $this;
    }

    /**
     * 
     * @return LogEvent[]
     */
    public function all()
    {
        return $this->_content;
    }
    
    /**
     * 
     * @return LogEvent
     */
    public function one()
    {
        return array_shift($this->_content);
    }
    
    
}
