<html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1">
<title> 5th Level Spell Slot </title><meta name="robots" content="noindex, nofollow">
<style>body {
	margin: 0;
	background-color: #000;
	color: #fff;
	font-family: Monospace;
	font-size: 13px;
	line-height: 24px;
	overscroll-behavior: none;
}</style></head><body>
<div id="container">
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.min.js"></script>
<!--script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.sound.js"></script-->
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.play.js"></script>
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.speech.js"></script>
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/comfy.min.js"></script>
<script type="text/javascript">
// Canvas Size
var m_iCWidth	=	360;
var m_iCHeight	=	360;
// Microphone Source
var m_iDevice	= 6;
// DO NOT CHANGE THESE
var m_Microphone, m_fVolume, m_FFT;
var m_Timer = 0;
var m_TimerTalk = 0;

var m_TTS;
var m_SR;
var m_SRText = '';

// Image Scales
var	m_fScale		= 	0.326;	//	0.65;
var m_iWidth		=	360;	//	718;
var m_iHeight		=	360;
var m_fPosX			=	m_iWidth / 2;
var m_fPosY			=	m_iHeight / 2;

const	EAnimList	=	Object.freeze(	{ "OUTLINE"				:0
										, "HEAD"				:1
										, "BODY"				:2
										, "BROWS"				:3
										, "EYES"				:4
										, "MOUTH"				:5
										, "ARM_L"				:6
										, "ARM_R"				:7
										, "FEET"				:8
										, "MAX"					:9	// MAX = NONE
										} );

var m_AnimGroup	=	[];
var m_AnimBlinkSprite, m_AnimTalkSprite;
var m_AnimBlink	=	[];
var m_BlinkAnimations	=	[ 'blink_once'
							, 'blink_once'
							, 'blink_once'
							, 'blink_once'
							, 'blink_once'
							, 'blink_twice'
							];
							
const	EEvent		=	Object.freeze(	{ "HOSTED"				:0
										, "RAIDED"				:1
										, "CHEER"				:2
										, "SUB"					:3
										, "RESUBB"				:4
										, "GIFT_SUB"			:5
										, "GIFT_MYSTERY"		:6
										, "GIFT_CONTINUED"		:7
										, "CHAT"				:8
										, "COMMAND"				:9
										, "MAX"					:10	// MAX = NONE
										} );
										
const	EEventTimer	=	Object.freeze(	{ "HOSTED"				:5000
										, "RAIDED"				:6000
										, "CHEER"				:5000
										, "SUB"					:6000
										, "RESUBB"				:6000
										, "GIFT_SUB"			:6000
										, "GIFT_MYSTERY"		:6000
										, "GIFT_CONTINUED"		:5000
										, "CHAT"				:4000
										, "COMMAND"				:4000
										, "FOLLOWED"			:4000
										, "DONATED"				:4000
										, "MAX"					:0	// MAX = 0 Seconds
										} );

var m_Events		=	[];	

function SpeechEnded(){ m_TTS.stop(); }

function preload()
{
//	m_SR					=	new p5.SpeechRec( 'en-UK' );
//	m_SR					=	new p5.SpeechRec( 'zh-TW' );
//	m_SR.onResult 			=	ShowResult();
//	m_SR.continuous		=	true;
//	m_SR.interimResults	=	true;
	
	m_AnimBlink[ 0 ] = loadAnimation( '/imgs/1104/blinking/00.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/08.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/00.png'
									);
									
	m_AnimBlink[ 1 ] = loadAnimation( '/imgs/1104/blinking/00.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/08.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/00.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/08.png'
									, '/imgs/1104/blinking/07.png'
									, '/imgs/1104/blinking/06.png'
									, '/imgs/1104/blinking/05.png'
									, '/imgs/1104/blinking/04.png'
									, '/imgs/1104/blinking/03.png'
									, '/imgs/1104/blinking/02.png'
									, '/imgs/1104/blinking/01.png'
									, '/imgs/1104/blinking/00.png'
									);
}

function SourceSetup( deviceList )
{
	//if( deviceList.length > 0 )
	//{
		//m_Microphone.setSource( m_iDevice );
	//	m_Microphone.setSource( -1 );
	//}
}

