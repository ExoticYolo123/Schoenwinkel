<article class="schoen-card" data-merk="<?= veilig(mb_strtolower($schoen['merk'])) ?>" data-maat="<?= veilig(maatWeergave($schoen['maat'])) ?>">
  <?php $foto = schoenFoto($schoen['afbeelding'] ?? null); ?>
  <?php if ($foto): ?><img src="<?= veilig($foto) ?>" alt="<?= veilig($schoen['naam']) ?>" loading="lazy">
  <?php else: ?><div class="geen-foto">Geen foto beschikbaar</div><?php endif; ?>
  <div class="schoen-info">
    <span class="label <?= $schoen['conditie']==='Nieuw'?'nieuw':'tweedehands' ?>"><?= veilig($schoen['conditie']) ?></span>
    <h3><?= veilig($schoen['naam']) ?></h3>
    <p>Maat <?= veilig(maatWeergave($schoen['maat'])) ?> · <?= veilig($schoen['merk']) ?></p>
    <p>Verkoper: <?= veilig($schoen['verkoper']) ?></p>
    <p class="prijs">€<?= number_format((float)$schoen['prijs'],2,',','.') ?></p>
    <a class="bekijk-knop" href="/schoen.php?id=<?= (int)$schoen['id'] ?>">Bekijk schoen</a>
  </div>
</article>
