<script>
    // use real php backend
    backend = "/src/backend.php"
    // use test file that returns an example answer like it would come from the backend
    //backend = "/src/test.json";
</script>

<p id="demo">demo</p>

<p id="authToken">ee</p>

<script>
    fetch(backend + "?action=login&username=me&password=pwd")
        .then((response) => {
            if(!response.ok){ // Before parsing (i.e. decoding) the JSON data,
                              // check for any errors.
                // In case of an error, throw.
                throw new Error("Something went wrong!");
            }

            return response.json(); // Parse the JSON data.
            //return response;
        })
        .then((data) => {
             // This is where you handle what to do with the response.
             // alert(data); // Will alert: 42
            //print(data)
            //document.write(data)
            document.getElementById("demo").innerHTML = data.status;
            document.getElementById("authToken").innerHTML = data.authToken;
        })
        .catch((error) => {
             // This is where you handle errors.
            alert("there was an error ")
            throw new Error("Something went wrong!");
        });

</script>

e



