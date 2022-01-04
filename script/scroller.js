function Scroller(x, y, width, height, border, padding)
{
	this.x = x;
	this.y = y;
	this.width = width;
	this.height = height;
	this.border = border;
	this.padding = padding;
	
	this.items = new Array();
	this.created = false;
	
	// Set default colors.
	this.fgColor = "";
	this.bgColor = "";
	this.bdColor = "";
	
	// Set default font.
	this.fontFace = "±¼¸², ±¼¸²Ã¼, verdana, Arial,Helvetica";
	this.fontSize = "2";
	
	// Set default scroll timing values.
	this.speed = 500;
	this.pauseTime = 0;
	
	// Define methods.
	this.setColors = scrollerSetColors;
	this.setFont = scrollerSetFont;
	this.setSpeed = scrollerSetSpeed;
	this.setPause = scrollersetPause;
	this.addItem = scrollerAddItem;
	this.create = scrollerCreate;
	this.show = scrollerShow;
	this.hide = scrollerHide;
	this.moveTo = scrollerMoveTo;
	this.moveBy = scrollerMoveBy;
	this.getzIndex = scrollerGetzIndex;
	this.setzIndex = scrollerSetzIndex;
	this.stop = scrollerStop;
	this.start = scrollerStart;
}

function scrollerSetColors(fgcolor, bgcolor, bdcolor)
{
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.fgColor = fgcolor;
	this.bgColor = bgcolor;
	this.bdColor = bdcolor;
}

function scrollerSetFont(face, size)
{
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.fontFace = face;
	this.fontSize = size;
}

function scrollerSetSpeed(pps)
{
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.speed = pps;
}

function scrollersetPause(ms)
{
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.pauseTime = ms;
}

function scrollerAddItem(str)
{
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.items[this.items.length] = str;
}

function scrollerCreate()
{
	var start, end;
	var str;
	var i, j;
	var x, y;
	
	if (!isMinNS4 && !isMinIE4)
	{
		return;
	}
	
	if (scrollerList.length == 0)
	{
		setInterval('scrollerGo()', scrollerInterval);
	}
	
	if (this.created)
	{
		alert("Scroller Error: Scroller has already been created.");
		return;
	}
	this.created = true;
	
	this.items[this.items.length] = this.items[0];
	start = '<table border=0'
	+ ' cellpadding=' + (this.padding + this.border)
	+ ' cellspacing=0'
	+ ' width=' + this.width
	+ ' height=' + this.height + '>'
	+ '<tr><td>'
	+ '<font'
	+ ' color="' + this.fgColor + '"'
	+ ' face="' + this.fontFace + '"'
	+ ' size=' + this.fontSize + '>';
	end   = '</font></td></tr></table>';
	
	if (isMinNS4)
	{
		this.baseLayer = new Layer(this.width);
		this.scrollLayer = new Layer(this.width, this.baseLayer);
		this.scrollLayer.visibility = "inherit";
		this.itemLayers = new Array();
		for (i = 0; i < this.items.length; i++)
		{
			this.itemLayers[i] = new Layer(this.width, this.scrollLayer);
			this.itemLayers[i].document.open();
			this.itemLayers[i].document.writeln(start + this.items[i] + end);
			this.itemLayers[i].document.close();
			this.itemLayers[i].visibility = "inherit";
		}
		
		setBgColor(this.baseLayer, this.bdColor);
		setBgColor(this.scrollLayer, this.bgColor);
	}
	
	if (isMinIE4)
	{
		i = scrollerList.length;
		str = '<div id="scroller' + i + '_baseLayer"'
		+ ' style="position:absolute;'
		+ ' background-color:' + this.bdColor + ';'
		+ ' width:' + this.width + 'px;'
		+ ' height:' + this.height + 'px;'
		+ ' overflow:hidden;'
		+ ' visibility:hidden;">\n'
		+ '<div id="scroller' + i + '_scrollLayer"'
		+ ' style="position:absolute;'
		+ ' background-color: ' + this.bgColor + ';'
		+ ' width:' + this.width + 'px;'
		+ ' height:' + (this.height * this.items.length) + 'px;'
		+ ' visibility:inherit;">\n';
		for (j = 0; j < this.items.length; j++)
		{
			str += '<div id="scroller' + i + '_itemLayers' + j + '"'
			+  ' style="position:absolute;'
			+  ' width:' + this.width + 'px;'
			+  ' height:' + this.height + 'px;'
			+  ' visibility:inherit;">\n'
			+  start + this.items[j] + end
			+  '</div>\n';
		}
		str += '</div>\n'
		+  '</div>\n';
		
		if (!isMinIE5)
		{
			x = getPageScrollX();
			y = getPageScrollY();
			window.scrollTo(getPageWidth(), getPageHeight());
		}
		document.body.insertAdjacentHTML("beforeEnd", str);
		
		if (!isMinIE5)
		{
			window.scrollTo(x, y);
		}
		
		this.baseLayer = getLayer("scroller" + i + "_baseLayer");
		this.scrollLayer = getLayer("scroller" + i + "_scrollLayer");
		this.itemLayers = new Array();
		for (j = 0; j < this.items.length; j++)
		{
			this.itemLayers[j] = getLayer("scroller" + i + "_itemLayers" + j);
		}
	}
	
	moveLayerTo(this.baseLayer, this.x, this.y);
	clipLayer(this.baseLayer, 0, 0, this.width, this.height);
	moveLayerTo(this.scrollLayer, this.border, this.border);
	clipLayer(this.scrollLayer, 0, 0,this.width - 2 * this.border, this.height - 2 * this.border);
	x = 0;
	y = 0;
	for (i = 0; i < this.items.length; i++)
	{
		moveLayerTo(this.itemLayers[i], x, y);
		clipLayer(this.itemLayers[i], 0, 0, this.width, this.height);
		x += this.width;
	}
	
	this.stopped = false;
	this.currentX = 0;
	this.stepX = this.speed / (1000 / scrollerInterval);
	this.stepX = Math.min(this.height, this.stepX);
	this.nextX = this.width;
	this.maxX = this.width * (this.items.length - 1);
	this.paused = true;
	this.counter = 0;
	
	scrollerList[scrollerList.length] = this;
	showLayer(this.baseLayer);
}

