document.addEventListener("DOMContentLoaded", function()
{
    // Get the button, input field, and result div
    const lookupButton = document.getElementById("lookup");
    const lookupCitiesButton = document.getElementById("lookupCities")
    const countryInput = document.getElementById("country");
    const resultDiv = document.getElementById("result");

    lookupButton.addEventListener("click",function()
    {
        // get the value entered the country field
        const country = countryInput.value.trim();

        // check if the input is empty
        if (country === "")
        {
            resultDiv.innerHTML = "<p>Please enter a country name.</p>";
            return;
        }
        // create AJAX request
        const xhr = new XMLHttpRequest();

        // open the request to world.php with the country query parameter
        xhr.open("GET", `world.php?country=${encodeURIComponent(country)}`, true);

        // Set up the onload function to handle the response
        xhr.onload = function()
        {
            if (xhr.status === 200)
            {
                // Display the response in the result div
                resultDiv.innerHTML = xhr.responseText;
            }
            else
            {
                // Display an error message if the request fails
                resultDiv.innerHTML = `<p>Error: Unable to fetch data (status ${xhr.status}).</p>`;
            }
        }
        // Handle network errors
        xhr.onerror = function () {
            resultDiv.innerHTML = "<p>An error occurred while trying to fetch the data.</p>";
        };

        // Send the request
        xhr.send();
    });
    lookupCitiesButton.addEventListener("click", function()
    {
        // Get the value entered in the country field
        const country = countryInput.value.trim();

        // check if the input is empty
        if (country === "")
        {
            resultDiv.innerHTML = "<p>Please enter a country name.</p>";
            return
        }
        
        // Create AJAX request
        const xhr2 = new XMLHttpRequest();

        // Open the request to world.php with both the country and lookup=cities query parameters
        xhr2.open("GET", `world.php?country=${encodeURIComponent(country)}&lookup=cities`, true);

        // Set up the onload function to handle the response
        xhr2.onload = function()
        {
            if (xhr2.status === 200)
            {
                 // Display the response in the result div
                 resultDiv.innerHTML = xhr2.responseText;
            }
            else
            {
                // Display an error message if the request fails
                resultDiv.innerHTML = `<p>Error: Unable to fetch data (status ${xhr.status}).</p>`;
            }
        };
        xhr2.onerror = function()
        {
            resultDiv.innerHTML = "<p>An error occurred while trying to fetch the data.</p>";
        };
        // send the request
        xhr2.send();
    });
});
