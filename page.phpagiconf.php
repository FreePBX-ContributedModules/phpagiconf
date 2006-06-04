<?php /* $Id:$ */
// Xavier Ourciere xourciere[at]propolys[dot]com
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.

if(array_key_exists('manager', $active_modules)) {
$manrevision=explode(".",$active_modules['manager']['version']);
if ($manrevision[2] >= 4) {

isset($_REQUEST['action'])?$action = $_REQUEST['action']:$action='';
isset($_REQUEST['phpagiid'])?$phpagiid = $_REQUEST['phpagiid']:$phpagiid='';
$dispnum = "phpagiconf"; //used for switch on config.php

switch ($action) {
	case "edit":
		phpagiconf_update($_REQUEST['id'], $_REQUEST['debug'], $_REQUEST['error_handler'],
				$_REQUEST['err_email'], $_REQUEST['hostname'], $_REQUEST['tempdir'],
				$_REQUEST['festival_text2wave'], $_REQUEST['asman_server'], $_REQUEST['asman_port'],
				$_REQUEST['asmanager'], $_REQUEST['cepstral_swift'],
				$_REQUEST['cepstral_voice'], $_REQUEST['setuid'], $_REQUEST['basedir']);
		phpagiconf_gen_conf();
		needreload();
	break;
	case "add":
		phpagiconf_add($_REQUEST['debug'], $_REQUEST['error_handler'],
				$_REQUEST['err_email'], $_REQUEST['hostname'], $_REQUEST['tempdir'],
				$_REQUEST['festival_text2wave'], $_REQUEST['asman_server'], $_REQUEST['asman_port'],
				$_REQUEST['asmanager'], $_REQUEST['cepstral_swift'],
				$_REQUEST['cepstral_voice'], $_REQUEST['setuid'], $_REQUEST['basedir']);
		phpagiconf_gen_conf();
		needreload();
	break;
}

//this function needs to be available to other modules (those that use goto destinations)
//therefore we put it in globalfunctions.php
$phpagiconf = phpagiconf_get();
?>

</div>

<!-- right side menu -->
<div class="rnav">
</div>


<div class="content">
<?php
//get details for this phpagiconf text
$thisConfig = phpagiconf_get();
//create variables
if (isset($thisConfig)) {
extract($thisConfig);
}
?>
	<h2><?php echo _("PHPAGI Config:"); ?></h2>
	<form autocomplete="on" name="editAGIConf" action="config.php?type=tool&amp;display=phpagiconf" method="post" onsubmit="return editAGIConf_submit();">
	<input type="hidden" name="display" value="<?php echo $dispnum?>">
	<input type="hidden" name="action" value="<?php echo (isset($thisConfig) ? 'edit' : 'add') ?>">
	<table>
	<tr><td colspan="2"><h5><?php echo _("Main config:"); ?><hr></h5></td></tr>
	<tr><td><input type="hidden" name="id" value="<?php echo $phpagiid; ?>"></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Debug:")?><span><?php echo _("Enable PHPAGI debugging.")?></span></a></td>
		<td><select name="debug">
			<option value="0" <?php echo (($debug==0) ? 'selected="selected"' : ''); ?>><?php echo _("false"); ?>
			<option value="1" <?php echo (($debug==1) ? 'selected="selected"' : ''); ?>><?php echo _("true"); ?>
		</select></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Error handler:")?><span><?php echo _("Use internal error handler.")?></span></a></td>
		<td><select name="error_handler">
			<option value="0" <?php echo (($error_handler==0) ? 'selected="selected"' : ''); ?>><?php echo _("false");?>
			<option value="1" <?php echo (($error_handler==1) ? 'selected="selected"' : ''); ?>><?php echo _("true");?>
		</select></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Mail errors to:")?><span><?php echo _("Email where the errors will be sent.")?></span></a></td>
		<td><input type="text" name="err_email" value="<?php echo (isset($err_email) ? $err_email : 'admin@example.com'); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Hostname of the server:")?><span><?php echo _("Hostname of this server.")?></span></a></td>
		<td><input type="text" name="hostname" value="<?php echo (isset($hostname) ? $hostname : 'freepbx.example.com'); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Temporary directory:")?><span><?php echo _("Temporary directory for storing temporary output.")?></span></a></td>
		<td><input size=40 type="text" name="tempdir" value="<?php echo (isset($tempdir) ? $tempdir : '/tmp'); ?>"></td>
	</tr>
	<tr><td colspan="2"><h5><?php echo _("Festival config:"); ?><hr></h5></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Path to text2wave:")?><span><?php echo _("Path to text2wave binary.")?></span></a></td>
		<td><input type="text" name="festival_text2wave" value="<?php echo (isset($festival_text2wave) ? $festival_text2wave : '/usr/bin/text2wave'); ?>"></td>
	</tr>
	<tr><td colspan="2"><h5><?php echo _("Asterisk API settings:"); ?><hr></h5></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Server:")?><span><?php echo _("Server to connect to.")?></span></a></td>
		<td><input type="text" name="asman_server" value="<?php echo (isset($asman_server) ? $asman_server : 'localhost'); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Port:")?><span><?php echo _("Port to connect to manager.")?></span></a></td>
		<td><input type="text" name="asman_port" value="<?php echo (isset($asman_port) ? $asman_port : '5038'); ?>"></td>
	</tr>
<?php echo $module_hook->hookHtml; ?>
	<tr><td colspan="2"><h5><?php echo _("Fast AGI config:"); ?><hr></h5></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("setuid:")?><span><?php echo _("Drop privileges to owner of script.")?></span></a></td>
		<td><select name="setuid">
			<option value="0" <?php echo (($setuid==0) ? 'selected="selected"' : ''); ?>><?php echo _("false");?>
			<option value="1" <?php echo (($setuid==1) ? 'selected="selected"' : ''); ?>><?php echo _("true");?>
		</select></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Basedir:")?><span><?php echo _("Path to AGI scripts folder.")?></span></a></td>
		<td><input size=40 type="text" name="basedir" value="<?php echo (isset($basedir) ? $basedir : '/var/lib/asterisk/agi-bin/'); ?>"></td>
	</tr>
	<tr><td colspan="2"><h5><?php echo _("Cepstral config:"); ?><hr></h5></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Swift path:")?><span><?php echo _("Path to cepstral TTS binary.")?></span></a></td>
		<td><input type="text" name="cepstral_swift" value="<?php echo (isset($cepstral_swift) ? $cepstral_swift : '/opt/swift/bin/swift'); ?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Cepstral voice:")?><span><?php echo _("TTS Voice used.")?></span></a></td>
		<td><input type="text" name="cepstral_voice" value="<?php echo (isset($cepstral_voice) ? $cepstral_voice : 'David'); ?>"></td>
	</tr>

	<tr><td colspan="2"><br><h6><input name="Submit" type="submit" value="<?php echo _("Submit Changes") ?>"></h6></td></tr>

	</table>
<script language="javascript">
<!--

var theForm = document.editAGIConf;

if (theForm.description.value == "") {
	theForm.name.focus();
} else {
	theForm.festtext.focus();
}

function editAGIConf_submit()
{
/*
 * TODO: Check input
*/
	return true;
}

//-->
</script>
</form>
<?php } else { ?>
</div>
<div class="rnav">
</div>
<div class="content">
<h2><?php echo _("To use this module you need the Asterisk API module version >= 1.0.4"); ?></h2>
</div>
<?php } } else { ?>
</div>
<div class="rnav">
</div>
<div class="content">
<h2><?php echo _("To use this module you need to download and enable Asterisk API module."); ?></h2>
</div>
<?php } ?>
