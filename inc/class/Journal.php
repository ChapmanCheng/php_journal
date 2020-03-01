<?php
class Journal
{
    // private $title;
    // private $date;
    // private $time_spent;
    // private $learn;
    // private $resources;
    private $data = array();

    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $this->data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_STRING);
        }
    }
    public function __get($name)
    {
        if ($name == 'data') {
            return $this->data;
        } elseif (array_key_exists($name, $this->data)) {
            $data = $this->data[$name];
            return $data;
        }
        return false;
    }
    public function checkExist($keys)
    {
        foreach ($keys as $key) {
            if (empty($this->data[$key])) {
                echo $key . ' is empty';
                return false;
            };
        }
        return true;
    }
    public function printDateString()
    {
        $timestamp = strtotime($this->time_spent);
        return date('F d, Y', $timestamp);
    }
}
