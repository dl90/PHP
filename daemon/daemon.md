# PHP Daemon

```text
                ,        ,
               /(        )`
               \ \___   / |
               /- _  `-/  '
              (/\/ \ \   /\
              / /   | `    \
              O O   ) /    |
              `-^--'`<     '
             (_.)  _  )   /
              `.___/`    /
                `-----' /
   <----.     __ / __   \
   <----|====O)))==) \) /====|
   <----'    `--' `.__,' \
                |        |
                 \       /       /\
            ______( (_  / \______/
          ,'  ,-----'   |
          `--{__________)
```

## What is a Daemon

A daemon is a program that runs independently in the background.

These processes typically end with a d (eg: httpd) and includes startup processes such as launchd (Mac), systemd (Linux), and smss.exe/winlogon.exe (Windows). Daemons and cron-jobs do similar things but are different, namely continuously running vs periodic execution.

## Basic Idea

```php
<?php

/* Remove the execution time limit */
set_time_limit(0);

/* Iteration interval in seconds */
$sleep_time = 5;

echos('started\n', 'green');

while (TRUE)
{
   /* Sleep for the iteration interval */
   sleep($sleep_time);

   /* Print the time (to the console) */
   echo 'Time: ' . date('H:i:s') . '\n';
}
```

But this ties up the terminal, to actually make it be able to spawn a daemon child process, we would have to use php's process control aka [pcntl](https://www.php.net/manual/en/book.pcntl.php).

Unfortunately u can not install pcntl on windows ['Currently, this module will not function on non-Unix platforms (Windows).'](https://www.php.net/manual/en/pcntl.installation.php).

## Daemon

```php
<?php

if (!function_exists('pcntl_fork')) die('PCNTL functions not available on this PHP installation');

set_time_limit(0);

// parent gets the child PID and child gets 0
$pid = pcntl_fork();

if ($pid < 0) {
  print('fork failed');
  exit(1);
}

if ($pid > 0) {
  echo "daemon process started\n";

  // Only the parent will know the PID. Kids aren't self-aware
  print 'Parent : ' . getmypid() . ' exiting\n';
  exit;
}

// detached child process, do whatever
print 'Child process: ' . getmypid() . 'starting\n';

$sleep_time = 5;
$counter = 0;
$file = fopen('data.txt', 'a');

while ($counter < 100) {
  sleep($sleep_time);
  fwrite($file, 'Time: '. date('H:i:s') . '\n');
}

fclose($file);
exit;

```
