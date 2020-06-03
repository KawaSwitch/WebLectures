function createPieChart(id, title, dataPoints)
{
	return new CanvasJS.Chart(id, {
		animationEnabled: true,
		title: {
			text: title,
			fontSize: 25,
			fontFamily: 'sans-serif',
			fontWeight: "bold"
		},
		data: [{
			type: "pie",
			indexLabel: "{y}",
			yValueFormatString: "#,##0.00\"%\"",
			indexLabelPlacement: "inside",
			indexLabelFontColor: "#36454F",
			indexLabelFontSize: 18,
			indexLabelFontWeight: "bolder",
			showInLegend: true,
			legendText: "{label}",
			dataPoints: dataPoints
		}]
	});
}

function createBarChart(id, title, ytitle, legend, dataPoints)
{
	return new CanvasJS.Chart(id, {
		animationEnabled: true,
		theme: "light2", // "light1", "light2", "dark1", "dark2"
		title:{
			text: title,
			fontSize: 25,
			fontFamily: 'sans-serif'
		},
		axisY: {
			title: ytitle
		},
		dataPointMaxWidth: 40,
		data: [{        
			type: "column",  
			showInLegend: true, 
			legendMarkerColor: "grey",
			legendText: legend,
			dataPoints: dataPoints
		}]
	});
}