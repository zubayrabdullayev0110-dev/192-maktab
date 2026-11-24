<?php
/**
 * 192-мактаб саҳифа белгиси. $o — созламалар массиви.
 *
 * @package Maktab192
 */

defined( 'ABSPATH' ) || exit;

$o         = maktab192_options();
$coords    = rawurlencode( $o['lat'] . ',' . $o['lng'] );
$map_embed = 'https://maps.google.com/maps?q=' . $coords . '&z=17&output=embed';
$map_link  = 'https://www.google.com/maps/search/?api=1&query=' . $coords;
?>
<div class="m192" id="m192">
<div class="ruler" aria-hidden="true"></div>
<header>
  <div class="wrap nav">
    <a href="<?php echo esc_url( get_permalink() ?: home_url( '/' ) ); ?>" class="logo"><div class="logo-badge">192</div><div>192-мактаб<small>Шайхонтоҳур тумани</small></div></a>
    <nav class="menu" id="m192-menu">
      <a href="#kuzatuv">Кузатув</a>
      <a href="#xavfsizlik">Хавфсизлик</a>
      <a href="#ustozlar">Устозлар</a>
      <a href="#tillar">Тиллар</a>
      <a href="#sport">Спорт</a>
      <a href="#oshxona">Ошхона</a>
      <a href="#aloqa">Алоқа</a>
    </nav>
    <a href="#aloqa" class="btn btn-y">Ариза қолдириш</a>
    <button class="burger" aria-label="Меню" aria-controls="m192-menu" data-m192-burger>☰</button>
  </div>
</header>

<section class="hero">
  <div class="wrap">
    <div class="board">
      <div class="board-grid">
        <div>
          <div class="date">Тилларга ихтисослаштирилган ўрта махсус мактаб</div>
          <h1>192-мактабга <span class="hand">хуш келибсиз!</span></h1>
          <p>Шайхонтоҳур туманидаги олий тизимдаги мактаблардан бири. Хавфсиз муҳит, олий тоифали устозлар, инглиз ва рус тиллари ва спорт тўгараклари — фарзандингиз учун барчаси бир жойда.</p>
          <div class="actions">
            <a href="#aloqa" class="btn btn-y">✏️ Фарзандимни ёздириш</a>
            <a href="#kuzatuv" class="btn btn-w">Онлайн кузатув</a>
          </div>
          <div class="chalk-stats">
            <div><b>24/7</b>хавфсизлик</div>
            <div><b>2</b>чет тили</div>
            <div><b>4</b>спорт тўгараги</div>
          </div>
        </div>
        <div class="diary" aria-label="Электрон кундалик намунаси">
          <div class="pin"></div>
          <div class="diary-head">📒 Кундалик <small>намуна</small></div>
          <div class="kid">Азизбек, 5-«А» синф</div>
          <ul>
            <li><span><span class="t">07:48</span>Мактабга кирди</span><span class="stamp s-in">Face ID</span></li>
            <li><span><span class="t">10:15</span>Инглиз тили</span><span class="stamp s-grade">5</span></li>
            <li><span><span class="t">12:30</span>Тушлик</span><span class="stamp s-in">✓</span></li>
            <li><span><span class="t">14:00</span>Карате тўгараги</span><span class="stamp s-in">✓</span></li>
            <li><span><span class="t">15:42</span>Мактабдан чиқди</span><span class="stamp s-out">Face ID</span></li>
            <li></li>
          </ul>
        </div>
      </div>
      <div class="tray" aria-hidden="true"><i></i><i></i><i></i></div>
    </div>
  </div>
</section>

<section id="kuzatuv" style="padding-top:30px">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Ота-оналар учун</span><h2>Фарзандингизни <span class="mark">онлайн</span> кузатинг</h2></div>
      <p class="lead">Ҳар куни телефонингизда — фарзандингиз қачон келди, қачон кетди ва қандай ўқияпти.</p>
    </div>
    <div class="notes">
      <div class="note reveal"><div class="em">🕗</div><h3>Келиш ва кетиш вақти</h3><p>Face ID орқали фарзандингиз соат нечада кирганини ва нечада чиққанини дарҳол биласиз.</p></div>
      <div class="note reveal"><div class="em">📊</div><h3>Ҳар кунги маълумот</h3><p>Давомат, баҳолар ва кун давомидаги фаолият ҳақида кунлик ҳисобот.</p></div>
      <div class="note reveal"><div class="em">📱</div><h3>Ўқишини онлайн кузатиш</h3><p>Фарзандингиз ўзлаштиришини истаган пайт, истаган жойдан онлайн кузатиб боринг.</p></div>
    </div>
  </div>
