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
    th, td {
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

<table id="data-table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Area (sqm)</th>
            <th>Price ($)</th>
            <th>Send</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    // Function to fetch data from the API
    function fetchData() {
        fetch('../api/area-api.php')
            .then(response => response.json())
            .then(data => {
                // Call function to display data in table
                displayData(data);
            })
            .catch(error => console.error('Error fetching data:', error));
    }

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
            row.appendChild(priceCell);
            row.appendChild(sendCell);
            tableBody.appendChild(row);
        });
    }

    // Function to send data to another system
   function sendDataToAnotherSystem(data) {
        // Example URL of the other system's API endpoint
        const apiUrl = '../api/price-boundary.php';

        // Example data format to send
        const requestData = {
            name: data.name,
            area: data.area,
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

    // Call fetchData function when the page loads
    document.addEventListener('DOMContentLoaded', function() {
        fetchData();
    });
</script>

</body>
</html>
