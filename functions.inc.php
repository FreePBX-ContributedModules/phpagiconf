<?php /* $Id: $ */

function phpagiconf_gen_conf() {
	global $active_modules;

	$file = "/tmp/phpagi_".rand().".conf";
	$data = phpagiconf_get();
	$content = "[phpagi]\n";
	$content .= "debug=".($data['debug']?'true':'false')."\n";
	$content .= "error_handler=".($data['error_handler']?'true':'false')."\n";
	$content .= "admin=".$data['err_email']."\n";
	$content .= "hostname=".$data['hostname']."\n";
	$content .= "tempdir=".$data['tempdir']."\n\n";
	$content .= "[asmanager]\n";
	$content .= "server=".$data['asman_server']."\n";
	$content .= "port=".$data['asman_port']."\n";
	$content .= "username=".$data['asman_user']."\n";
	$content .= "secret=".$data['asman_secret']."\n\n";
	$content .= "[fastagi]\n";
	$content .= "setuid=".($data['setuid']?'true':'false')."\n";
	$content .= "basedir=".$data['basedir']."\n\n";
	$content .= "[festival]\n";
	$content .= "text2wave=".$data['festival_text2wave']."\n\n";
	$content .= "[cepstral]\n";
	$content .= "swift=".$data['cepstral_swift']."\n";
	$content .= "voice=".$data['cepstral_voice']."\n";

	$fd = fopen($file, "w");
	fwrite($fd, $content);
	fclose($fd);
	if (!rename($file, "/etc/asterisk/phpagi.conf")) {
		echo "<script>javascript:alert('"._("Error writing the phpagi.conf file.")."');</script>";
	}
}

function phpagiconf_get() {
	global $db;
	global $amp_conf;
	$sql = "SELECT * FROM phpagiconf";
	$res = $db->getRow($sql, DB_FETCHMODE_ASSOC);
	return $res;
}

function phpagiconf_update($p_id, $p_debug, $p_error_handler, $p_err_email, $p_hostname, $p_tempdir, $p_festival_text2wave, $p_asman_server, $p_asman_port, $p_asmanager, $p_cepstral_swift, $p_cepstral_voice, $p_setuid, $p_basedir) {
	$asmanager = split('/', $p_asmanager);
	$results = sql("UPDATE phpagiconf SET `debug`=$p_debug, error_handler=$p_error_handler, err_email='$p_err_email', hostname='$p_hostname', tempdir='$p_tempdir', festival_text2wave='$p_festival_text2wave', asman_server='$p_asman_server', asman_port=$p_asman_port, asman_user='".$asmanager[0]."', asman_secret='".$asmanager[1]."', cepstral_swift='$p_cepstral_swift', cepstral_voice='$p_cepstral_voice', setuid=$p_setuid, basedir='$p_basedir' where phpagiid=$p_id");
}

function phpagiconf_add($p_debug, $p_error_handler, $p_err_email, $p_hostname, $p_tempdir, $p_festival_text2wave, $p_asman_server, $p_asman_port, $p_asmanager, $p_cepstral_swift, $p_cepstral_voice, $p_setuid, $p_basedir) {
	if (!empty($p_asmanager)) {
		$asmanager = split('/', $p_asmanager); 
	} else {
		$asmanager = array ($amp_conf['AMPDBUSER'], $amp_conf['AMPDBPASS']);
	}
	$results = sql("INSERT INTO phpagiconf SET `debug`=$p_debug, error_handler=$p_error_handler, err_email='$p_err_email', hostname='$p_hostname', tempdir='$p_tempdir', festival_text2wave='$p_festival_text2wave', asman_server='$p_asman_server', asman_port=$p_asman_port, asman_user='".$asmanager[0]."', asman_secret='".$asmanager[1]."', cepstral_swift='$p_cepstral_swift', cepstral_voice='$p_cepstral_voice', setuid=$p_setuid, basedir='$p_basedir'");
}

?>