function setup()
{
		createCanvas( m_iCWidth, m_iCHeight );			//	Draw Canvas size
		//m_Microphone	=	new p5.AudioIn();			//	Listen for Microphone ( Default Microphone )
		//m_Microphone.getSources( SourceSetup );
		//m_Microphone.start();
		
		//m_FFT	=	new p5.FFT();
		//m_FFT.setInput( m_Microphone );
		
		m_TTS			=	new p5.Speech( 'Google UK English Female' );
		/*
			.setLang( 'en-UK' );
			.setVoice();
			Google UK English Female
			Google 國語（臺灣）
			Google 한국의
			Microsoft Hazel Desktop - English (Great Britain)
			Microsoft Heami Desktop - Korean
			Microsoft Hanhan Desktop - Chinese (Taiwan)
		*/
//		m_SR.start();
		
		// Outline ( Layer 0 )
		m_AnimGroup[ EAnimList.BODY ] = createSprite( m_fPosX, m_fPosY ); 
		m_AnimGroup[ EAnimList.BODY ].addAnimation
		( 'static'
		, '/imgs/1104/outline.png'
		);
		m_AnimGroup[ EAnimList.BODY ].scale = m_fScale;
		m_AnimGroup[ EAnimList.BODY ].animation.stop();
		// Body
		m_AnimGroup[ EAnimList.BODY ] = createSprite( m_fPosX, m_fPosY ); 
		m_AnimGroup[ EAnimList.BODY ].addAnimation
		( 'static'
		, '/imgs/1104/face/body.png'
		);
		m_AnimGroup[ EAnimList.BODY ].scale = m_fScale;
		m_AnimGroup[ EAnimList.BODY ].animation.stop();
		// Head
		m_AnimGroup[ EAnimList.HEAD ] = createSprite( m_fPosX, m_fPosY );	// 704/2 = 352 
		m_AnimGroup[ EAnimList.HEAD ].addAnimation
		( 'static'
		, '/imgs/1104/face/headS.png'
		);
		m_AnimGroup[ EAnimList.HEAD ].scale = m_fScale;
		m_AnimGroup[ EAnimList.HEAD ].animation.stop();
		// Brows
		m_AnimGroup[ EAnimList.BROWS ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.BROWS ].addAnimation
		( 'static'
		, '/imgs/1104/face/brows.png'
		);
		m_AnimGroup[ EAnimList.BROWS ].scale = m_fScale;
		m_AnimGroup[ EAnimList.BROWS ].animation.stop();
		// Arm Left
		m_AnimGroup[ EAnimList.ARM_L ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.ARM_L ].addAnimation
		( 'static'
		, '/imgs/1104/arms/LL_base.png'
		);
		m_AnimGroup[ EAnimList.ARM_L ].addAnimation
		( 'wave'
		, '/imgs/1104/arms/L_00.png'
		, '/imgs/1104/arms/L_01.png'
		, '/imgs/1104/arms/L_02.png'
		, '/imgs/1104/arms/L_03.png'
		, '/imgs/1104/arms/L_04.png'
		, '/imgs/1104/arms/L_03.png'
		, '/imgs/1104/arms/L_02.png'
		, '/imgs/1104/arms/L_01.png'
		, '/imgs/1104/arms/L_00.png'
		);
		m_AnimGroup[ EAnimList.ARM_L ].addAnimation
		( 'hmm'
		, '/imgs/1104/arms/LL_shock.png'
		);
		m_AnimGroup[ EAnimList.ARM_L ].scale = m_fScale;
		m_AnimGroup[ EAnimList.ARM_L ].animation.stop();
		m_AnimGroup[ EAnimList.ARM_L ].animation.frameDelay = 1;
		// Arm Right
		m_AnimGroup[ EAnimList.ARM_R ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.ARM_R ].addAnimation
		( 'static'
		, '/imgs/1104/arms/RR_base.png'
		);
		m_AnimGroup[ EAnimList.ARM_R ].addAnimation
		( 'wave'
		, '/imgs/1104/arms/R_00.png'
		, '/imgs/1104/arms/R_01.png'
		, '/imgs/1104/arms/R_02.png'
		, '/imgs/1104/arms/R_03.png'
		, '/imgs/1104/arms/R_04.png'
		, '/imgs/1104/arms/R_03.png'
		, '/imgs/1104/arms/R_02.png'
		, '/imgs/1104/arms/R_01.png'
		, '/imgs/1104/arms/R_00.png'
		);
		m_AnimGroup[ EAnimList.ARM_R ].addAnimation
		( 'hmm'
		, '/imgs/1104/arms/RR_shock.png'
		);
		m_AnimGroup[ EAnimList.ARM_R ].scale = m_fScale;
		m_AnimGroup[ EAnimList.ARM_R ].animation.stop();
		m_AnimGroup[ EAnimList.ARM_R ].animation.frameDelay = 1;
		// Feet
		m_AnimGroup[ EAnimList.FEET ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.FEET ].addAnimation
		( 'static'
		, '/imgs/1104/face/feet.png'
		);
		m_AnimGroup[ EAnimList.FEET ].scale = m_fScale;
		m_AnimGroup[ EAnimList.FEET ].animation.stop();

		for( var i = 0; i < m_AnimBlink.length; ++i )
		{
			m_AnimBlink[ i ].frameDelay = 2;
		}
		m_AnimGroup[ EAnimList.EYES ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.EYES ].addAnimation( 'nn', '/imgs/1104/eyes/nn.png' );
		m_AnimGroup[ EAnimList.EYES ].addAnimation( 'uu', '/imgs/1104/eyes/uu.png' );
		m_AnimGroup[ EAnimList.EYES ].addAnimation( 'oo', '/imgs/1104/eyes/oo.png' );
		m_AnimGroup[ EAnimList.EYES ].addAnimation( 'blink_once', m_AnimBlink[ 0 ] );
		m_AnimGroup[ EAnimList.EYES ].addAnimation( 'blink_twice', m_AnimBlink[ 1 ] );
		m_AnimGroup[ EAnimList.EYES ].animation.stop();
		m_AnimGroup[ EAnimList.EYES ].animation.rewind();
		m_AnimGroup[ EAnimList.EYES ].scale = m_fScale;
		
		m_AnimGroup[ EAnimList.MOUTH ] = createSprite( m_fPosX, m_fPosY );
		m_AnimGroup[ EAnimList.MOUTH ].addAnimation( 'DEFAULT', '/imgs/1104/mouth/talking/00.png' );
		m_AnimGroup[ EAnimList.MOUTH ].addAnimation
		( 'TALKING'
		, '/imgs/1104/mouth/talking/00.png'
		, '/imgs/1104/mouth/talking/01.png'
		, '/imgs/1104/mouth/talking/02.png'
		, '/imgs/1104/mouth/talking/03.png'
		, '/imgs/1104/mouth/talking/04.png'
		, '/imgs/1104/mouth/talking/05.png'
		, '/imgs/1104/mouth/talking/04.png'
		, '/imgs/1104/mouth/talking/03.png'
		, '/imgs/1104/mouth/talking/02.png'
		, '/imgs/1104/mouth/talking/01.png'
		, '/imgs/1104/mouth/talking/00.png'
		);
		m_AnimGroup[ EAnimList.MOUTH ].animation.frameDelay = 1;
		m_AnimGroup[ EAnimList.MOUTH ].scale = m_fScale;
}

