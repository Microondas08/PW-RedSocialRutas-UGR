// Obtener el campo de búsqueda y la etiqueta div para los resultados
const searchInput = document.getElementById("search");
const resultsContainer = document.createElement("div");
resultsContainer.classList.add("search-results"); // Agregar una clase CSS para estilizar los resultados
resultsContainer.style.display = "none"; // Establecer la propiedad "display" en "none" al inicio

document.addEventListener("DOMContentLoaded", function () {
  var searchInput = document.getElementById("search");
  searchInput.value = "";
});

// Función que maneja el evento de cambio en el campo de búsqueda
function handleSearchInput() {
  // Obtener el valor del campo de búsqueda
  const searchValue = searchInput.value;

  console.log(searchValue);

  // Verificar si el valor del campo de búsqueda es vacío
  if (searchValue.trim() === "") {
    // Si es vacío, borrar los resultados anteriores y ocultar el contenedor de resultados
    resultsContainer.innerHTML = "";
    resultsContainer.style.display = "none";
    return;
  }

  // Crear una nueva solicitud HTTP
  const xhr = new XMLHttpRequest();

  // Configurar la solicitud HTTP
  xhr.open("GET", `busqueda.php?searching_user=${searchValue}`);

  // Configurar la función de devolución de llamada que maneja la respuesta de la solicitud HTTP
  xhr.onload = function () {
    // Verificar si la solicitud se completó correctamente
    if (xhr.status === 200) {
      // Obtener los resultados de la respuesta
      const results = JSON.parse(xhr.responseText);

      // Borrar los resultados anteriores
      resultsContainer.innerHTML = "";

      // Crear una lista desordenada (ul) para mostrar los resultados
      const resultsList = document.createElement("ul");
      resultsList.classList.add("results-list"); // Agregar una clase CSS para estilizar la lista de resultados

      // Agregar los elementos de resultado a la lista
      results.forEach((result) => {
        const listItem = document.createElement("li");
        const resultLink = document.createElement("a");
        resultLink.href = `resultado_busqueda.php?searching_user=${result.user}`;
        const resultText = document.createTextNode(
          result.user 
        );
        resultLink.appendChild(resultText);
        listItem.appendChild(resultLink);
        resultsList.appendChild(listItem);
      });

      // Agregar la lista de resultados al contenedor
      resultsContainer.innerHTML = "";
      resultsContainer.appendChild(resultsList);

      // Mostrar el contenedor de resultados si se encontraron resultados
      resultsContainer.style.display = "block";
    } else {
      // Ocultar el contenedor de resultados si no se encontraron resultados
      resultsContainer.style.display = "none";
    }
  };

  // Enviar la solicitud HTTP
  xhr.send();
}

// Agregar el evento de cambio al campo de búsqueda
searchInput.addEventListener("input", handleSearchInput);

// Agregar el contenedor de resultados debajo del campo de búsqueda
searchInput.parentNode.insertBefore(resultsContainer, searchInput.nextSibling);
