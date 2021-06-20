<html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1">
<title> 9th Level Spell Slot </title><meta name="robots" content="noindex, nofollow">
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
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.sound.js"></script>
<script language="javascript" type="text/javascript" src="http://siyo.aoinokaze.net/tw/includes/p5.play.js"></script>
<script type="text/javascript">
// Canvas Size
var m_iCWidth	=	360;
var m_iCHeight	=	360;
// DO NOT CHANGE THESE
var m_Timer = 0;
var m_TimerTalk = 0;
var m_TimerWave = 0;

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

function preload()
{
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

function setup()
{
		createCanvas( m_iCWidth, m_iCHeight );			//	Draw Canvas size
		
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

function ChromaKey( colourFill, iWidth, iHeight )
{
	fill( colourFill );
	noStroke();
	rect( 0, 0, iWidth, iHeight );
}

function AnimWave()
{
	if( millis() >= m_TimerWave )
	{
		m_TimerWave = millis() + random( 5000, 30000 );
		m_AnimGroup[ EAnimList.BROWS ].visible = false;
		m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'nn' );
		m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'wave' );
		m_AnimGroup[ EAnimList.ARM_L ].animation.play();

		if( m_AnimGroup[ EAnimList.ARM_L ].animation.getLastFrame() == m_AnimGroup[ EAnimList.ARM_L ].animation.getFrame() )
		{
			m_AnimGroup[ EAnimList.BROWS ].visible = true;
			m_AnimGroup[ EAnimList.EYES ].changeAnimation( 'blink_once' );
			m_AnimGroup[ EAnimList.ARM_L ].changeAnimation( 'static' );
		}
	}
}

function AnimTalk( iWidth, iHeight )
{
	noStroke();
	fill( 0 );

//	m_fVolume	=	m_Microphone.getLevel();
	m_AnimGroup[ EAnimList.MOUTH ].animation.looping = true;
	
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
	noFill();
	noStroke();
	background( 200 );
	AnimTest( m_iWidth, m_iHeight );
	AnimTalk( m_iWidth, m_iHeight );
	AnimWave();
	drawSprites();
}
</script>
<script type="text/javascript">
document.getElementById("container").innerHTML = "";
</script>
</div>
</body></html>