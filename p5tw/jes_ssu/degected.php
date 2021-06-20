<html><head><meta charset="utf-8"><meta http-equiv="x-ua-compatible" content="ie=edge"><meta name="viewport" content="width=device-width, initial-scale=1">
<title> 5th Level Spell Slot </title><meta name="robots" content="noindex, nofollow">
<script language="javascript" type="text/javascript" src="/includes/p5.min.js"></script>
<script language="javascript" type="text/javascript" src="/includes/p5.sound.js"></script>
<script language="javascript" type="text/javascript" src="/includes/p5.play.js"></script>
<style>body{margin:1px 0 0 1px;padding:0;}</style>
<script>
// Canvas Size
var m_iCWidth	=	600;
var m_iCHeight	=	700;
// Microphone Source
var m_iDevice		= 6;
var m_FileActive	= '/imgs/talking_.mp4';
var m_FileInactive	= '/imgs/blank2.png';
// DO NOT CHANGE THESE
var m_Microphone, m_fVolume, m_FFT;
var m_Active, m_Inactive;

function SourceSetup( deviceList )
{
	if( deviceList.length > 0 )
	{
		m_Microphone.setSource( m_iDevice );
	}
}

function setup()
{
		createCanvas( m_iCWidth, m_iCHeight );			//	Draw Canvas size
		m_Microphone	=	new p5.AudioIn();			//	Listen for Microphone ( Default Microphone )
		m_Microphone.getSources( SourceSetup );
		m_Microphone.start();
		
		m_FFT	=	new p5.FFT();
		m_FFT.setInput( m_Microphone );
		
		m_Active		=	createVideo( m_FileActive );		//	Animation when speaking
		m_Active.play();
		m_Active.loop();
		
		m_Inactive		=	loadImage( m_FileInactive );	//	Animation when NOT-speaking
}

function ChromaKey( colourFill, iWidth, iHeight )
{
	fill( colourFill );
	rect( 0, 0, iWidth, iHeight );
}

function Spectrum( bRects = false )
{
	ChromaKey( color( 255, 0, 255 ), 500, 500 );
	
	var resolution = 50;
	var backCol = color( 0 );
	var intervall;
	
	var r = 500 * 0.170;
	intervall = 1.5 * r * sin( ( TWO_PI / resolution ) / 2 );
	var spectrum	=	m_FFT.analyze();
	var specInter	=	floor( spectrum.length/resolution );
	var reducedSpec	=	[];
	
//	noStroke();
//	fill( 255 );
//	rect( 0, 0, 600, 20 );

	for( var i = 0; i < resolution; ++i )
	{
		reducedSpec.push( spectrum[ i * specInter ] );
	}
	
	for( var i = 0; i < resolution; ++i )
	{
		var scale = map( reducedSpec[ i ], 0, 160, 0, r * 0.5 );
		
		var angle = map( i, 0, resolution, 0, TWO_PI );
		//var angle = map( i, 0, resolution, -0.5, 2.5 );
		var x = r * cos( angle - PI / 2 );
		var y = r * sin( angle - PI / 2 );
		
		push();
		translate( 500 / 2 + x, 500 / 2 + y );
		rotate( angle );
		stroke( 0, 151, 142 );
		strokeWeight( 4 );
		fill( color( 0, 151, 142 ) );
		if( bRects ){	rect( -intervall / 2, -scale, intervall, scale );	}
		else{	rect( 0, -scale, 0, scale );	}
		pop();
//		backCol += reducedSpec[ i ];
	}
	
//	backCol /= resolution;
//	backCol = map( backCol, 0, 255, 255, 100 );
}

function Expressions()
{
	ChromaKey( color( 255, 0, 255 ), 500, 500 );

	var fNoise	=	m_Microphone.getLevel();
	var iWidth = 500 / 2;
	var iHeight = height / 2;

	var resolution = 50;
	var backCol = color( 0 );
	var intervall;
	
	var r = 500 * 0.170;
	intervall = 1.5 * r * sin( ( TWO_PI / resolution ) / 2 );
	var spectrum	=	m_FFT.analyze();
	var specInter	=	floor( spectrum.length/resolution );
	var reducedSpec	=	[];

	for( var i = 0; i < resolution; ++i )
	{
		reducedSpec.push( spectrum[ i * specInter ] );
	}
	
	for( var i = 0; i < resolution; ++i )
	{
		var scale = map( reducedSpec[ i ], 0, 160, 0, r * 0.5 );
		
		var angle = map( i, 0, resolution, 0, TWO_PI );
		var x = r * cos( angle - PI / 2 );
		var y = r * sin( angle - PI / 2 );
		
		push();
		translate( 500 / 2 + x, 500 / 2 + y );
		rotate( angle );
		stroke( 0, 151, 142 );
		strokeWeight( 4 );
		fill( color( 0, 151, 142 ) );
		rect( -intervall / 2, -scale, intervall, scale );
		pop();
	}
	
	translate( iWidth, iHeight );
	noStroke();
	fill( 255 );
	rect( -iWidth, iHeight - 200, 500, 20 );
	fill( 0 );
	text( 'Volume: ' + fNoise, -iWidth, iHeight - 186 );
}

function HSBRects()
{
	var spectrum	=	m_FFT.analyze();
	noStroke();
	for( i = 0; i < spectrum.length; ++i )
	{
		var amp = spectrum[ i ];
		var y =  map( amp, 0, 1200, height, 0 );

	//	console.log( i, amp, y, scale );
		
		translate( 0, 20 );
			colorMode( HSB, 255 );
				fill( i, 255, 255 );
				rect( 110 + i * ( width / 64 ), y,  ( width / 64 ) - 2, height - y );
			colorMode( RGB );
		translate( 0, -20 );
	}
}

function AnimateTalk()
{
	m_fVolume	=	m_Microphone.getLevel();
	var iWidth = 500 / 2;
	var iHeight = height / 2;
	
	image( m_Inactive, 0, 0, 300, 300 );	//	Inactive Animation Loop on top of Chroma Key ( 10 top, 10 left )
	if( m_fVolume >= 0.02000 )			//	If Volume threshold ( Min 0 ~ 1 Max )
	{
		image( m_Active, 0, 0, 300, 300 );	//	Active Animation Loop
	}
	

	translate( 500 / 2, height / 2 );
	noStroke();
	fill( 255 );
	rect( -iWidth, iHeight - 200, 500, 20 );
	fill( 0 );
	text( 'Volume: ' + m_fVolume, -iWidth, iHeight - 186 );
}

function draw()
{
	background( 0 );
	HSBRects();
	Spectrum( true );
	Expressions();
//	AnimateTalk();
}
</script></head><body></body></html>