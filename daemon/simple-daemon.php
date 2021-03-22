#!/usr/bin/php
<?php

/* Remove the execution time limit */
set_time_limit(0);

/* Iteration interval in seconds */
$sleep_time = 5;

echo 'started\n';

while (TRUE)
{
   /* Sleep for the iteration interval */
   sleep($sleep_time);

   /* Print the time (to the console) */
   echo 'Time: ' . date('H:i:s') . '\n';
}
