<?php

namespace App\Models;

class Passenger
{
    public string $name;
    public string $surname;
    public string $email;
    public string $phone;
    public string $documentType;
    public string $documentNumber;
    public string $birthDate;
    public string $goSeat;
    public string $backSeat;
    public string $flightId;
    public string $age;
    public string $price;
    public string $initials;
    public function __construct($name, $surname, $age)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->age = $age;
        $this->initials = $this->getInitials($name, $surname);
    }
    private function getInitials($name, $surname): string
    {
        return strtoupper($name[0] . $surname[0]);
    }
}