ComfyJS.onHosted = ( user, viewers, autohost, extra ) =>
{
	m_Events[ 0 ] = EEvent.HOSTED;
	m_Events[ 1 ] = millis() + EEventTimer.HOSTED;
	
	m_Events[ 2 ] = user;
	m_Events[ 3 ] = viewers;
	m_Events[ 4 ] = autohost;
}
ComfyJS.onRaid = ( user, viewers, extra ) =>
{
	m_Events[ 0 ] = EEvent.RAIDED;
	m_Events[ 1 ] = millis() + EEventTimer.RAIDED;
	
	m_Events[ 2 ] = user;
	m_Events[ 3 ] = viewers;
}
ComfyJS.onCheer = ( user, message, bits, flags, extra ) =>
{
	m_Events[ 0 ] = EEvent.CHEER;
	m_Events[ 1 ] = millis() + EEventTimer.CHEER;
	
	m_Events[ 2 ] = user;
	m_Events[ 2 ] = message;
	m_Events[ 4 ] = bits;
	m_Events[ 5 ] = flags;
}
ComfyJS.onSub = ( user, message, subTierInfo, extra ) =>
{
	m_Events[ 0 ] = EEvent.SUB;
	m_Events[ 1 ] = millis() + EEventTimer.SUB;
	
	m_Events[ 2 ] = user;
	m_Events[ 3 ] = message;
	m_Events[ 4 ] = subTierInfo;
}
ComfyJS.onResub = ( user, message, streamMonths, cumulativeMonths, subTierInfo, extra ) =>
{
	m_Events[ 0 ] = EEvent.RESUBB;
	m_Events[ 1 ] = millis() + EEventTimer.RESUBB;
	
	m_Events[ 2 ] = user;
	m_Events[ 3 ] = message;
	m_Events[ 4 ] = streamMonths;
	m_Events[ 5 ] = cumulativeMonths;
	m_Events[ 6 ] = subTierInfo;
}
ComfyJS.onSubGift = ( gifterUser, streakMonths, recipientUser, senderCount, subTierInfo, extra ) =>
{
	m_Events[ 0 ] = EEvent.GIFT_SUB;
	m_Events[ 1 ] = millis() + EEventTimer.GIFT_SUB;
	
	m_Events[ 2 ] = gifterUser;
	m_Events[ 3 ] = streakMonths;
	m_Events[ 4 ] = recipientUser;
	m_Events[ 5 ] = senderCount;
	m_Events[ 6 ] = subTierInfo;
}
ComfyJS.onSubMysteryGift = ( gifterUser, numbOfSubs, senderCount, subTierInfo, extra ) =>
{
	m_Events[ 0 ] = EEvent.GIFT_MYSTERY;
	m_Events[ 1 ] = millis() + EEventTimer.GIFT_MYSTERY;
	
	m_Events[ 2 ] = gifterUser;
	m_Events[ 3 ] = numbOfSubs;
	m_Events[ 4 ] = senderCount;
	m_Events[ 5 ] = subTierInfo;
}
ComfyJS.onGiftSubContinue = ( user, sender, extra ) =>
{
	m_Events[ 0 ] = EEvent.GIFT_CONTINUED;
	m_Events[ 1 ] = millis() + EEventTimer.GIFT_CONTINUED;
	
	m_Events[ 2 ] = user;
	m_Events[ 3 ] = sender;
}
ComfyJS.onChat = ( user, message, flags, self, extra ) =>
{
	if( user === 'Streamlabs' )
	{
		m_Events[ 0 ] = EEvent.CHAT;
		
		if( message.includes( "followed" ) )
		{
			m_Events[ 1 ] = millis() + EEventTimer.FOLLOWED;
		}
		else if( message.includes( "donated" ) )
		{
			m_Events[ 1 ] = millis() + EEventTimer.DONATED;
		}
		else
		{
			m_Events[ 1 ] = millis() + 4000;
		}
		
		m_Events[ 2 ] = user;
		m_Events[ 3 ] = message;
		m_Events[ 4 ] = flags;
	}
}
ComfyJS.onCommand = ( user, command, message, flags, extra ) =>
{
	if( flags.broadcaster && command === "test_command" )
	{
		m_Events[ 0 ] = EEvent.COMMAND;
		m_Events[ 1 ] = millis() + EEventTimer.COMMAND;
		
		m_Events[ 2 ] = user;
		m_Events[ 3 ] = command;
		m_Events[ 4 ] = message;
		m_Events[ 5 ] = flags;
	}
}
ComfyJS.Init( "chippalrus" );

