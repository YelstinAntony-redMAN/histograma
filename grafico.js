async function dibujarHistograma() {
  try {
    // Cargar el archivo JSON generado por PHP
    const resp = await fetch("histograma.json");

    // Verificar si la respuesta fue exitosa
    if (!resp.ok) {
      throw new Error("No se pudo cargar el archivo histograma.json");
    }

    const datos = await resp.json();

    // Crear etiquetas de 0 a 255
    const labels = Array.from({ length: 256 }, (_, i) => i);

    // Obtener el contexto del canvas
    const canvas = document.getElementById("grafico");
    if (!canvas) {
      throw new Error("No se encontró el elemento canvas con id 'grafico'.");
    }

    const ctx = canvas.getContext("2d");

    // Crear el gráfico usando Chart.js
    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          { label: "Rojo", data: datos.R, borderColor: "red", borderWidth: 1 },
          { label: "Verde", data: datos.G, borderColor: "green", borderWidth: 1 },
          { label: "Azul", data: datos.B, borderColor: "blue", borderWidth: 1 }
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
            position: "top"
          },
          title: {
            display: true,
            text: "Histograma RGB de la Imagen"
          }
        },
        scales: {
          x: {
            title: {
              display: true,
              text: "Valor (0–255)"
            }
          },
          y: {
            title: {
              display: true,
              text: "Frecuencia"
            },
            beginAtZero: true
          }
        }
      }
    });

  } catch (error) {
    console.error("Error al dibujar el histograma:", error);
    alert("Ocurrió un error al generar el gráfico. Revisa la consola.");
  }
}

// Ejecutar la función al cargar la página
window.addEventListener("DOMContentLoaded", dibujarHistograma);
