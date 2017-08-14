<?php
/**
 * Let's assume this class can connect to the database
 */
class Employee
{
    private $employee_id;
    private $db;

    private $data = [];

    public function __construct($employee_id)
    {
        $this->employee_id = $employee_id;
        $this->db = new DB();
    }

    public function getSalary()
    {
        if ($this->paidHourly() {
            return $this->getHourlySalary();
        }
        return $this->getItemBasedSalary();
    }

    public function getHourlyrate()
    {
        return $this->getData("hourly_rate");
    }

    public function getRatePerItem()
    {
        return $this->getData("rate_per_item");
    }

    public function paidHourly()
    {
        return $this->getData("is_paid_hourly");
    }

    public function getData($field = null)
    {
        $this->setDataIfNotExists();

        if ($field) {
            return $this->data[$field];
        }
        return $this->data;
    }

    public function getItemsMade()
    {
        return $this->db->getAll("SELECT * FROM items WHERE employee_id = $this->employee_id");
    }

    public function getHoursWorked()
    {
        return $this->db->getOne("SELECT SUM(hours_worked) FROM logs WHERE employee_id=$this->employee_id");//this is assuming we already calculated the hours worked by the employee based on punchin and punchout fields in the table
    }

    private function setDataIfNotExists()
    {
        if (empty($this->data)) {
            $this->data = $this->db->getRow("SELECT * FROM employees WHERE employee_id=$this->employee_id");
        }
    }

    private function getHourlySalary()
    {
        $hours_worked = $this->getHoursWorked();
        $hourly_rate = $this->getHourlyRate();
        return $hourly_rate * $hours_worked;
    }

    private function getItemBasedSalary()
    {
        $made_items = count($this->getItemsMade());
        $rate_per_item = $this->getRatePerItem();
        return $made_items * $rate_per_item;
    }
}
?>
