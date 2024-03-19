<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Market Data</title>
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
</style>
</head>
<body>


<div class="content-wrapper" >
<table id="marketTable">
    <thead>
        <tr>
            <th>Market</th>
            <th>Contact</th>
            <th>Location</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>

<script>
    // Fetch data from the provided URL
    fetch('https://group63.towntechinnovations.com/map')
        .then(response => response.json())
        .then(data => {
            // Get reference to the table body
            const tableBody = document.querySelector('#marketTable tbody');

            // Loop through the data and add rows to the table
            data.forEach(item => {
                const row = `
                    <tr>
                        <td>${item.market}</td>
                        <td>${item.contact}</td>
                        <td>${item.location}</td>
                        <td>${item.type}</td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching data:', error));
</script>

</body>
</html>
