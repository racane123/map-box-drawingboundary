<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table>
  <thead>
    <tr>
      <th>Name</th>
      <th>Area</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody id="table-body"></tbody>
</table>
</body>
</html>


<script>
fetch('http://192.168.100.114/adminlte/api/landcomp.php')
  .then(response => {
    // Check if the response is ok
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    // Parse the JSON response
    return response.json();
  })
  .then(data => {
    // Use the fetched data
    createTable(data.data); // Access the 'data' array from the JSON
  })
  .catch(error => {
    // Handle errors
    console.error('Fetch error:', error);
  });

function createTable(data) {
  // Get the reference for the table body
  var tableBody = document.getElementById("table-body");

  // Loop through the data and create table rows
  data.forEach(item => {
    // Create a new row
    var row = tableBody.insertRow();

    // Insert cells into the row
    var nameCell = row.insertCell(0);
    var areaCell = row.insertCell(1);
    var priceCell = row.insertCell(2);

    // Populate cells with data
    nameCell.innerHTML = item.name;
    areaCell.innerHTML = item.area;
    priceCell.innerHTML = item.price;
  });
}


</script>


