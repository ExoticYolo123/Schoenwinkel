document.addEventListener('DOMContentLoaded', () => {
  const zoek = document.getElementById('zoekInput');
  const merk = document.getElementById('merkFilter');
  const maat = document.getElementById('maatFilter');
  const kaarten = [...document.querySelectorAll('#schoenenLijst .schoen-card')];
  const resultaten = document.getElementById('resultaten');
  const leeg = document.getElementById('geenResultaten');
  if (zoek && merk && maat && resultaten && leeg) {
    const filter = () => {
      let aantal = 0;
      kaarten.forEach(kaart => {
        const naam = kaart.querySelector('h3')?.textContent.toLocaleLowerCase('nl') || '';
        const zichtbaar = naam.includes(zoek.value.trim().toLocaleLowerCase('nl')) &&
          (merk.value === 'alles' || kaart.dataset.merk === merk.value) &&
          (maat.value === 'alles' || Number(kaart.dataset.maat) === Number(maat.value));
        kaart.hidden = !zichtbaar;
        if (zichtbaar) aantal++;
      });
      resultaten.textContent = `${aantal} schoenen gevonden`;
      leeg.hidden = aantal !== 0;
    };
    zoek.addEventListener('input', filter);
    merk.addEventListener('change', filter);
    maat.addEventListener('change', filter);
    filter();
  }
  document.querySelectorAll('form[data-confirm]').forEach(form => form.addEventListener('submit', event => {
    if (!confirm(form.dataset.confirm || 'Weet je het zeker?')) event.preventDefault();
  }));
  const menu = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.site-nav');
  if (menu && nav) menu.addEventListener('click', () => {
    const open = nav.classList.toggle('open');
    menu.setAttribute('aria-expanded', String(open));
  });
});
