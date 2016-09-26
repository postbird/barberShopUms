<?php
// This code was created by phpMyBackupPro v.2.1 
// http://www.phpMyBackupPro.net
$_POST['db']=array("barbershopums", );
$_POST['tables']="on";
$_POST['data']="on";
$_POST['drop']="on";
$period=(3600*24)*0;
$security_key="1d20b83ace4110640474ee1a5a24ed60";
// This is the relative path to the phpMyBackupPro v.2.1 directory
@chdir("../sqlbak/");
@include("backup.php");
?>