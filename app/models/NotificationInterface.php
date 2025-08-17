<?php
namespace App\Models;

interface NotificationInterface {
    public function send($message);
}