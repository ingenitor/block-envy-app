<?php
$config_file = '';
$default_config_file = "config" . DIRECTORY_SEPARATOR . "blockenvy_config.json";

function usage() {
	echo "Block Envy - Minecraft Version Independence Tool - written by ingenitor\n\n";
	echo "usage: {$_SERVER['argv'][0]} -h | -v <VERSION> [-c <JSON CONFIGFILE>]\n\n";
	echo "\t-h | --help\t\t\t\tProvide this help page\n";
	echo "\t-v | --version <VERSION>\t\tSpecify version of Minecraft for code generatation, only 1.7 & 1.8 are currently supported\n";
	echo "\t-c | --config <JSON CONFIGFILE>\t\tSpecify config file location, defaults to looking in directory 'config'\n";
}

$short_opts = array(
	"h",
	"v:",
	"c:"
);
$long_opts  = array(
	"help",
	"version:",
	"config:"
);

$str_short_opts = implode("", $short_opts);

$options = getopt($str_short_opts, $long_opts);

if( empty($options) || array_key_exists('h', $options) ) {
	usage();
	die;
}

if( array_key_exists('v', $options) && !( $options['v'] == '1.7' || $options['v'] == '1.8' ) ) {
	usage();
	die;
}

if( array_key_exists('c', $options) ) {
	if( !file_exists($options['c']) ) {
		echo "\n- error opening config file {$options['c']}\n";
		die;
	} else {
		$config_file = $options['c'];
	}
} else if( !file_exists($default_config_file) ) {
	echo "\n- error opening config file {$default_config_file}\n";
	die;
} else {
	$config_file = $default_config_file;
}

$contents = trim(file_get_contents($config_file));
$contents = str_replace("\r\n","\n", $contents);	//DOS2UNIX
$contents = str_replace(  "\r","\n", $contents);	//MAC2UNIX
$config   = json_decode($contents);

var_export($config);
?>