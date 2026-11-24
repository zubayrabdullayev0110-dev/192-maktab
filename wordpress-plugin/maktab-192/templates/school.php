<?php
/**
 * 192-maktab sahifa belgisi. $o — sozlamalar massivi.
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
    <a href="<?php echo esc_url( get_permalink() ?: home_url( '/' ) ); ?>" class="logo"><div class="logo-badge">192</div><div>192-maktab<small>Shayxontohur tumani</small></div></a>
    <nav class="menu" id="m192-menu">
      <a href="#kuzatuv">Kuzatuv</a>
      <a href="#xavfsizlik">Xavfsizlik</a>
      <a href="#ustozlar">Ustozlar</a>
      <a href="#tillar">Tillar</a>
      <a href="#sport">Sport</a>
      <a href="#oshxona">Oshxona</a>
      <a href="#aloqa">Aloqa</a>
    </nav>
    <a href="#aloqa" class="btn btn-y">Ariza qoldirish</a>
    <button class="burger" aria-label="Menyu" aria-controls="m192-menu" data-m192-burger>☰</button>
  </div>
</header>

<section class="hero">
  <div class="wrap">
    <div class="board">
      <div class="board-grid">
        <div>
          <div class="date">Tillarga ixtisoslashtirilgan o‘rta maxsus maktab</div>
          <h1>192-maktabga <span class="hand">xush kelibsiz!</span></h1>
          <p>Shayxontohur tumanidagi oliy tizimdagi maktablardan biri. Xavfsiz muhit, oliy toifali ustozlar, ingliz va rus tillari, sport to‘garaklari — farzandingiz uchun barchasi bir joyda.</p>
          <div class="actions">
            <a href="#aloqa" class="btn btn-y">✏️ Farzandimni yozdirish</a>
            <a href="#kuzatuv" class="btn btn-w">Onlayn kuzatuv</a>
          </div>
          <div class="chalk-stats">
            <div><b>24/7</b>xavfsizlik</div>
            <div><b>2</b>chet tili</div>
            <div><b>4</b>sport to‘garagi</div>
          </div>
        </div>
        <div class="diary" aria-label="Elektron kundalik namunasi">
          <div class="pin"></div>
          <div class="diary-head">📒 Kundalik <small>namuna</small></div>
          <div class="kid">Azizbek, 5-«A» sinf</div>
          <ul>
            <li><span><span class="t">07:48</span>Maktabga kirdi</span><span class="stamp s-in">Face ID</span></li>
            <li><span><span class="t">10:15</span>Ingliz tili</span><span class="stamp s-grade">5</span></li>
            <li><span><span class="t">12:30</span>Tushlik</span><span class="stamp s-in">✓</span></li>
            <li><span><span class="t">14:00</span>Karate to‘garagi</span><span class="stamp s-in">✓</span></li>
            <li><span><span class="t">15:42</span>Maktabdan chiqdi</span><span class="stamp s-out">Face ID</span></li>
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
      <div><span class="tagline">Ota-onalar uchun</span><h2>Farzandingizni <span class="mark">onlayn</span> kuzating</h2></div>
      <p class="lead">Har kuni telefoningizda — farzandingiz qachon keldi, qachon ketdi va qanday o‘qiyapti.</p>
    </div>
    <div class="notes">
      <div class="note reveal"><div class="em">🕗</div><h3>Kelish va ketish vaqti</h3><p>Face ID orqali farzandingiz soat nechada kirganini va nechada chiqqanini darhol bilasiz.</p></div>
      <div class="note reveal"><div class="em">📊</div><h3>Har kungi ma’lumot</h3><p>Davomat, baholar va kun davomidagi faoliyat haqida kunlik hisobot.</p></div>
      <div class="note reveal"><div class="em">📱</div><h3>O‘qishini onlayn kuzatish</h3><p>Farzandingiz o‘zlashtirishini istagan payt, istagan joydan onlayn kuzatib boring.</p></div>
    </div>
  </div>
</section>

<section id="xavfsizlik" style="padding-top:20px">
  <div class="wrap">
    <div class="safety-box reveal">
      <div class="l">
        <span class="tagline">Xavfsizlik</span>
        <h2>Farzandingiz doimo ishonchli himoyada</h2>
        <p class="lead">Maktab hududi kecha-kunduz nazorat ostida. Xotirjam bo‘ling — bolajonlaringiz xavfsiz.</p>
        <ul class="checks">
          <li><div class="box">✓</div><div><b>24/7 videokuzatuv tizimi</b><span>Maktab hududi va binolari doimiy kuzatuvda.</span></div></li>
          <li><div class="box">✓</div><div><b>Harbiy tayyorgarlikdan o‘tgan qo‘riqchilar</b><span>Malakali soqchilar maktab kirish-chiqishini nazorat qiladi.</span></div></li>
          <li><div class="box">✓</div><div><b>Face ID tizimi</b><span>Har bir o‘quvchining kelish va ketish vaqti aniq qayd etiladi.</span></div></li>
        </ul>
      </div>
      <div class="r">
        <div class="shield" aria-hidden="true">🛡️</div>
        <strong>24/7</strong>
        <p>Kecha-kunduz xavfsizlik nazorati — bir daqiqa ham tanaffussiz.</p>
      </div>
    </div>
  </div>
</section>

<section id="ustozlar">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Jamoamiz</span><h2>Eng oliy toifadagi <span class="mark">ustozlar</span></h2></div>
      <p class="lead">Tajribali pedagoglar va psixologlar har bir bolaga alohida e’tibor qaratadi.</p>
    </div>
    <div class="teachers">
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#fff3b0">🎓</div><h3>Oliy toifali o‘qituvchilar</h3><p>Eng yuqori malaka toifasiga ega, tajribali o‘qituvchilar.</p></div>
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#cdeffd">📚</div><h3>Malakali pedagoglar</h3><p>Zamonaviy uslublar asosida dars o‘tadigan pedagoglar jamoasi.</p></div>
      <div class="t-card reveal"><span class="five" aria-hidden="true">5</span><div class="ic" style="background:#ffd6e0">💬</div><h3>Psixologlar</h3><p>Bolalarning ruhiy salomatligi va rivojlanishini kuzatuvchi mutaxassislar.</p></div>
    </div>
  </div>
</section>

<section id="tillar" style="padding-top:20px">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">Dars jadvali</span><h2>Tillarga <span class="mark">ixtisoslashtirilgan</span></h2></div>
      <p class="lead">O‘quvchilarimiz ingliz va rus tillarini chuqur o‘rganadi va mukammal egallaydi.</p>
    </div>
    <div class="timetable reveal">
      <div class="tt-row"><div class="tt-lbl" style="color:var(--blue)">Aa</div><div><h3>Ingliz tili</h3><p>Xalqaro imtihonlarga tayyorgarlik va erkin muloqot ko‘nikmalari.</p></div><span class="chip" style="background:#dbe8ff">English</span></div>
      <div class="tt-row"><div class="tt-lbl" style="color:var(--red)">Яя</div><div><h3>Rus tili</h3><p>Grammatika, adabiyot va ravon so‘zlashuv.</p></div><span class="chip" style="background:#ffe0e1">Русский</span></div>
    </div>
  </div>
</section>

<section class="sports" id="sport">
  <div class="wrap">
    <div class="head reveal">
      <div><span class="tagline">To‘garaklar</span><h2>Sport to‘garaklari</h2></div>
      <p class="lead">Sog‘lom tanda — sog‘lom aql. Farzandingiz o‘ziga yoqqan sport turini tanlaydi.</p>
    </div>
    <div class="badges">
      <div class="badge reveal"><div class="e" style="background:#fff3b0">🥋</div><h3>Karate</h3><p>Intizom, kuch va o‘zini himoya qilish</p></div>
      <div class="badge reveal"><div class="e" style="background:#dcf3e7">⚽</div><h3>Futbol</h3><p>Jamoaviy o‘yin va chidamlilik</p></div>
      <div class="badge reveal"><div class="e" style="background:#ffe3cf">🏀</div><h3>Basketbol</h3><p>Chaqqonlik va hamjihatlik</p></div>
      <div class="badge reveal"><div class="e" style="background:#e9e2ff">♟️</div><h3>Shaxmat</h3><p>Mantiqiy fikrlash va sabr</p></div>
    </div>
  </div>
</section>

<section id="oshxona">
  <div class="wrap food">
    <div class="reveal">
      <span class="tagline">Oshxona</span>
      <h2>Eng yuqori sifatdagi <span class="mark">taomlar</span></h2>
      <p class="lead">Bolajonlarimiz uchun mazali va foydali ovqatlar tayyorlanadi. Gigiyena va sifat ustidan qat’iy nazorat o‘rnatilgan.</p>
    </div>
    <div class="menu-card reveal">
      <div class="apple" aria-hidden="true">🍎</div>
      <h3>Bizning oshxona</h3>
      <ul>
        <li><span>🥗 Yangi va sifatli mahsulotlar</span><span>✓</span></li>
        <li><span>🧼 Qat’iy gigiyena nazorati</span><span>✓</span></li>
        <li><span>🍲 Issiq va to‘yimli taomlar</span><span>✓</span></li>
        <li><span>👩‍🍳 Tajribali oshpazlar</span><span>✓</span></li>
      </ul>
    </div>
  </div>
</section>

<section id="aloqa" style="padding-top:20px">
  <div class="wrap contact-grid">
    <div class="info reveal">
      <span class="tagline">Aloqa</span>
      <h2>Farzandingizni 192-maktabga yozdiring</h2>
      <p class="lead">Ariza qoldiring — tez orada siz bilan bog‘lanamiz.</p>
      <p>📍 <span><b>Manzil:</b> <?php echo esc_html( $o['address'] ); ?></span></p>
      <?php if ( $o['phone'] ) : ?><p class="phone-line">📞 <span><b>Telefon:</b> <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $o['phone'] ) ); ?>"><?php echo esc_html( $o['phone'] ); ?></a></span></p><?php endif; ?>
      <p>🧭 <span><b>Mo‘ljal:</b> <?php echo esc_html( $o['landmark'] ); ?></span></p>
      <p>🕗 <span><b>Ish vaqti:</b> <?php echo esc_html( $o['hours'] ); ?></span></p>
      <iframe class="map" title="Xarita: 192-maktab" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="<?php echo esc_url( $map_embed ); ?>"></iframe>
      <a class="btn btn-y" style="margin-top:16px" target="_blank" rel="noopener" href="<?php echo esc_url( $map_link ); ?>">📍 Xaritada ochish</a>
    </div>
    <div class="form-card reveal">
      <h3>✏️ Ariza varaqasi</h3>
      <form id="m192-ariza" method="POST">
        <p class="sr"><label>To‘ldirmang: <input name="bot_field" tabindex="-1" autocomplete="off"></label></p>
        <div class="row">
          <input required name="ota_ona" aria-label="Ota-onaning ismi" placeholder="Ota-onaning ismi" autocomplete="name">
          <input required name="telefon" type="tel" aria-label="Telefon raqam" placeholder="+998 90 123 45 67" autocomplete="tel" pattern="[+0-9 ()-]{9,}">
        </div>
        <div class="row">
          <input required name="farzand" aria-label="Farzandingiz ismi" placeholder="Farzandingiz ismi">
          <select required name="sinf" aria-label="Sinf">
            <option value="">Sinf</option>
            <option>1-sinf</option><option>2-sinf</option><option>3-sinf</option><option>4-sinf</option>
            <option>5-sinf</option><option>6-sinf</option><option>7-sinf</option><option>8-sinf</option>
            <option>9-sinf</option><option>10-sinf</option><option>11-sinf</option>
          </select>
        </div>
        <textarea name="savol" rows="4" aria-label="Savolingiz" placeholder="Savolingiz (ixtiyoriy)"></textarea>
        <button class="btn btn-y" type="submit">Ariza yuborish →</button>
        <div class="msg" id="m192-err">Xatolik yuz berdi. Iltimos, qayta urinib ko‘ring.</div>
        <div class="msg" id="m192-thanks" role="status">Rahmat! Arizangiz qabul qilindi. Tez orada bog‘lanamiz.</div>
      </form>
    </div>
  </div>
</section>

<footer>
  <div class="wrap">
    <span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> 192-maktab · Shayxontohur tumani</span>
    <span class="hand">Bu bizning maktab — 192-sonli o‘rta maxsus maktab</span>
  </div>
</footer>
</div>
