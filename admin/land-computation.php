<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fetch and Display Data</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .send-button {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <table id="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Area (sqm)</th>
                    <th>Property Type</th>
                    <th>Price ($)</th>
                    <th>Send</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
    <script>
        // Function to fetch data from the API

        fetch('../api/area-api.php')
            .then(response => response.json())
            .then(data => {
                // Call function to display data in table
                displayData(data);
                console.log(data)
            })
            .catch(error => console.error('Error fetching data:', error));


        // Function to calculate the price based on the population
        function calculatePrice(area) {
            // Example pricing strategy: $10 per square meter
            const pricePerSquareMeter = 5000;
            return area * pricePerSquareMeter;
        }

        // Function to display data in table
        function displayData(data) {
            const tableBody = document.querySelector('#data-table tbody');
            tableBody.innerHTML = ''; // Clear existing data

            // Loop through data and create table rows
            data.forEach(item => {
                const row = document.createElement('tr');
                const nameCell = document.createElement('td');
                nameCell.textContent = item.name;
                const titleCell = document.createElement('td');
                titleCell.textContent = item.title;
                const areaCell = document.createElement('td');
                areaCell.textContent = item.area.toFixed(2); // Display area with two decimal places
                const priceCell = document.createElement('td');
                const price = calculatePrice(item.area);
                priceCell.textContent = price.toFixed(2); // Display price with two decimal places
                const sendCell = document.createElement('td');
                const sendButton = document.createElement('button');
                sendButton.textContent = 'Send';
                sendButton.classList.add('send-button');
                sendButton.addEventListener('click', function() {
                    sendDataToAnotherSystem(item);
                });
                sendCell.appendChild(sendButton);
                row.appendChild(nameCell);
                row.appendChild(areaCell);
                row.appendChild(titleCell)
                row.appendChild(priceCell);
                row.appendChild(sendCell);
                tableBody.appendChild(row);
            });
        }

        const sendButton = document.getElementById('sendButton');

        sendButton.addEventListener('click', function() {
            // Disable the button to prevent spam clicks
            sendButton.disabled = true;

            // Call your function to send data to another system
            sendDataToAnotherSystem(item);

            // Enable the button after 3 seconds
            setTimeout(function() {
                sendButton.disabled = false;
            }, 3000); // 3000 milliseconds = 3 seconds
        });

        // Function to send data to another system
        function sendDataToAnotherSystem(data) {
            // Example URL of the other system's API endpoint
            const apiUrl = 'http://192.168.100.114/adminlte/api/landcomp.php';

            // Example data format to send
            const requestData = {
                name: data.name,
                area: data.area,
                title: data.title,
                price: calculatePrice(data.area),
            };

            // Example fetch request to send data
            fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.json())
                .then(result => {
                    // Handle the response from the other system if needed
                    console.log('Response from other system:', result);
                })
                .catch(error => {
                    console.error('Error sending data to other system:', error);
                });
        }
    </script>

</body>

</html>