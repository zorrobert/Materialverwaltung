<?php
# this just loads the classes
require __DIR__ . '/vendor/autoload.php';
?>

<html lang="de" dir="ltr" data-bs-theme="dark">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title> Titel </title>
  </head>
  <body class="body">
    <body style="background-color: #4a7b38;"></body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    
    <table id="MaterialTabelle">
      <thead id="">
        Materialliste - 23.10.2024
      </thead>
      <tbody id="tableBody">
        <tr> 
          <th>Material</th>
          <th>Menge</th>
          <th>Status</th>
          <th>Ausleihen</th>
        </tr>     
      </tbody>
    </table>
<button id="testbutton" onclick="fetchingFunction()"> Test fetch</button>
<button onclick="checkCheckBox()">Check checks</button>
<button id="submitButton">SubmitButton</button>

<div>
  <button onclick="addListElementADMIN()">ADMIN</button>
</div>
<script>
  const tableBody = document.getElementById("tableBody")

  function fetchingFunction() {
    console.log("button clicked")

      	fetch('/beispieldaten.json') 
          .then(response => response.json())
          .then(data => createTable(data))
          .catch((error) => {
                console.error('Error:', error);
            });
       const but = document.getElementById("testbutton")
       but.setAttribute("disabled", "disabled")  
      }
  
  function createTable(data) {

    console.log(data.Materialien[0].material)
    console.log(data.Materialien.length)

    console.log(data)

    for (i = 0; i < data.Materialien.length; i++) {
      let newTableRow = document.createElement("tr")
      const tableBody = document.getElementById("tableBody")

      let newTableCell1 = document.createElement("td")
      let newTableCell2 = document.createElement("td")
      let newTableCell3 = document.createElement("td")
      let newTableCell4 = document.createElement("td")
      let newTableCell5 = document.createElement("td")

      //let tableCell4CheckBox = document.createElement("div")

      let tableCell4CheckBox = document.createElement("input")
      let tableCell5Input = document.createElement("input")

      newTableCell1.innerHTML= data.Materialien[i].material
      newTableCell2.innerHTML = data.Materialien[i].amount;
      newTableCell3.innerHTML = data.Materialien[i].augeliehen
      
      tableCell4CheckBox.setAttribute('type', 'checkbox')
      tableCell4CheckBox.setAttribute('id', data.Materialien[i].material)

      tableCell4CheckBox.className += "Klasse form-check-input"

      tableCell5Input.setAttribute('type', 'number')
      tableCell5Input.setAttribute('id', data.Materialien[i].material + "Amount")
      tableCell5Input.min = 0;
      tableCell5Input.className += "Amount"

     // document.tableCell4CheckBox.checked = true;
     
     
      // document.getElementById("option1");
      // check_val = option1.val();
      // console.log(check_val)
      // checkCheckBox();

      tableBody.appendChild(newTableRow)
      newTableRow.appendChild(newTableCell1)
      newTableRow.appendChild(newTableCell2)
      newTableRow.appendChild(newTableCell3)   
      newTableRow.appendChild(newTableCell5)

      newTableRow.appendChild(newTableCell4)
      newTableCell5.appendChild(tableCell5Input)
      newTableCell4.appendChild(tableCell4CheckBox);
    }
      const submitButton = document.getElementById("submitButton")
      submitButton.addEventListener("click", function() {
      submitList(data);
});
  }



// function checkCheckBox() {
//   const parentElement = document.getElementsByClassName("")
//   const childElements = parentElement.children;
//   for (const child of childElements) {
//     console.log(child.tagname)
//   }
//   check_val = tableCell4CheckBox.val
// }

function checkStorage(data, selectedAmount, passId) {
    console.log("checkstorage called")
    for (i = 0; i < data.Materialien.length; i++) {
      if(data.Materialien[i].material == passId) {
        if((data.Materialien[i].amount) < (selectedAmount)) {
          alert(`not enough of ${passId} in storage`)         
        } else {
          alert("enough on storage")    
          passListToBackEnd(data, selectedAmount, passId) 
        }
      }
  }
  }

  const parentElement = document.getElementsByClassName("Klasse form-check-input")
  const parentElementAmount = document.getElementsByClassName("Amount")

 function submitList(data) {
  console.log("submitlist called")

  for (const listElement of parentElement) {
        for (const listElementAmount of parentElementAmount) {
           if (listElement.checked && !(listElementAmount.value == null ||listElementAmount.value == 0 )) {
              let passId = listElement.id
              let selectedAmount = listElementAmount.value
              checkStorage(data, selectedAmount, passId)
              return;
            } 
            else if ((!(listElement.checked) && !(listElementAmount.value == null ||listElementAmount.value == 0 ))) {
              alert("checks are missing")
              return;
            } 
            else if(listElement.checked && (listElementAmount.value == null ||listElementAmount.value == 0 )) {
              alert("amount is missing")
              return;
            } 
          }     
      }  
 }
const username = "random"
const password = "pass"
 function passListToBackEnd(data, selectedAmount, passId) {
  for (i = 0; i < data.Materialien.length; i++) {
      if(data.Materialien[i].material == passId) {
      const checkjson = (data.Materialien[i].amount - selectedAmount)
      data.Materialien[i].amount == checkjson
        console.log(checkjson)
       
        
        //$.post("src/backend.php", data)

        // fetch('src/backend.php',{
        //   method: 'PUT',
        //   headers:{
        //   'Content-Type':'application/json'
        //   },
        //   body: JSON.stringify(data.Materialien[i].amount == checkjson)
        // })
      }
    }
    fetch('src/backend.php?action=dataentry', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            }) .then((response) => {
                if (!response.ok) {
                    throw new Error("Something went wrong!");
                }
                return response.json();
            })
  
            .catch((error) => {
                console.error('Error:', error);
            });
 }


 function addListElementADMIN() {
  const materialTable = document.getElementById("MaterialTabelle")
  const addListButton = document.createElement("button")
  addListButton.textContent = " + "
  materialTable.appendChild(addListButton)

  

  addListButton.addEventListener("click", () => {

    let tableRow = document.createElement("tr")
    tableBody.appendChild(tableRow)
     
    let tableCell1 = document.createElement("td")
    let inputField1 = document.createElement("input")     
   
   
    let tableCell2 = document.createElement("td")
    let inputField2 = document.createElement("input")
   // inputField2.setAttribute("type", "number", "min", '0')
    // inputField2-setAttribute("min", "0")
    inputField2.type = "number";
    inputField2.min = 0;


    let tableCell3 = document.createElement("td")
    
    let tableCell4 = document.createElement("td")
    let deleteButton = document.createElement("button")
    deleteButton.innerHTML += "X"
    tableCell4.appendChild(deleteButton)
    
 
    


    tableRow.appendChild(tableCell1)
    tableCell1.appendChild(inputField1)
    tableRow.appendChild(tableCell2)
    tableCell2.appendChild(inputField2)
    tableRow.appendChild(tableCell4)

    deleteButton.addEventListener("click", () => {
      tableRow.remove()
    })
   
  })
 }
  

 </script>
  </body>




</html>

