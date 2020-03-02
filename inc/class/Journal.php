<?php
class Journal
{
    // private $title;
    // private $date;
    // private $time_spent;
    // private $learn;
    // private $resources;
    private $data = array();
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
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
    public function createNewEntry()
    {
        if ($this->checkExist(['title', 'date', 'time_spent', 'learned'])) {
            $sql = 'INSERT INTO entries (title, date, time_spent, learned, resources)
                    VALUES (:title, :date, :time_spent, :learned, :resources)';
            return $this->db->prepare($sql)->execute($this->data);
        }
    }
}
