<?php
namespace App\Models;

class SMSNotification implements NotificationInterface {
    public function send($message) {
        // Simulate
        echo "SMS sent: $message<br>";
    }
}