function ClearParams()
{
	for( var i = 0; i < m_Events.length; ++i )
	{
		switch( i )
		{
			case 0:		m_Events[ i ]	= EEvent.MAX;	break;
			case 1:		m_Events[ i ]	= 0;			break;
			default:	m_Events[ i ]	= null;			break;
		}
	}
}

function TwitchEvents( iWidth, iHeight )
{
	if( !( m_Events[ 0 ] === undefined ) || m_Events.length > 0 )
	{
		if( millis() >= m_Events[ 1 ] )
		{
			ClearParams();
			m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'blink_once' );
			m_AnimGroup[ EAnimList.EYES ].animation.stop();
			m_AnimGroup[ EAnimList.EYES ].animation.rewind();
			
			m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'static' );
			m_AnimGroup[ EAnimList.ARM_L ].animation.stop();
			m_AnimGroup[ EAnimList.ARM_L ].animation.rewind();
			
			m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'static' );
			m_AnimGroup[ EAnimList.ARM_R ].animation.stop();
			m_AnimGroup[ EAnimList.ARM_R ].animation.rewind();
			
			m_AnimGroup[ EAnimList.BROWS ].visible = true;
		}
		else
		{
			m_AnimGroup[ EAnimList.BROWS ].visible = false;
			switch( m_Events[ 0 ] )
			{
				case 0:	//	onHosted
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'oo' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'hmm' );
				break;
				
				case 1:	//	onRaid
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'oo' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'hmm' );
					m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'hmm' );
				break;
				
				case 2:	//	onCheer ( Bits )
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_L ].animation.play();
				break;
				
				case 3:	//	onSub
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_L ].animation.play();
				break;
				
				case 4:	//	onResub
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_R ].animation.play();
					m_AnimGroup[ EAnimList.ARM_R ].animation.play();
				break;
				
				case 5:	//	onSubGift
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_L ].animation.play();
				break;
				
				case 6:	//	onSubMysteryGift
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_L ].animation.play();
				break;
				
				case 7:	//	onGiftSubContinue
					m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
					m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'wave' );
					m_AnimGroup[ EAnimList.ARM_R ].animation.play();
					m_AnimGroup[ EAnimList.ARM_R ].animation.play();
				break;
				
				case 8:	//	onChat ( Streamlabs Followed/Donated Alert )
					if( m_Events[ 3 ].includes( "followed" ) )
					{
						m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
						m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
						m_AnimGroup[ EAnimList.ARM_L ].animation.play();
						
						m_TTS.speak( m_Events[ 3 ] );
						m_TTS.onEnd		=	SpeechEnded;
					}
					else if( m_Events[ 3 ].includes( "donated" ) )
					{
						m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
						m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
						m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'wave' );
						m_AnimGroup[ EAnimList.ARM_R ].animation.play();
						m_AnimGroup[ EAnimList.ARM_R ].animation.play();
					}
					else if( m_Events[ 3 ].includes( "raided" ) )
					{
						m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'oo' );
						m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'hmm' );
						m_AnimGroup[ EAnimList.ARM_R ].changeAnimation( 'hmm' );
					}
					else if( m_Events[ 3 ].includes( "hosted" ) )
					{
						m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'oo' );
						m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'hmm' );
					}
					else if( m_Events[ 3 ].includes( "bits" ) )
					{
						m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
						m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
						m_AnimGroup[ EAnimList.ARM_L ].animation.play();
					}
				//	text( m_Events[ 2 ] + ': ' + m_Events[ 3 ], 540, 20 );
				break;
				
				case 9:	//	onCommand
					switch( m_Events[ 3 ] ){default:break;}
				break;
				
				default:break;
			}
		}
	}
}