</section>

<section id="xavfsizlik" style="padding-top:20px">
  <div class="wrap">
    <div class="safety-box reveal">
      <div class="l">
        <span class="tagline">Хавфсизлик</span>
        <h2>Фарзандингиз доимо ишончли ҳимояда</h2>
        <p class="lead">Мактаб ҳудуди кеча-кундуз назорат остида. Хотиржам бўлинг — болажонларингиз хавфсиз.</p>
        <ul class="checks">
          <li><div class="box">✓</div><div><b>24/7 видеокузатув тизими</b><span>Мактаб ҳудуди ва бинолари доимий кузатувда.</span></div></li>
          <li><div class="box">✓</div><div><b>Ҳарбий тайёргарликдан ўтган қўриқчилар</b><span>Малакали соқчилар мактаб кириш-чиқишини назорат қилади.</span></div></li>
          <li><div class="box">✓</div><div><b>Face ID тизими</b><span>Ҳар бир ўқувчининг келиш ва кетиш вақти аниқ қайд этилади.</span></div></li>
        </ul>
      </div>
      <div class="r">
        <div class="shield" aria-hidden="true">🛡️</div>
        <strong>24/7</strong>
        <p>Кеча-кундуз хавфсизлик назорати — бир дақиқа ҳам танаффуссиз.</p>
      </div>
    </div>
  </div>
</section>

<section id="ustozlar">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Жамоамиз</span><h2>Энг олий тоифадаги <span class="mark">устозлар</span></h2></div>
      <p class="lead">Тажрибали педагоглар ва психологлар ҳар бир болага алоҳида эътибор қаратади.</p>
    </div>
    <div class="teachers">
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#fff3b0">🎓</div><h3>Олий тоифали ўқитувчилар</h3><p>Энг юқори малака тоифасига эга, тажрибали ўқитувчилар.</p></div>
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#cdeffd">📚</div><h3>Малакали педагоглар</h3><p>Замонавий услублар асосида дарс ўтадиган педагоглар жамоаси.</p></div>
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#ffd6e0">💬</div><h3>Психологлар</h3><p>Болаларнинг руҳий саломатлиги ва ривожланишини кузатувчи мутахассислар.</p></div>
    </div>
  </div>
</section>

<section id="tillar" style="padding-top:20px">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Дарс жадвали</span><h2>Тилларга <span class="mark">ихтисослаштирилган</span></h2></div>
      <p class="lead">Ўқувчиларимиз инглиз ва рус тилларини чуқур ўрганади ва мукаммал эгаллайди.</p>
    </div>
    <div class="timetable reveal">
      <div class="tt-row"><div class="tt-lbl" style="color:var(--blue)">Aa</div><div><h3>Инглиз тили</h3><p>Халқаро имтиҳонларга тайёргарлик ва эркин мулоқот кўникмалари.</p></div><span class="chip" style="background:#dbe8ff">English</span></div>
      <div class="tt-row"><div class="tt-lbl" style="color:var(--red)">Яя</div><div><h3>Рус тили</h3><p>Грамматика, адабиёт ва равон сўзлашув.</p></div><span class="chip" style="background:#ffe0e1">Русский</span></div>
    </div>
  </div>
</section>

<section class="sports" id="sport">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Тўгараклар</span><h2>Спорт тўгараклари</h2></div>
      <p class="lead">Соғлом танда — соғлом ақл. Фарзандингиз ўзига ёққан спорт турини танлайди.</p>
    </div>
    <div class="badges">
      <div class="badge reveal"><div class="e" style="background:#fff3b0">🥋</div><h3>Карате</h3><p>Интизом, куч ва ўзини ҳимоя қилиш</p></div>
      <div class="badge reveal"><div class="e" style="background:#dcf3e7">⚽</div><h3>Футбол</h3><p>Жамоавий ўйин ва чидамлилик</p></div>
      <div class="badge reveal"><div class="e" style="background:#ffe3cf">🏀</div><h3>Баскетбол</h3><p>Чаққонлик ва ҳамжиҳатлик</p></div>
      <div class="badge reveal"><div class="e" style="background:#e9e2ff">♟️</div><h3>Шахмат</h3><p>Мантиқий фикрлаш ва сабр</p></div>
    </div>
  </div>
