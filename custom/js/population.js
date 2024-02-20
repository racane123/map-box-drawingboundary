function viewResidentChart_Table(element){
       clearChart_table()
        var brgyno = element.getAttribute("data-brgyno");
        console.log(brgyno)
        

    $.ajax({
        url: "apiFolder/brgy"+brgyno+"api.php",
        type: "GET",
        dataType: "json",
        success: function(data) {
            if (data.hasOwnProperty('error')) {
                $("#population_data").html("Error: " + data.error);
            } else {
                // Extract male_count and female_count
                var maleCount = data[0].male_count;
                var femaleCount = data[0].female_count;

                var underweightCount = data[0].underweight_count;
                var normalweightCount = data[0].normalweight_count;
                var overweightCount = data[0].overweight_count;
                var obesityCount = data[0].obesity_count;
                 
                // Display total number of residents
                $("#population_data").html(" Barangay " + brgyno + " Total residents: " + data[0].total_residents);

                // Use maleCount and femaleCount in Chart.js data
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Male', 'Female'],
                        datasets: [{
                            label: 'Population by Gender',
                            data: [maleCount, femaleCount],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    suggestedMin: 0  // Set the suggested minimum to 0
                                }
                            }]
                        }
                    }
                });
                
                var ctx = document.getElementById('myChart2').getContext('2d');
                var chart = new Chart(ctx, {
                   type: 'bar',
                data: {
                       labels: ['Underweight', 'Normal weight','Overweight','Obesity'],
                       datasets: [{
                       label: 'Barangay' + brgyno + ' Population',
                       backgroundColor: 'rgb(255, 99, 132)',
                       borderColor: 'rgb(255, 99, 132)',
                       data: [underweightCount, normalweightCount,overweightCount, obesityCount]
                     }]
                  },

                options: {
                    scales: {
                       yAxes: [{
                         ticks: {
                             suggestedMin: 0  // Set the suggested minimum to 0
                                 }
                              }]
                            }
                       }
                });
                


                var tableBody = document.querySelector('#resident-table tbody');
                data.forEach(resident => {
                    var row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${resident.name}</td>
                        <td>${resident.age}</td>
                        <td>${resident.gender}</td>
                        <td>${resident.height}</td>
                        <td>${resident.weight}</td>
                        <td>${resident.bmi}</td>
                        <td>${resident.bmi_category}</td>
                        <td><button class="btn btn-primary" data-toggle="modal" data-target="#editinfo" onclick="editResident(${resident.ResidentID}, '${resident.name}', ${resident.age}, '${resident.gender}', ${resident.height}, ${resident.weight})">Edit</button></td>
                    `;
                    tableBody.appendChild(row);
                });


            }
            

        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });
     
    $('#viewResidentChart_Table').modal('show');
    
}


function clearChart_table() {
    $('#viewResidentChart_Table').modal('hide');
    $('#viewresident').modal('hide');
    $('#editinfo').modal('hide');
    $('#resident-table tbody tr').empty(); // Clear the table body
  }