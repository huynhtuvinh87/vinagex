<?php

// events.php file

use yii\base\Event;
function calculateLength(Event $event) {
    echo strlen($event->data);
}

function sendmail(Event $event) {
    var_dump($event->data);
}