function scrollerShow()
{
	if (this.created)
		showLayer(this.baseLayer);
}

function scrollerHide()
{
	if (this.created)
		hideLayer(this.baseLayer);
}

function scrollerMoveTo(x, y)
{
	if (this.created)
		moveLayerTo(this.baseLayer, x, y);
}

function scrollerMoveBy(dx, dy)
{
	if (this.created)
		moveLayerBy(this.baseLayer, dx, dy);
}

function scrollerGetzIndex()
{
	if (this.created)
		return(getzIndex(this.baseLayer));
	else
		return(0);
}

function scrollerSetzIndex(z)
{
	if (this.created)
		setzIndex(this.baseLayer, z);
}

function scrollerStart()
{
	this.stopped = false;
}

function scrollerStop()
{
	this.stopped = true;
}

var scrollerList     = new Array();


function scrollerGo()
{
	var i;
	for (i = 0; i < scrollerList.length; i++)
	{
		if (scrollerList[i].stopped);
		else if (scrollerList[i].paused)
		{
			scrollerList[i].counter += scrollerInterval;
			if (scrollerList[i].counter > scrollerList[i].pauseTime)
				scrollerList[i].paused = false;
		}
		else
		{
			scrollerList[i].currentX += scrollerList[i].stepX;

			if (scrollerList[i].currentX >= scrollerList[i].nextX)
			{
				scrollerList[i].paused = true;
				scrollerList[i].counter = 0;
				scrollerList[i].currentX = scrollerList[i].nextX;
				scrollerList[i].nextX += scrollerList[i].width;
			}

			  // When we reach the end, start over.

			if (scrollerList[i].currentX >= scrollerList[i].maxX)
			{
				scrollerList[i].currentX -= scrollerList[i].maxX;
				scrollerList[i].nextX = scrollerList[i].width;
			}
			scrollLayerTo(scrollerList[i].scrollLayer,Math.round(scrollerList[i].currentX),0,false);
		}
	}
}

var origWidth;
var origHeight;

if (isMinNS4)
{
	origWidth  = window.innerWidth;
	origHeight = window.innerHeight;
}
window.onresize = scrollerReload;

function scrollerReload()
{
	if (isMinNS4 && origWidth == window.innerWidth && origHeight == window.innerHeight)
		return;
	window.location.href = window.location.href;
}