function ChromaKey( colourFill, iWidth, iHeight )
{
	fill( colourFill );
	noStroke();
	rect( 0, 0, iWidth, iHeight );
}

function HSBLine( iX, iY, iWidth, iHeight, cRGB )
{
/*	translate( iX, iY );
	ChromaKey( color( 255, 0, 255 ), 500, 150 );

	var spectrum	=	m_FFT.analyze();
	noStroke();
	for( i = 0; i < 250; ++i )
	{
		var amp = spectrum[ i ];
		var y =  map( amp, 0, ( iHeight * 2 ) + 10, iHeight / 2, 0 );
		var y2 =  map( amp, 0, -( iHeight * 2 ) + 10, -iHeight / 2, 0 );

	//	console.log( i, amp, y, scale );
		
	//	translate( 0, height - 180 );
		//	colorMode( HSB, 255 );
				stroke( cRGB );
				strokeWeight( 2 );
				line( ( iWidth / 2 ) + i, iHeight / 2, ( iWidth / 2 ) + i, y );
				line( ( iWidth / 2 ) - i, y, ( iWidth / 2 ) - i, iHeight / 2 );
				
				line( ( iWidth / 2 ) + i, iHeight / 2, ( iWidth / 2 ) + i, -y2 );
				line( ( iWidth / 2 ) - i, -y2, ( iWidth / 2 ) - i, iHeight / 2 );
				strokeWeight( 0 );
				noStroke();
		//	colorMode( RGB );
	//	translate( 0, -( height - 180 ) );
	}
	translate( -iX, -iY );*/
}

