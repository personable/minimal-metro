const seenNag = localStorage.getItem("seenNag");

if (seenNag === "true") {
  removeNag();
}

function setNag() {
  localStorage.setItem("seenNag", "true");
  removeNag();
}

function removeNag () {
  const nag = document.querySelector('#nag');
  nag.parentNode.removeChild(nag);
}
