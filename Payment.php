<?php
class Payment
{
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function pay()
    {
        Bank::deposit($this->employee->getSalary());//this is assuming we have a bank object that transacts with an API like braintree or stripe
    }

}
?>
