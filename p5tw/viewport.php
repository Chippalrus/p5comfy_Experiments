<?php
if( array_key_exists( 'box', $_GET ) )
{
	$gSandbox = $_GET[ 'box' ];
	switch( $gSandbox )
	{
		case 'test':		require_once __DIR__ . '/jes_ssu/song.php';		break;	
		case 'spellslot':	require_once __DIR__ . '/jes_ssu/cover.php';	break;
		default:			require_once __DIR__ . '/index.html';			break;
	}
} else { require_once __DIR__ . '/index.html'; }
?>