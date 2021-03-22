<?php
define('USERS_DB', dirname(__FILE__).'/users.txt');

/**
 * Checks input against users.txt and updates:
 * time stamp, wrong attempts, locked status
 * based on correct/incorrect matches.
 *
 * @param string $username
 * @param string $password
 * @return int 0: not match | 1: matches | 2: locked | >=3: error
 */
function checkHash(string $username, string $password): int {
    $state = 3;
    if (strlen(rtrim($username)) == 0 || strlen(rtrim($password)) == 0 ) return 0;
    if (!file_exists(USERS_DB)) return $state;

    $pwHash = md5($password);
    $fileHandel = fopen(USERS_DB, 'r+');
    $usersArr = file(USERS_DB);
    $outArr = Array();
    if ($usersArr == false) return $state;

    foreach($usersArr as $user) {
        // row [username, pwHash, loginTimeStamp, wrongPwAttempts, accLocked]
        $row = preg_split('/,/', rtrim($user));

        if ($state >= 3 && $row[0] == $username) {
            if ($row[4] == '1') $state = 2;
            else if ($row[1] == $pwHash) {
                $row[2] = time();
                $row[3] = 0;
                $state = 1;
            }
            else {
                if ((int)$row[3] < 3) $row[3]++;
                else $row[4] = 1;
                $state = 0;
            }
        }
        $outArr[] = implode(',', $row);
    }

    if (count($usersArr) == count($outArr))
        fwrite($fileHandel, implode("\n", $outArr));

    if ($state == 3) $state = 0;
    return $state;
}
