<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 21/9/2560
 * Time: 22:37 น.
 */
$icd = 'K0520';
$i = substr($icd,0,3).".".substr($icd,3,2);
echo $i;