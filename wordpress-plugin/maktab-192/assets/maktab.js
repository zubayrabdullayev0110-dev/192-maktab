(function () {
  var root = document.getElementById('m192');
  if (!root) return;
  root.classList.add('m192-js');

  var reveal = root.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (es) {
      es.forEach(function (e) {
        if (e.isIntersecting) { e.target.classList.add('show'); io.unobserve(e.target); }
      });
    }, { threshold: 0.12 });
    reveal.forEach(function (el) { io.observe(el); });
  } else {
    reveal.forEach(function (el) { el.classList.add('show'); });
  }

  var menu = document.getElementById('m192-menu');
  var burger = root.querySelector('[data-m192-burger]');
  if (burger && menu) {
    burger.addEventListener('click', function () { menu.classList.toggle('open'); });
    menu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () { menu.classList.remove('open'); });
    });
  }

  var f = document.getElementById('m192-ariza');
  if (!f || !window.MAKTAB192) return;
  var ok = document.getElementById('m192-thanks');
  var err = document.getElementById('m192-err');
  var errDefault = err.textContent;

  f.addEventListener('submit', function (e) {
    e.preventDefault();
    var btn = f.querySelector('button[type="submit"]');
    ok.classList.remove('show'); err.classList.remove('show');
    btn.disabled = true;
    var body = new FormData(f);
    body.append('action', 'maktab192_ariza');
    body.append('nonce', MAKTAB192.nonce);
    fetch(MAKTAB192.ajax, { method: 'POST', body: body, credentials: 'same-origin' })
      .then(function (r) { return r.json().catch(function () { return {}; }); })
      .then(function (res) {
        if (res && res.success) { f.reset(); ok.classList.add('show'); return; }
        err.textContent = (res && res.data && res.data.message) || errDefault;
        err.classList.add('show');
      })
      .catch(function () { err.textContent = errDefault; err.classList.add('show'); })
      .then(function () { btn.disabled = false; });
  });
})();
