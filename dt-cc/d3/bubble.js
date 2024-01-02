(function() {
	var width = 1200,
		height = 600;

	var tooltip = floatingTooltip('tecnicos_bubble', 250);



	var svg = d3.select("#chart")
		.append("svg")
		.attr("height", height)
		.attr("width", width)
		.append("g")
		.attr("transform", "translate(0,0)")


	//	<defs>
	//	  <pattern id="mirko-jozic" height="100%" width="100%" patternContentUnits="objectBoundingBox">
	//	    <image height="1" width="1" preserveAspectRatio="none" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="img/jozic.jpg">
	//	    </image>
	//	  </pattern>
	//	</defs>
	var defs = svg.append("defs");
	defs.append("pattern")
		.attr("id", "Mirko-Jozic")
		.attr("height", "100%")
		.attr("width", "100%")
		.attr("patternContentUnits", "objectBoundingBox")
		.append("image")
		.attr("height", 1)
		.attr("width", 1)
		.attr("preserveAspectRatio", "none")
		.attr("xmlns:xlink", "http://www.w3.org/1999/xlink")
		.attr("xlink:href", "img/jozic.jpg");


	// tamaño de las pelotas según el dato	
	var radiusScale = d3.scaleSqrt()
			.domain([45, 75])
			.range([10, 80])	

	
	// Default, unir todos
	var forceXCombine = d3.forceX(width / 2).strength(0.05)

	// Chileno o extranjero
	var forceXExtranjero = d3.forceX(function(d){
			if (d.extranjero === 'si'){
				return 300
			} else {
				return 1000
			}
		}).strength(0.05)

	// Titulos o no
	var forceXTitulos = d3.forceX(function(d){
			if (d.titulos === 'si'){
				return 300
			} else {
				return 1000
			}
		}).strength(0.05)



	var forceCollide = d3.forceCollide(function(d){
			return radiusScale(d.Rendimiento) + 2;
		})


	var simulation = d3.forceSimulation()
		//.force("name", definetheforce)
		//.force("x", d3.forceX(width / 2).strength(0.05))
		.force("x", forceXCombine)
		.force("y", d3.forceY(height / 2).strength(0.05))
		.force("collide", forceCollide)

	d3.queue()
		.defer(d3.csv, "d3/tecnicos.csv")
		.await(ready)


/*
   * Function called on mouseover to display the
   * details of a bubble in the tooltip.
   */
  function showDetail(d) {
    // change outline to indicate hover state.
    d3.select(this).attr('stroke', 'black');

    var content = '<span class="value1">' +
                  d.nombre +
                  '</span><br/>' +

                  '<span class="value2">' +
                  d.rendimientoporcentaje +
                  '</span><br/>' +
                  
                  '<span class="value3">RENDIMIENTO</span><br/><br/>' +

                  '<span class="value41">Nacionalidad: </span><span class="value42">' +
                  d.country +
                  '</span><br/>' +
                  
                //   '<span class="value51">Año en actividad: </span><span class="value52">' +
                //   d.anio +
                //   '</span><br/>' +
                  
                  '<span class="value61">Títulos: </span><span class="value62">' +
                  d.Títulos +
                  '</span>';

;
                  
    tooltip.showTooltip(content, d3.event);
  }

  /*
   * Hides tooltip
   */
  function hideDetail(d) {
    // reset outline
    d3.select(this)
      .attr('stroke', null);

    tooltip.hideTooltip();
  }


	function ready (error, datapoints) {

	defs.selectAll(".dts-pattern")
		.data(datapoints)
		.enter().append("pattern")
		.attr("class", "dts-pattern")
		.attr("id", function(d){
			return d.name.toLowerCase().replace(" ", "_")
		})
		.attr("height", "100%")
		.attr("width", "100%")
		.attr("patternContentUnits", "objectBoundingBox")
		.append("image")
		.attr("height", 1)
		.attr("width", 1)
		.attr("preserveAspectRatio", "none")
		.attr("xmlns:xlink", "http://www.w3.org/1999/xlink")
		.attr("xlink:href", function (d){
				return d.image_path
			});


	var circles = svg.selectAll(".dts")
		.data(datapoints)
		.enter().append("circle")
		.attr("class","dts")
		.attr("r", function (d){
			return radiusScale(d.Rendimiento)
		})
		.attr("fill", function(d){
			return "url(#" + d.name.toLowerCase().replace(" ", "_") + ")"
		})
		
		.on('click', function(d){
			console.log(d)
		})
	  .on('mouseover', showDetail)
      .on('mouseout', hideDetail);

	d3.select("#ch-extranjero").on('click', function(){
		simulation
		.force("x", forceXExtranjero)
		.alphaTarget (0.25)
		.restart()
		console.log("Chileno o extranjero")
	})

	d3.select("#combine").on("click", function (){
		simulation
		.force("x", forceXCombine)
		.alphaTarget (0.25)
		.restart()
		console.log("Combine the bubbles")
	})

	d3.select("#titulos").on("click", function (){
		simulation
		.force("x", forceXTitulos)
		.alphaTarget (0.25)
		.restart()
		console.log("Ganó Titulos o no")
	})








	simulation.nodes(datapoints)
		.on ('tick', ticked)

	// When we feed our simulation its going to update the datapoints
	function ticked(){
		circles
		.attr("cx", function(d){
			return d.x
		})
		.attr("cy", function(d){
			return d.y
		})
	}
	} //end of function (error, datapoints)	

}) ();


