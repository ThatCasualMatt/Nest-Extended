<?php include '/resources/config.php'; ?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Nest-Extended</title>
	<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="/resources/libs/flot/excanvas.min.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="/resources/libs/flot/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="/resources/libs/flot/jquery.flot.min.js"></script>
	<script language="javascript" src="/resources/libs/flot/jquery.flot.time.min.js"></script>
	<script language="javascript" src="/resources/libs/flot/date.min.js"></script>
	<script language="javascript" type="text/javascript" src="/resources/libs/flot/jquery.flot.rangeselection.min.js"></script>
	<script language="javascript" type="text/javascript" src="/resources/libs/flot/jquery.flot.tooltip.min.js"></script>
	<script language="javascript"> 
	timezoneJS.timezone.zoneFileBasePath = "/resources/libs/flot/tz";
	timezoneJS.timezone.defaultZoneFile = [];
	timezoneJS.timezone.init({async: false});
	
	var temperatureGraph;
	var humidGraph;
	var miscellanyGraph;
	var rangeselectionCallback = function(o){
		console.log("New selection:"+o.start+","+o.end);
		var tempxaxis = temperatureGraph.getAxes().xaxis;
		tempxaxis.options.min = o.start;
		tempxaxis.options.max = o.end;
		temperatureGraph.setupGrid();
		temperatureGraph.draw();
		var humidxaxis = humidGraph.getAxes().xaxis;
		humidxaxis.options.min = o.start;
		humidxaxis.options.max = o.end;
		humidGraph.setupGrid();
		humidGraph.draw();
		var miscellanyxaxis = miscellanyGraph.getAxes().xaxis;
		miscellanyxaxis.options.min = o.start;
		miscellanyxaxis.options.max = o.end;
		miscellanyGraph.setupGrid();
		miscellanyGraph.draw();
	}
	
	function getData() {	
		var d = new Date();
		var currenttime = d.getTime();
		var yesterdaytime = currenttime - 86400000;
	
		$.getJSON('/resources/utils/nest-get-json.php?datatype=temp', function(tempdata) {
				var tempoptions = {
					xaxes: [{ 
						mode: "time", 
						timezone: "<?php echo date_default_timezone_get()?>",
						timeformat: "%m/%d/%Y %H:%M",
						min: yesterdaytime,
						max: currenttime
					}], 
					yaxes: [{
					}, {
						show: false,
						min: 0,
						max: 1
					}],
					legend: { 
						noColumns: 4,
						position: "nw"		
					}, 
					grid: {
						hoverable: true, 
					},
					tooltip:true
				};
				temperatureGraph = $.plot("#temperature",tempdata,tempoptions);
			
				var sData = $.extend(true,[],tempdata);
				for(var i=0;i<sData.length;i++){
					sData[i].color = '#ccc';
					sData[i].label = undefined;
				}
				$.plot("#navigation",sData,{
					rangeselection:{
						color: "#feb",
						start: yesterdaytime,
						end: currenttime,
						enabled: true,
						callback: rangeselectionCallback
					},
					xaxes: [{ 
						mode: "time", 
						timezone: "<?php echo date_default_timezone_get()?>",
						timeformat: "%m/%d/%Y %H:%M",
					}],
					yaxes: [{
						show: false
					}, {
						show: false
					}],
					lines: { 
						show: false
					}
				});
			});
		
		$.getJSON('/resources/utils/nest-get-json.php?datatype=humid', function(humiddata) {		
				var humidoptions = {
					xaxes: [{ 
						mode: "time", 
						timezone: "<?php echo date_default_timezone_get()?>",
						timeformat: "%m/%d/%Y %H:%M",
						min: yesterdaytime,
						max: currenttime
					}],
					yaxes: [{
						min:0,
						max:100
					}],
					legend: { 
						position: "sw"		
					}, 
					grid: {
						hoverable: true, 
					},
					tooltip:true
				};
			humidGraph = $.plot("#humidity",humiddata,humidoptions);
		});
		
		$.getJSON('/resources/utils/nest-get-json.php?datatype=misc', function(miscdata) {	
				var miscoptions = {
					xaxes: [{ 
						mode: "time", 
						timezone: "<?php echo date_default_timezone_get()?>",
						timeformat: "%m/%d/%Y %H:%M",
						min: yesterdaytime,
						max: currenttime
					}],
					yaxes: [{
					}, {
						show: false,
						min: 0,
						max: 1
					}],
					legend: { 
						position: "sw"		
					}, 
					grid: {
						hoverable: true, 
					},
					tooltip:true
				};
			miscellanyGraph = $.plot("#miscellany",miscdata,miscoptions);
		});
		setInterval(getData, 300000);
	};

	$(function() {
		getData();
	});
</script>
</head>
<body>
<div id="wrapper" style="width:1000px;margin:0 auto;">
<p>Nest Extended!</p>
<div style="width:1000px">TEMPERATURE</div>
<div id="temperature" style="width:1000px;height:500px;"></div>
<div id="navigation" style="width:1000px;height:60px;"></div>
<div style="width:1000px;height:10px;">&nbsp;</div>
<div style="width:500px;float:left;">HUMIDITY</div>
<div style="width:500px;float:right;">BATTERY LEVEL</div>
<div id="humidity" style="float:left;width:500px;height:250px;"></div>
<div id="miscellany" style="float:right;width:500px;height:250px;"></div>
</div>
</body>
</html>
