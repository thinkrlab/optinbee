/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
document.addEventListener('DOMContentLoaded', function () {
  var triggerButtons = document.querySelectorAll('.wp-element-button');
  var optinForms = document.querySelectorAll('.optinbee-modal-form');
  var closeButtons = document.querySelectorAll('.optinbee-close');
  var overlay = document.getElementById('optinbee-1'); // Change to your dynamic id

  triggerButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      overlay.classList.add('show-popup');
    });
  });
  optinForms.forEach(function (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
    });
  });
  closeButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      overlay.classList.remove('show-popup');
    });
  });
  overlay.addEventListener('click', function (event) {
    if (event.target === overlay) {
      overlay.classList.remove('show-popup');
    }
  });
});
/******/ })()
;
//# sourceMappingURL=optinbee.js.map