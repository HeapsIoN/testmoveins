// JavaScript Document

if($("#moveinout").length > 0)
	{

var moveinout = [
	{value: 57,		color: "#CFEAF5",	highlight: "#065E6D",	label: "Move Ins"},
	{value: 22,		color: "#1C91B6",	highlight: "#065E6D",	label: "Move Outs"}
];

var dnt = $("#moveinout").get(0).getContext("2d");
var myDoughnutChart = new Chart(dnt).Doughnut(moveinout, {
	animateScale: true, 
	animationEasing : "easeOutQuart",
	animationSteps: 50,
	responsive: true
});
	}


if($("#monthly").length > 0)
	{

var monthrev = {
    labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
    datasets: [
        {
            label: "Income",
            fillColor: "rgba(207,234,245,0.5)",
            strokeColor: "rgba(28,145,182,0.8)",
            highlightFill: "rgba(207,234,245,0.75)",
            highlightStroke: "rgba(28,145,182,1)",
            data: [15000, 16500, 18000, 17000, 16500, 17500, 18000, 19000, 19500, 19000, 19000, 19500]
        }
    ]
};


var mth = $("#monthly").get(0).getContext("2d");
var myDoughnutChart = new Chart(mth).Line(monthrev, {
	animateScale: true, 
	animationEasing : "easeOutQuart",
	animationSteps: 50,
	responsive: true
});
	}