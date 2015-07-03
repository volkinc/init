<?php
DEFINE('DS', DIRECTORY_SEPARATOR);
$basedir = str_replace('\\', DS, realpath(dirname(__FILE__)).DS);
echo $basedir;

include_once $basedir."ConfigParser.php";
$configFileName = $basedir."config_file/config.ini";
/*
$config = new ConfigParser($configFileName, "DEV");
echo $config->mysql;
echo "\n";
echo $config->mysql->host;
echo "\n";
echo $config->mysql->username;
echo "\n";
echo $config->mysql->password;
echo "\n";
echo $config->mysql->dbname;
echo "\n";
echo $config->logger->filePath;
echo "\n";
echo $config->logger->logFileName;
*/


$config = new ConfigParser($configFileName, "LIVE");
echo $config->mysql;
echo "\n";
echo $config->mysql->host;
echo "\n";
echo $config->mysql->username;
echo "\n";
echo $config->mysql->password;
echo "\n";
echo $config->mysql->dbname;
echo "\n";
echo $config->logger->filePath;
echo "\n";
echo $config->logger->logFileName;