function Border( iX, iY, iSize )
{
	var resolution = 255;
	//var spectrum	=	m_FFT.analyze();
	//var specInter	=	floor( spectrum.length/resolution );
	//var reducedSpec	=	[];
	
	for( var i = 0; i < resolution; ++i )
	{
	//	reducedSpec.push( spectrum[ i * specInter ] );
	}

	noStroke();
	fill( 116, 127, 141 );
	rect( iX, iY, iSize, iSize );
	for( i = 0; i < resolution; ++i )
	{
	//	var amp = reducedSpec[ i ];
	//	var scale = map( reducedSpec[ i ], 0, 255, 0, 255 );
	//	var y =  map( amp, 0, resolution, 0, 255 );

	//	console.log( i, amp, y, scale );
			colorMode( HSB );
	//	colorMode( HSL );
	//			var c = color( 0, 0, scale, 1 );
	//			fill( c );
	//			rect( iX, iY, iSize, iSize );
	//		stroke( m_Microphone.getLevel() * 100, 100, 100, 0.1 );
			colorMode( RGB );
	}
	colorMode( HSB, 255 );
	colorMode( RGB );
}

function VisualFeedBack( iX, iY, iWidth, iHeight, iTextOffset )
{
	var iWidthSize = iWidth / 2;
//	translate( iX, iY );
	noStroke();
	fill( 255 );
	rect( iX, iY, iWidth, iHeight );
	fill( 0 );
	text( 'Volume: ' + m_fVolume, iX + 2, iTextOffset );
//	translate( -iX, -iY );
}

function AnimTalk( iWidth, iHeight )
{
	noStroke();
	fill( 0 );
//	text( 'Result: ' + m_SR.resultString, 720, 700 );
//	text( 'Recognised: ' + m_SR.resultValue, 720, 710 );
	
	//m_fVolume	=	m_Microphone.getLevel();
	m_AnimGroup[ EAnimList.MOUTH ].animation.looping = true;
	/*if( m_fVolume >= 0.01900 )			//	If Volume threshold ( Min 0 ~ 1 Max )
	{
		m_AnimGroup[ EAnimList.MOUTH ].changeAnimation( 'TALKING' );
		m_AnimGroup[ EAnimList.MOUTH ].animation.play();
	}
	else
	{
	//	m_AnimGroup[ EAnimList.MOUTH ].animation.stop();
		m_AnimGroup[ EAnimList.MOUTH ].animation.rewind();
		m_AnimGroup[ EAnimList.MOUTH ].changeAnimation( 'DEFAULT' );
	}*/
	if( millis() >= m_TimerTalk )
	{
		m_TimerTalk = millis() + random( 2300, 5000 );
		m_AnimGroup[ EAnimList.MOUTH ].changeAnimation( 'TALKING' );
		m_AnimGroup[ EAnimList.MOUTH ].animation.play();
	
		if( m_AnimGroup[ EAnimList.MOUTH ].animation.getLastFrame() == m_AnimGroup[ EAnimList.MOUTH ].animation.getFrame() )
		{
			m_AnimGroup[ EAnimList.MOUTH ].changeAnimation( 'DEFAULT' );
		}
	}
}

function AnimTest( iWidth, iHeight )
{
	fill( 0, 151, 142 );
	rect( 0, 0, iWidth, iHeight );

	m_AnimGroup[ EAnimList.EYES ].visible = true;
	m_AnimGroup[ EAnimList.EYES ].animation.looping = false;

	if( millis() >= m_Timer )
	{
		m_Timer = millis() + random( 3000, 15000 );
		m_AnimGroup[ EAnimList.EYES ].changeAnimation( random( m_BlinkAnimations ) );
		m_AnimGroup[ EAnimList.EYES ].animation.play();
		m_AnimGroup[ EAnimList.EYES ].animation.rewind();
	}
}

function draw()
{
	background( 200 );
//	HSBLine( m_iWidth + 1, 21, 500, 150, color( 0, 151, 142 ) );
	Border( 500, height - 20, 20 );
	AnimTest( m_iWidth, m_iHeight );
	TwitchEvents( m_iWidth, m_iHeight );
	AnimTalk( m_iWidth, m_iHeight );
	drawSprites();
//	VisualFeedBack( 0, height - 20, 500, 20, height - 4 );
}
</script>
<script type="text/javascript">
document.getElementById("container").innerHTML = "";
</script>
</div>
</body></html>