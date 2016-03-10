<h1>Contact</h1>
<section>
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCUWe7-YqqNblh58wp_ciY0u_B8evxqa9g"></script>
				<script>
					function initialize() {
						var mapProp = {
							center:new google.maps.LatLng(43.631417, 3.861584),
							zoom:15,
							mapTypeId:google.maps.MapTypeId.ROADMAP
						};
						var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
					}
					google.maps.event.addDomListener(window, 'load', initialize);
				</script>
				<div id="googleMap" style="width:100%;height:400px;"></div>
				<br>
				<address>
					Université Montpellier 2<br>
					Place Eugène Bataillon<br>
					34095 Montpellier cedex 5<br>
					France
				</address>
				Tél: 04 67 14 30 30<br>
				Fax: 04 67 14 30 31
			</div>
		</div>
	</div>
</section>