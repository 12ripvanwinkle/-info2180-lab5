document.addEventListener("DOMContentLoaded", function()
{
    // Get the button, input field, and result div
    const lookupButton = document.getElementById("lookup");
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
});
