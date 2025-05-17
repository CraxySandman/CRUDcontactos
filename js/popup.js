function mostrarPopup(mensaje, info1, info2, info3, info4, urlDestino, claveUsuario) {

  const capaFondo = document.createElement("div");
  capaFondo.classList.add("popup-overlay");

  const contenedorPopup = document.createElement("div");
  contenedorPopup.classList.add("popup");

  const formulario = document.createElement("form");
  formulario.action = urlDestino;
  formulario.method = "POST";

  const campoClave = document.createElement("input");
  campoClave.type = "hidden";
  campoClave.name = "txtClave";
  campoClave.value = claveUsuario;

  const campoOperacion = document.createElement("input");
  campoOperacion.type = "hidden";
  campoOperacion.name = "txtOpe";
  campoOperacion.value = "b";

  formulario.appendChild(campoClave);
  formulario.appendChild(campoOperacion);

  const titulo = document.createElement("h4");
  titulo.textContent = mensaje;

  const parrafo1 = document.createElement("p");
  parrafo1.textContent = info1;
  const parrafo2 = document.createElement("p");
  parrafo2.textContent = info2;
  const parrafo3 = document.createElement("p");
  parrafo3.textContent = info3;
  const parrafo4 = document.createElement("p");
  parrafo4.textContent = info4;

  formulario.appendChild(titulo);
  formulario.appendChild(parrafo1);
  formulario.appendChild(parrafo2);
  formulario.appendChild(parrafo3);
  formulario.appendChild(parrafo4);

  const botonBorrar = document.createElement("input");
  botonBorrar.type = "submit";
  botonBorrar.name = "Submit";
  botonBorrar.value = "Borrar";

  const botonCancelar = document.createElement("button");
  botonCancelar.type = "button";
  botonCancelar.textContent = "Cancelar";
  botonCancelar.addEventListener("click", function () {
    document.body.removeChild(capaFondo);
  });

  formulario.appendChild(botonBorrar);
  formulario.appendChild(botonCancelar);
  contenedorPopup.appendChild(formulario);

  capaFondo.appendChild(contenedorPopup);
  document.body.appendChild(capaFondo);
}
