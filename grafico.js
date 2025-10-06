async function dibujarHistograma() {
  const resp = await fetch("histograma.json");
  const datos = await resp.json();

  const labels = Array.from({ length: 256 }, (_, i) => i);

  const ctx = document.getElementById("grafico").getContext("2d");
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
      scales: {
        x: { title: { display: true, text: "Valor (0–255)" } },
        y: { title: { display: true, text: "Frecuencia" } }
      }
    }
  });
}

dibujarHistograma();
