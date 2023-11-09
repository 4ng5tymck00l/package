<?php
header('Content-Type: application/json; charset=utf-8');
http_response_code($data['response'][1]);
echo(json_encode($data['response'][0]));