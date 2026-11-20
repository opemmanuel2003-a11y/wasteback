(function () {
    'use strict';

    // Toggles for the public menu and the portal sidebar
    document.querySelectorAll('[data-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var target = document.getElementById(btn.getAttribute('data-toggle'));
            if (!target) return;
            var open = target.classList.toggle('open');
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    });

    var money = function (n) {
        return 'UGX ' + Math.round(n).toLocaleString('en-US');
    };

    // Live price quote: any form with [data-quote] holding inputs with data-price
    document.querySelectorAll('[data-quote]').forEach(function (form) {
        var inputs = form.querySelectorAll('input[data-price]');
        var totalEl = form.querySelector('[data-quote-total]');
        var kgEl = form.querySelector('[data-quote-kg]');

        var update = function () {
            var total = 0, kg = 0;
            inputs.forEach(function (input) {
                var value = parseFloat(input.value) || 0;
                if (value < 0) value = 0;
                var amount = value * parseFloat(input.getAttribute('data-price'));
                var line = form.querySelector('[data-line="' + input.getAttribute('data-id') + '"]');
                if (line) line.textContent = money(amount);
                total += amount;
                kg += value;
            });
            if (totalEl) totalEl.textContent = money(total);
            if (kgEl) kgEl.textContent = (Math.round(kg * 100) / 100) + ' kg';
        };

        inputs.forEach(function (input) { input.addEventListener('input', update); });
        update();
    });

    // Confirm buttons
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm(form.getAttribute('data-confirm'))) e.preventDefault();
        });
    });
})();

/* Light and dark mode. The theme is applied in the page head before first
   paint; this only handles clicks on the toggle and remembers the choice. */
(function () {
    'use strict';

    var KEY = 'wasteback-theme';
    var root = document.documentElement;

    var isDark = function () { return root.getAttribute('data-theme') === 'dark'; };

    var label = function (btn) {
        btn.setAttribute('aria-label', isDark() ? 'Switch to light mode' : 'Switch to dark mode');
        btn.setAttribute('aria-pressed', isDark() ? 'true' : 'false');
    };

    document.querySelectorAll('[data-theme-toggle]').forEach(function (btn) {
        label(btn);
        btn.addEventListener('click', function () {
            root.setAttribute('data-theme', isDark() ? 'light' : 'dark');
            try { localStorage.setItem(KEY, root.getAttribute('data-theme')); } catch (e) {}
            label(btn);
        });
    });
})();