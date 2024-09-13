test
<!-- snip -->

<!-- snip -->


<p>this is html</p>

<?php
echo "<p>this is php</p>";


?>




<p id="demo">ee</p>

<p id="authToken">ee</p>


<script>
document.getElementById("demo").innerHTML = "script1";
</script>


<script>
    fetch("backend.php?action=login&username=me&password=pwd")
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
            // document.write(data)
            document.getElementById("demo").innerHTML = data.status;
            document.getElementById("authToken").innerHTML = data.authToken;
        })
        .catch((error) => {
             // This is where you handle errors.
            alert("there was an error ")
            throw new Error("Something went wrong!");
        });

</script>
