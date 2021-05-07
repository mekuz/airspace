 
    <style>
        .art-img{
            //max-height:200px;
        }
    </style>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
    
	<div class="card col-md-8 offset-md-2" style="">
    
        <div class="card-body"  style="text-align: center">
        
		<canvas id="myChart" width="400" height="300"></canvas>
        
	    </div>
    </div>
    
    
    <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php foreach($arts as $art){
                $lab[] = $art['name'];//get all artifact names into an array
                
                
                }//end foreach
                
                echo json_encode($lab);//print the array
            ?>,
            datasets: [{
                label: 'Number of Artefact Scans',
                data:  <?php foreach($arts as $art){
                $scans[] = $art['hits'];//get number of scans into an array
                
                
                }//end foreach
                
                echo json_encode($scans);//print the array
            ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>