</section>

<section id="oshxona">
  <div class="wrap food">
    <div class="reveal">
      <span class="tagline">Ошхона</span>
      <h2>Энг юқори сифатдаги <span class="mark">таомлар</span></h2>
      <p class="lead">Болажонларимиз учун мазали ва фойдали овқатлар тайёрланади. Гигиена ва сифат устидан қатъий назорат ўрнатилган.</p>
    </div>
    <div class="menu-card reveal">
      <div class="apple" aria-hidden="true">🍎</div>
      <h3>Бизнинг ошхона</h3>
      <ul>
        <li><span>🥗 Янги ва сифатли маҳсулотлар</span><span>✓</span></li>
        <li><span>🧼 Қатъий гигиена назорати</span><span>✓</span></li>
        <li><span>🍲 Иссиқ ва тўйимли таомлар</span><span>✓</span></li>
        <li><span>👩‍🍳 Тажрибали ошпазлар</span><span>✓</span></li>
      </ul>
    </div>
  </div>
</section>

<section id="aloqa" style="padding-top:20px">
  <div class="wrap contact-grid">
    <div class="info reveal">
      <span class="tagline">Алоқа</span>
      <h2>Фарзандингизни 192-мактабга ёздиринг</h2>
      <p class="lead">Ариза қолдиринг — тез орада сиз билан боғланамиз.</p>
      <p>📍 <span><b>Манзил:</b> <?php echo esc_html( $o['address'] ); ?></span></p>
      <?php if ( $o['phone'] ) : ?><p class="phone-line">📞 <span><b>Телефон:</b> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $o['phone'] ) ); ?>"><?php echo esc_html( $o['phone'] ); ?></a></span></p><?php endif; ?>
      <p>🧭 <span><b>Мўлжал:</b> <?php echo esc_html( $o['landmark'] ); ?></span></p>
      <p>🕗 <span><b>Иш вақти:</b> <?php echo esc_html( $o['hours'] ); ?></span></p>
      <iframe class="map" title="Харита: 192-мактаб" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="<?php echo esc_url( $map_embed ); ?>"></iframe>
      <a class="btn btn-y" style="margin-top:16px" target="_blank" rel="noopener" href="<?php echo esc_url( $map_link ); ?>">📍 Харитада очиш</a>
    </div>
    <div class="form-card reveal">
      <h3>✏️ Ариза варақаси</h3>
      <form id="m192-ariza" method="POST">
        <p class="sr"><label>Тўлдирманг: <input name="bot_field" tabindex="-1" autocomplete="off"></label></p>
        <div class="row">
          <input required name="ota_ona" aria-label="Ота-онанинг исми" placeholder="Ота-онанинг исми" autocomplete="name">
          <input required name="telefon" type="tel" aria-label="Телефон рақам" placeholder="+998 90 123 45 67" autocomplete="tel" pattern="[+0-9 ()-]{9,}">
        </div>
        <div class="row">
          <input required name="farzand" aria-label="Фарзандингиз исми" placeholder="Фарзандингиз исми">
          <select required name="sinf" aria-label="Синф">
            <option value="">Синф</option>
            <option>1-синф</option><option>2-синф</option><option>3-синф</option><option>4-синф</option>
            <option>5-синф</option><option>6-синф</option><option>7-синф</option><option>8-синф</option>
            <option>9-синф</option><option>10-синф</option><option>11-синф</option>
          </select>
        </div>
        <textarea name="savol" rows="4" aria-label="Саволингиз" placeholder="Саволингиз (ихтиёрий)"></textarea>
        <button class="btn btn-y" type="submit">Ариза юбориш →</button>
        <div class="msg" id="m192-err">Хатолик юз берди. Илтимос, қайта уриниб кўринг.</div>
        <div class="msg" id="m192-thanks" role="status">Раҳмат! Аризангиз қабул қилинди. Тез орада боғланамиз.</div>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="wrap">
    <span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> 192-мактаб · Шайхонтоҳур тумани</span>
    <span class="hand">Бу бизнинг мактаб — 192-сонли ўрта махсус мактаб</span>
  </div>
</footer>
</div>
