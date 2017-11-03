/*!
 * jquery.tzineClock.js - Tutorialzine Colorful Clock Plugin
 *
 * Copyright (c) 2009 Martin Angelov
 * http://tutorialzine.com/
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Launch  : December 2009
 * Version : 1.0
 * Released: Monday 28th December, 2009 - 00:00
 */

(function($){
	
	// A global array used by the functions of the plug-in:
	var gVars = {};

	// Extending the jQuery core:
	$.fn.tzineClock = function(opts){
	
		// "this" contains the elements that were selected when calling the plugin: $('elements').tzineClock();
		// If the selector returned more than one element, use the first one:
		
		var container = this.eq(0);
	
		if(!container)
		{
			try{
				console.log("Invalid selector!");
			} catch(e){}
			
			return false;
		}
		
		if(!opts) opts = {}; 
		
		var defaults = {
			/* Additional options will be added in future versions of the plugin. */
		};
		
		/* Merging the provided options with the default ones (will be used in future versions of the plugin): */
		$.each(defaults,function(k,v){
			opts[k] = opts[k] || defaults[k];
		})

		// Calling the setUp function and passing the container,
		// will be available to the setUp function as "this":
		setUp.call(container);
		
		return this;
	}
	
	// Extending the jQuery core:
	$.fn.tzineClock1 = function(seconds){
	
		// "this" contains the elements that were selected when calling the plugin: $('elements').tzineClock();
		// If the selector returned more than one element, use the first one:
		
		var container = this.eq(0);
	
		if(!container)
		{
			try{
				console.log("Invalid selector!");
			} catch(e){}
			
			return false;
		}
		
		

		// Calling the setUp function and passing the container,
		// will be available to the setUp function as "this":
		setUp1(seconds);
		
		return this;
	}
	// Extending the jQuery core:
	$.fn.tzineClock2 = function(seconds){
	
		// "this" contains the elements that were selected when calling the plugin: $('elements').tzineClock();
		// If the selector returned more than one element, use the first one:
		
		var container = this.eq(0);
	
		if(!container)
		{
			try{
				console.log("Invalid selector!");
			} catch(e){}
			
			return false;
		}
		
		

		// Calling the setUp function and passing the container,
		// will be available to the setUp function as "this":
		setUp2(seconds);
		
		return this;
	}
	var s=0;
	function setUp1(seconds)
	{
		// The colors of the dials:
		var colors = ['orange'];
		
		var tmp;
		
		//for(var i=0;i<3;i++)
		{
			// Creating a new element and setting the color as a class name:
			/*tmp = $('<div>').html(
				'<div class="display1"></div>'+
				
				'<div class="front1 left1"></div>'+
				
				'<div class="rotate1 left1">'+
					'<div class="bg1 left1"></div>'+
				'</div>'+
				
				'<div class="rotate1 right1">'+
					'<div class="bg1 right1"></div>'+
				'</div>'*/
				if(i>0)
				tmp = $('<div>').html(
				'<div class="seconde display1"></div>'
			);
			else
			tmp = $('<div>').html(
				'<div class="minute display1"></div>:'
			);
			
			// Appending to the container:
			$('.tab_intro .chrono').html(tmp);
			
			// Assigning some of the elements as variables for speed:
			tmp.rotateLeft = tmp.find('.rotate.left');
			tmp.rotateRight = tmp.find('.rotate.right');
			tmp.display = tmp.find('.display');
			
			gVars[colors[0]] = tmp;
		}
		 
			
		s=seconds;
	animation(tmp, s, 60,200);
     

			
			//animation(gVars.orange, h, 24);
		
		//},1000);
	}
	
	var setIntervalChrono;
	function setUp()
	{
	if(setIntervalChrono)
		clearInterval(setIntervalChrono);

		// The colors of the dials:
		var colors = ['blue','green'];
		
		var tmp;
		
		for(var i=0;i<2;i++)
		{
			// Creating a new element and setting the color as a class name:
			
			/*tmp = $('<div>').html(
				'<div class="display1"></div>'+
				
				'<div class="front1 left1"></div>'+
				
				'<div class="rotate1 left1">'+
					'<div class="bg1 left1"></div>'+
				'</div>'+
				
				'<div class="rotate1 right1">'+
					'<div class="bg1 right1"></div>'+
				'</div>'*/
				if(i>0)
				tmp = $('<div>').html(
				'<div class="seconde display1"></div>'
			);
			else
			tmp = $('<div>').html(
				'<div class="minute display1"></div>:'
			);
			
			// Appending to the container:
			$(this).append(tmp);
			
			// Assigning some of the elements as variables for speed:
			tmp.rotateLeft = tmp.find('.rotate1.left1');
			tmp.rotateRight = tmp.find('.rotate1.right1');
			tmp.display = tmp.find('.display1');
			
			// Adding the dial as a global variable. Will be available as gVars.colorName
			gVars[colors[i]] = tmp;
		}
		var m = 0;
			var s = 0;
		// Setting up a interval, executed every 1000 milliseconds:
		setIntervalChrono=setInterval(function(){
		
			var currentTime = new Date();
			//var h = currentTime.getHours();
			
		s++;
		if(s==60)
		{m++;
		s=0;
		}
	animation(gVars.green, s, 60,100);
			animation(gVars.blue, m, 60,100);
     

			
			//animation(gVars.orange, h, 24);
		
		},1000);
	}
	function setUp2(seconds)
	{
	if(setIntervalChrono)
		clearInterval(setIntervalChrono);

		// The colors of the dials:
		var colors = ['blue','green'];
		
		var tmp;
		
		for(var i=0;i<2;i++)
		{
			// Creating a new element and setting the color as a class name:
			
			/*tmp = $('<div>').html(
				'<div class="display1"></div>'+
				
				'<div class="front1 left1"></div>'+
				
				'<div class="rotate1 left1">'+
					'<div class="bg1 left1"></div>'+
				'</div>'+
				
				'<div class="rotate1 right1">'+
					'<div class="bg1 right1"></div>'+
				'</div>'*/
				if(i>0)
				tmp = $('<div>').html(
				'<div class="seconde display1"></div>'
			);
			else
			tmp = $('<div>').html(
				'<div class="minute display1"></div>:'
			);
			
			// Appending to the container:
			$('#divcours .chrono').append(tmp);
			
			// Assigning some of the elements as variables for speed:
			tmp.rotateLeft = tmp.find('.rotate1.left1');
			tmp.rotateRight = tmp.find('.rotate1.right1');
			tmp.display = tmp.find('.display1');
			
			// Adding the dial as a global variable. Will be available as gVars.colorName
			gVars[colors[i]] = tmp;
		}
		var m = parseInt(seconds/60);
			var s =  parseInt(seconds%60);
		// Setting up a interval, executed every 1000 milliseconds:
		setIntervalChrono=setInterval(function(){
		
			var currentTime = new Date();
			//var h = currentTime.getHours();
			
		s++;
		if(s==60)
		{m++;
		s=0;
		}
	animation(gVars.green, s, 60,100);
			animation(gVars.blue, m, 60,100);
     

			
			//animation(gVars.orange, h, 24);
		
		},1000);
	}
	
	function animation(clock, current, total,width)
	{
		// Calculating the current angle:
		var angle = (360/total)*(current+1);
	
		var element;

		if(current==0)
		{
			// Hiding the right half of the background:
			clock.rotateRight.hide();
			
			// Resetting the rotation of the left part:
			rotateElement(clock.rotateLeft,0,width);
		}
		
		if(angle<=180)
		{
			// The left part is rotated, and the right is currently hidden:
			element = clock.rotateLeft;
		}
		else
		{
			// The first part of the rotation has completed, so we start rotating the right part:
			clock.rotateRight.show();
			clock.rotateLeft.show();
			
			rotateElement(clock.rotateLeft,180,width);
			
			element = clock.rotateRight;
			angle = angle-180;
		}

		rotateElement(element,angle,width);
		
		// Setting the text inside of the display element, inserting a leading zero if needed:
		clock.display.html(current<10?'0'+current:current);
	}
	
	function rotateElement(element,angle,width)
	{
		// Rotating the element, depending on the browser:
		var rotate = 'rotate('+angle+'deg)';
		
		if(element.css('MozTransform')!=undefined)
			element.css('MozTransform',rotate);
			
		else if(element.css('WebkitTransform')!=undefined)
			element.css('WebkitTransform',rotate);
	
		// A version for internet explorer using filters, works but is a bit buggy (no surprise here):
		else if(element.css("filter")!=undefined)
		{
			var cos = Math.cos(Math.PI * 2 / 360 * angle);
			var sin = Math.sin(Math.PI * 2 / 360 * angle);
			
			element.css("filter","progid:DXImageTransform.Microsoft.Matrix(M11="+cos+",M12=-"+sin+",M21="+sin+",M22="+cos+",SizingMethod='auto expand',FilterType='nearest neighbor')");
	
			element.css("left",-Math.floor((element.width()-width)/2));
			element.css("top",-Math.floor((element.height()-width)/2));
		}
	
	}
	
})(jQuery)