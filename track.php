<?php

$input_stream = json_decode(file_get_contents('php://input'), true);

if (array_key_exists('visitor_id', $input_stream)) {
    echo 'evotigana '.$input_stream['visitor_id'];
}
