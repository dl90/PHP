<?php

if (!function_exists('pcntl_fork')) die('PCNTL functions not available on this PHP installation');

set_time_limit(0);
$sleep_time = 5;

$pid = pcntl_fork(); // parent gets the child PID and child gets 0

if ($pid < 0) {
  print('fork failed');
  exit(1);
}

if ($pid > 0) { // parent process
  echo "daemon process started\n";

  // Only the parent will know the PID. Kids aren't self-aware
  print "Parent : " . getmypid() . " exiting\n";
  exit;
}

// detached child process, do whatever
print "Child : " . getmypid() . "\n";

$counter = 0;

echo 'starting\n';

$file = fopen('data.txt', 'a');
while ($counter < 100) {
  sleep($sleep_time);
  fwrite($file, 'Time: ' . date('H:i:s') . '\n');
}

fclose($file);
exit;
