 $(document).ready(function(){

    var couponsChart = generateCouponsChart('DAY', 'SOLD');

    $(".couponsSelect").change(function(e){
        couponsChart.destroy();
        couponsChart = generateCouponsChart($(this).val(), $(this).attr('data_status'));
    });
    $(".graph-sold").click(function(e){
        couponsChart.destroy();
        $(".couponsSelect").val('DAY');
        couponsChart = generateCouponsChart('DAY', 'SOLD');
    });
    $(".graph-used").click(function(e){
        couponsChart.destroy();
        $(".couponsSelect").val('DAY');
        couponsChart = generateCouponsChart('DAY', 'USED');
    });

    //for(i=1; i<=gaugeChartsToRender; i++){
        //generateGaugeChart('grid_chart_'+i );
    //}
 });

function generateGaugeChart(div_chart_id){

    var deal = $('#'+div_chart_id);
    var valid = parseInt(deal.attr('valid'));
    var used = parseInt(deal.attr('used'));
    var invalid = parseInt(deal.attr('invalid'));
    var refunded = parseInt(deal.attr('refunded'));
    var total = parseInt(deal.attr('total'));
    var current_deal = parseInt(deal.attr('deal_id'));
    var current_title_deal = deal.attr('deal_title');

	// add customer info
	var code = '';
	var validation_code = '';
	var deal_partner_id = '';

	Highcharts.setOptions({
	    colors: ['#008ea5', '#7aa34b','#e3e3e3','#8e8e8e']
	});

    chart_1 = new Highcharts.Chart({
        chart: {
            renderTo: div_chart_id,
            type: 'gauge',
            plotBorderWidth: 0,
            plotBackgroundImage: null,
            height: 180,
            width: 250,
            spacingTop: 1
        },
    
        title: {
            text: '',
        },
        
        pane: {
            startAngle: -65,
            endAngle: 65,
            background: null,
            center: ['50%', '90%'],
            size: 200
        },                         
    
        yAxis: {
            min: 0,
            max: total - invalid,
            minorTickPosition: 'inside',
            tickPosition: 'inside',
            minorTickLength: 0,
            tickWidth: 0,
            lineWidth: '0',
            labels: {
                rotation: 'auto',
                distance: 20,
                enabled: false
            },
            plotBands: [{
                from: 0,
                to: used,
                color: '#78A700',
                innerRadius: '50%',
                outerRadius: '120%'
            },
            {
                from: used,
                to: total - invalid,
                color: '#CCC',
                innerRadius: '50%',
                outerRadius: '120%'
            }],
            pane: 0,
            title: {
                text: '',
            }
        },
        
        plotOptions: {
            gauge: {
                dataLabels: {
                    enabled: false	
                },
                dial: {
                    radius: '130%',
                    baseLength: '40%', 
                    baseWidth: 7,
                    topWidth: 1,
                },
                pivot: {
                    radius: '0',
                }
            }
        },

        series: [{
			name: 'Validados',
            data: [used],
            yAxis: 0,
        }],

        tooltip: {
           enabled: false,
        },

		credits: {
        	enabled: false,
        },
    
    });

    perc = ((total>0) ? parseFloat(((used)*100) / (total-invalid)).toFixed(0) : 0);
    deal.append('<span style="font-size:18px;color:black;">' + perc + '%</span><br/>' +
                '<span style="font-size:14px;color:#9d9fa2;">Groupones usados: ' + used + '</span><br/>' +
                '<span style="font-size:14px;color:#9d9fa2;">Groupones devueltos: ' + refunded + '</span><br/>' +
                '<span style="font-size:14px;color:#9d9fa2;">Groupones pendientes: ' + valid + '</span><br/>');

    deal.append('<div style="position:absolute;top:140px;right:230px"><span style="font-size:20px;font-weight:bold;">' + (used) + '</span><br/> Usados</div>');
    deal.append('<div style="position:absolute;top:140px;right:65px;"><span style="font-size:20px;font-weight:bold;">' + (total-invalid) + '</span><br/> Total</div>');
}

