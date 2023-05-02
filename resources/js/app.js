import './bootstrap';

import Alpine from 'alpinejs';
import Inputmask from "inputmask";

window.Alpine = Alpine;

Alpine.start();

window.applyDecimalMask = function(selector) {
    Inputmask({
      alias: "decimal",
      groupSeparator: ",",
      autoGroup: true,
      radixPoint: ".",
      digits: 2,
      rightAlign: false,
    }).mask(selector);
};

document.addEventListener("DOMContentLoaded", function () {
    applyDecimalMask("#budget_it_investment");
    applyDecimalMask("#budget_it_operating");
    applyDecimalMask("#budget_gov_utility");
});

