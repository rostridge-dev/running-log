		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
<?php
	if (isset($footer_js)) {
		echo $footer_js;
	}
?>
		<script type="text/javascript">
			$(function() {
				// When using dates, must subtract one from the month; also need to add a padding day on either side of the x-axis
				var dataEasy = [[(new Date(2015,06,01)).getTime(),5], [(new Date(2015,06,03)).getTime(),13]];
				var dataLong = [[(new Date(2015,06,02)).getTime(),8], [(new Date(2015,06,05)).getTime(),5]];
				var dataTempo = [[(new Date(2015,06,04)).getTime(),5], [(new Date(2015,06,06)).getTime(),8]];
				var dataRace = [[(new Date(2015,06,07)).getTime(),5], [(new Date(2015,06,08)).getTime(),8]];
				var dataInterval = [[(new Date(2015,06,09)).getTime(),6], [(new Date(2015,06,10)).getTime(),11]];
				var dataFartlek = [[(new Date(2015,06,11)).getTime(),3], [(new Date(2015,06,12)).getTime(),8]];
				
				$.plot("#placeholder",
					[
						{label: "&nbsp;Easy", color: "#85e685", data: dataEasy, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Long", color: "#f28504", data: dataLong, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Tempo", color: "#6dcff6", data: dataTempo, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Race", color: "#ed1c24", data: dataRace, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Interval", color: "#b658b7", data: dataInterval, bars: {show: true, barWidth: 40000000, align: "center"}},
						{label: "&nbsp;Fartlek", color: "#dfd455", data: dataFartlek, bars: {show: true, barWidth: 40000000, align: "center"}}
					], {
					xaxis: {
						mode: "time",
						minTickSize: [1, "day"],
						min: (new Date(2015,05,30)).getTime(),
						max: (new Date(2015,06,15)).getTime(),
						timeformat: "%Y/%m/%d"
					}
				});
			});
		</script>
	</body>
</html>