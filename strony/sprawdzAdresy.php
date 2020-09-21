<?php
	$ipAddress=$_SERVER['REMOTE_ADDR'];
	$macAddr=false;

	#run the external command, break output into lines
	$arp=`arp -a $ipAddress`;
	echo $arp.'</br>';
	$arp2=`arp -a`;
	echo $arp2.'</br>';
	$lines=explode("\n", $arp);

	#look for the output line describing our IP address
	foreach($lines as $line)
	{
	   $cols=preg_split('/\s+/', trim($line));
	   if ($cols[0]==$ipAddress)
	   {
		   $macAddr=$cols[1];
	   }
	}
	echo 'Adres IP: '.$ipAddress.'</br>Adres MAC: '.$macAddr;
?>