const body = document.querySelector("body");
const fullPage = document.getElementById("fullpage");
const boxes = document.querySelectorAll(".box");

new fullpage(fullPage, {
  licenseKey: "OPEN-SOURCE-GPLV3-LICENSE",
  navigation: true,
  navigationPosition: "right",
  continuousVertical: true,
  css3: false,
  scrollOverflow: true,
  afterLoad: function (origin, destination, direction) {
    const activeSection = destination.item;
    if (activeSection.querySelector(".box")) {
      activeSection.querySelector(".box").classList.add("is-animated");
    }
  },
  onLeave: function (origin, destination, direction) {
    destination.isLast ?
    body.classList.add("fp-last") :
    body.classList.remove("fp-last");

    if (document.querySelector(".box.is-animated")) {
      document.
      querySelector(".box.is-animated").
      classList.remove("is-animated");
    }
  } });