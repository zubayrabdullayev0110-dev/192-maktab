"""Build ru/index.html and en/index.html from the Uzbek (Latin) index.html.

Usage (from the repo root):  python tools/i18n.py
Every Uzbek string below must exist in index.html; the script stops if one is missing,
so after editing index.html update the matching entry here and re-run.
"""
import io
import os
import re
import sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

# (uz, ru, en)
T = [
    ('<html lang="uz">', '<html lang="ru">', '<html lang="en">'),
    ('192-maktab — Shayxontohur tumanidagi tillarga ixtisoslashtirilgan o‘rta maxsus maktab. 24/7 xavfsizlik, Face ID nazorati, oliy toifali o‘qituvchilar, sport to‘garaklari.',
     'Школа №192 — специализированная средняя школа с углублённым изучением языков в Шайхантахурском районе Ташкента. Охрана 24/7, Face ID, учителя высшей категории, спортивные секции.',
     'School No. 192 — a language-specialized secondary school in Shaykhontohur district, Tashkent. 24/7 security, Face ID, top-category teachers, sports clubs.'),
    ('Tillarga ixtisoslashtirilgan o‘rta maxsus maktab: 24/7 xavfsizlik, Face ID, oliy toifali ustozlar, sport to‘garaklari.',
     'Специализированная школа с углублённым изучением языков: охрана 24/7, Face ID, учителя высшей категории, спортивные секции.',
     'Language-specialized secondary school: 24/7 security, Face ID, top-category teachers, sports clubs.'),
    ('192-maktab — Shayxontohur', 'Школа №192 — Шайхантахур', 'School No. 192 — Shaykhontohur'),
    ('192-maktab<small>Shayxontohur tumani</small>', 'Школа №192<small>Шайхантахурский район</small>', 'School No. 192<small>Shaykhontohur district</small>'),
    ('>Kuzatuv</a>', '>Контроль</a>', '>Tracking</a>'),
    ('>Xavfsizlik</a>', '>Безопасность</a>', '>Safety</a>'),
    ('>Ustozlar</a>', '>Учителя</a>', '>Teachers</a>'),
    ('>Tillar</a>', '>Языки</a>', '>Languages</a>'),
    ('#sport">Sport</a>', '#sport">Спорт</a>', '#sport">Sports</a>'),
    ('>Oshxona</a>', '>Столовая</a>', '>Canteen</a>'),
    ('>Aloqa</a>', '>Контакты</a>', '>Contact</a>'),
    ('Ariza qoldirish', 'Оставить заявку', 'Apply now'),
    ('aria-label="Menyu"', 'aria-label="Меню"', 'aria-label="Menu"'),
    ('<div class="date">Tillarga ixtisoslashtirilgan o‘rta maxsus maktab</div>',
     '<div class="date">Специализированная школа с углублённым изучением языков</div>',
     '<div class="date">Language-specialized secondary school</div>'),
    ('<h1>192-maktabga <span class="hand">xush kelibsiz!</span></h1>',
     '<h1><span class="hand">Добро пожаловать</span> в школу №192!</h1>',
     '<h1><span class="hand">Welcome</span> to School No. 192!</h1>'),
    ('Shayxontohur tumanidagi yetakchi maktablardan biri. Xavfsiz muhit, oliy toifali ustozlar, ingliz va rus tillari, sport to‘garaklari — farzandingiz uchun barchasi bir joyda.',
     'Одна из ведущих школ Шайхантахурского района. Безопасная среда, учителя высшей категории, английский и русский языки, спортивные секции — всё для вашего ребёнка в одном месте.',
     'One of the leading schools in Shaykhontohur district. A safe environment, top-category teachers, English and Russian, and sports clubs — everything your child needs in one place.'),
    ('✏️ Farzandimni yozdirish', '✏️ Записать ребёнка', '✏️ Enroll my child'),
    ('>Onlayn kuzatuv</a>', '>Онлайн-контроль</a>', '>Online tracking</a>'),
    ('<b>24/7</b>xavfsizlik', '<b>24/7</b>охрана', '<b>24/7</b>security'),
    ('<b>2</b>chet tili', '<b>2</b>иностранных языка', '<b>2</b>foreign languages'),
    ('<b>4</b>sport to‘garagi', '<b>4</b>спортивные секции', '<b>4</b>sports clubs'),
    ('aria-label="Elektron kundalik namunasi"', 'aria-label="Пример электронного дневника"', 'aria-label="Sample e-diary"'),
    ('📒 Kundalik <small>namuna</small>', '📒 Дневник <small>пример</small>', '📒 Diary <small>sample</small>'),
    ('Azizbek, 5-«A» sinf', 'Азизбек, 5 «А» класс', 'Azizbek, Grade 5A'),
    ('</span>Maktabga kirdi</span>', '</span>Пришёл в школу</span>', '</span>Arrived at school</span>'),
    ('</span>Ingliz tili</span>', '</span>Английский</span>', '</span>English</span>'),
    ('</span>Tushlik</span>', '</span>Обед</span>', '</span>Lunch</span>'),
    ('</span>Karate to‘garagi</span>', '</span>Секция карате</span>', '</span>Karate club</span>'),
    ('</span>Maktabdan chiqdi</span>', '</span>Ушёл из школы</span>', '</span>Left school</span>'),
    ('Ota-onalar uchun', 'Для родителей', 'For parents'),
    ('<h2>Farzandingizni <span class="mark">onlayn</span> kuzating</h2>',
     '<h2>Следите за ребёнком <span class="mark">онлайн</span></h2>',
     '<h2>Follow your child <span class="mark">online</span></h2>'),
    ('Har kuni telefoningizda — farzandingiz qachon keldi, qachon ketdi va qanday o‘qiyapti.',
     'Каждый день на вашем телефоне — когда ребёнок пришёл, когда ушёл и как учится.',
     'Every day on your phone — when your child arrived, when they left and how they are doing in class.'),
    ('<h3>Kelish va ketish vaqti</h3>', '<h3>Время прихода и ухода</h3>', '<h3>Arrival and departure</h3>'),
    ('Face ID orqali farzandingiz soat nechada kirganini va nechada chiqqanini darhol bilasiz.',
     'Благодаря Face ID вы сразу узнаете, во сколько ребёнок пришёл и во сколько ушёл.',
     'With Face ID you instantly know what time your child came in and what time they left.'),
    ('<h3>Har kungi ma’lumot</h3>', '<h3>Ежедневная информация</h3>', '<h3>Daily updates</h3>'),
    ('Davomat, baholar va kun davomidagi faoliyat haqida kunlik hisobot.',
     'Ежедневный отчёт о посещаемости, оценках и занятиях в течение дня.',
     'A daily report on attendance, grades and activities throughout the day.'),
    ('<h3>O‘qishini onlayn kuzatish</h3>', '<h3>Успеваемость онлайн</h3>', '<h3>Track progress online</h3>'),
    ('Farzandingiz o‘zlashtirishini istagan payt, istagan joydan onlayn kuzatib boring.',
     'Следите за успеваемостью ребёнка онлайн — в любое время и из любого места.',
     'Follow your child’s progress online — anytime, anywhere.'),
    ('<span class="tagline">Xavfsizlik</span>', '<span class="tagline">Безопасность</span>', '<span class="tagline">Safety</span>'),
    ('<h2>Farzandingiz doimo ishonchli himoyada</h2>', '<h2>Ваш ребёнок всегда под надёжной защитой</h2>', '<h2>Your child is always safe with us</h2>'),
    ('Maktab hududi kecha-kunduz nazorat ostida. Xotirjam bo‘ling — bolajonlaringiz xavfsiz.',
     'Территория школы под круглосуточным наблюдением. Будьте спокойны — ваши дети в безопасности.',
     'The school grounds are monitored around the clock. Rest easy — your children are safe.'),
    ('<b>24/7 videokuzatuv tizimi</b>', '<b>Видеонаблюдение 24/7</b>', '<b>24/7 CCTV system</b>'),
    ('Maktab hududi va binolari doimiy kuzatuvda.', 'Территория и здания школы под постоянным наблюдением.', 'School grounds and buildings are under constant surveillance.'),
    ('<b>Harbiy tayyorgarlikdan o‘tgan qo‘riqchilar</b>', '<b>Охрана с военной подготовкой</b>', '<b>Guards with military training</b>'),
    ('Malakali soqchilar maktab kirish-chiqishini nazorat qiladi.', 'Квалифицированные охранники контролируют вход и выход.', 'Qualified guards control every entrance and exit.'),
    ('<b>Face ID tizimi</b>', '<b>Система Face ID</b>', '<b>Face ID system</b>'),
    ('Har bir o‘quvchining kelish va ketish vaqti aniq qayd etiladi.', 'Время прихода и ухода каждого ученика точно фиксируется.', 'Every student’s arrival and departure time is recorded precisely.'),
    ('Kecha-kunduz xavfsizlik nazorati — bir daqiqa ham tanaffussiz.', 'Круглосуточная охрана — без единой минуты перерыва.', 'Round-the-clock security — not a single minute off.'),
    ('Jamoamiz', 'Наша команда', 'Our team'),
    ('<h2>Oliy toifali <span class="mark">ustozlar</span></h2>',
     '<h2><span class="mark">Учителя</span> высшей категории</h2>',
     '<h2>Top-category <span class="mark">teachers</span></h2>'),
    ('Tajribali pedagoglar va psixologlar har bir bolaga alohida e’tibor qaratadi.',
     'Опытные педагоги и психологи уделяют внимание каждому ребёнку.',
     'Experienced educators and psychologists give every child individual attention.'),
    ('<h3>Oliy toifali o‘qituvchilar</h3>', '<h3>Учителя высшей категории</h3>', '<h3>Top-category teachers</h3>'),
    ('Eng yuqori malaka toifasiga ega, tajribali o‘qituvchilar.', 'Опытные учителя с высшей квалификационной категорией.', 'Experienced teachers holding the highest qualification category.'),
    ('<h3>Malakali pedagoglar</h3>', '<h3>Квалифицированные педагоги</h3>', '<h3>Qualified educators</h3>'),
    ('Zamonaviy uslublar asosida dars o‘tadigan pedagoglar jamoasi.', 'Команда педагогов, работающих по современным методикам.', 'A team of educators using modern teaching methods.'),
    ('<h3>Psixologlar</h3>', '<h3>Психологи</h3>', '<h3>Psychologists</h3>'),
    ('Bolalarning ruhiy salomatligi va rivojlanishini kuzatuvchi mutaxassislar.',
     'Специалисты, которые следят за психологическим здоровьем и развитием детей.',
     'Specialists who look after children’s wellbeing and development.'),
    ('Dars jadvali', 'Расписание', 'Timetable'),
    ('<h2>Tillarga <span class="mark">ixtisoslashtirilgan</span></h2>',
     '<h2>Углублённое изучение <span class="mark">языков</span></h2>',
     '<h2>Specialized in <span class="mark">languages</span></h2>'),
    ('O‘quvchilarimiz ingliz va rus tillarini chuqur o‘rganib, ularni mukammal egallaydi.',
     'Наши ученики углублённо изучают английский и русский языки и свободно ими владеют.',
     'Our students study English and Russian in depth and become fluent in both.'),
    ('<h3>Ingliz tili</h3>', '<h3>Английский язык</h3>', '<h3>English</h3>'),
    ('Xalqaro imtihonlarga tayyorgarlik va erkin muloqot ko‘nikmalari.', 'Подготовка к международным экзаменам и навыки свободного общения.', 'Preparation for international exams and confident conversation skills.'),
    ('<h3>Rus tili</h3>', '<h3>Русский язык</h3>', '<h3>Russian</h3>'),
    ('Grammatika, adabiyot va ravon so‘zlashuv.', 'Грамматика, литература и свободная речь.', 'Grammar, literature and fluent speech.'),
    ('<span class="tagline">To‘garaklar</span>', '<span class="tagline">Секции</span>', '<span class="tagline">Clubs</span>'),
    ('<h2>Sport to‘garaklari</h2>', '<h2>Спортивные секции</h2>', '<h2>Sports clubs</h2>'),
    ('Sog‘lom tanda — sog‘lom aql. Farzandingiz o‘ziga yoqqan sport turini tanlaydi.',
     'В здоровом теле — здоровый дух. Ваш ребёнок сам выбирает любимый вид спорта.',
     'A healthy body, a healthy mind. Your child picks the sport they love.'),
    ('<h3>Karate</h3>', '<h3>Карате</h3>', '<h3>Karate</h3>'),
    ('Intizom, kuch va o‘zini himoya qilish', 'Дисциплина, сила и самозащита', 'Discipline, strength and self-defense'),
    ('<h3>Futbol</h3>', '<h3>Футбол</h3>', '<h3>Football</h3>'),
    ('Jamoaviy o‘yin va chidamlilik', 'Командная игра и выносливость', 'Teamwork and endurance'),
    ('<h3>Basketbol</h3>', '<h3>Баскетбол</h3>', '<h3>Basketball</h3>'),
    ('Chaqqonlik va hamjihatlik', 'Ловкость и сплочённость', 'Agility and team spirit'),
    ('<h3>Shaxmat</h3>', '<h3>Шахматы</h3>', '<h3>Chess</h3>'),
    ('Mantiqiy fikrlash va sabr', 'Логическое мышление и терпение', 'Logical thinking and patience'),
    ('<span class="tagline">Oshxona</span>', '<span class="tagline">Столовая</span>', '<span class="tagline">Canteen</span>'),
    ('<h2>Eng yuqori sifatdagi <span class="mark">taomlar</span></h2>',
     '<h2><span class="mark">Питание</span> высшего качества</h2>',
     '<h2>Top-quality <span class="mark">meals</span></h2>'),
    ('Bolajonlarimiz uchun mazali va foydali ovqatlar tayyorlanadi. Gigiyena va sifat ustidan qat’iy nazorat o‘rnatilgan.',
     'Для наших детей готовят вкусную и полезную еду. Гигиена и качество под строгим контролем.',
     'We cook tasty, healthy food for our children. Hygiene and quality are strictly controlled.'),
    ('<h3>Bizning oshxona</h3>', '<h3>Наша столовая</h3>', '<h3>Our canteen</h3>'),
    ('Yangi va sifatli mahsulotlar', 'Свежие и качественные продукты', 'Fresh, quality ingredients'),
    ('Qat’iy gigiyena nazorati', 'Строгий гигиенический контроль', 'Strict hygiene control'),
    ('Issiq va to‘yimli taomlar', 'Горячие и сытные блюда', 'Hot, nourishing meals'),
    ('Tajribali oshpazlar', 'Опытные повара', 'Experienced cooks'),
    ('<span class="tagline">Aloqa</span>', '<span class="tagline">Контакты</span>', '<span class="tagline">Contact</span>'),
    ('<h2>Farzandingizni 192-maktabga yozdiring</h2>', '<h2>Запишите ребёнка в школу №192</h2>', '<h2>Enroll your child at School No. 192</h2>'),
    ('Ariza qoldiring — tez orada siz bilan bog‘lanamiz.', 'Оставьте заявку — мы скоро с вами свяжемся.', 'Leave a request — we will contact you shortly.'),
    ('<b>Manzil:</b> Toshkent sh., Shayxontohur tumani, Ko‘kcha, Qo‘rg‘oncha ko‘chasi',
     '<b>Адрес:</b> г. Ташкент, Шайхантахурский район, Кукча, ул. Кургонча',
     '<b>Address:</b> Qo‘rg‘oncha street, Ko‘kcha, Shaykhontohur district, Tashkent'),
    ('<b>Mo‘ljal:</b> Ko‘kcha, «Koshona» to‘yxonasi ro‘parasida',
     '<b>Ориентир:</b> Кукча, напротив свадебного зала «Кошона»',
     '<b>Landmark:</b> Ko‘kcha, opposite the “Koshona” wedding hall'),
    ('<b>Ish vaqti:</b> Dushanba – Shanba', '<b>Часы работы:</b> Понедельник – Суббота', '<b>Hours:</b> Monday – Saturday'),
    ('title="Xarita: 192-maktab"', 'title="Карта: школа №192"', 'title="Map: School No. 192"'),
    ('📍 Xaritada ochish', '📍 Открыть на карте', '📍 Open in Maps'),
    ('✏️ Ariza varaqasi', '✏️ Заявка', '✏️ Application form'),
    ('To‘ldirmang:', 'Не заполняйте:', 'Do not fill:'),
    ('aria-label="Ota-onaning ismi" placeholder="Ota-onaning ismi"', 'aria-label="Имя родителя" placeholder="Имя родителя"', 'aria-label="Parent’s name" placeholder="Parent’s name"'),
    ('aria-label="Telefon raqamingiz"', 'aria-label="Номер телефона"', 'aria-label="Phone number"'),
    ('aria-label="Farzandingiz ismi" placeholder="Farzandingiz ismi"', 'aria-label="Имя ребёнка" placeholder="Имя ребёнка"', 'aria-label="Child’s name" placeholder="Child’s name"'),
    ('aria-label="Sinf"', 'aria-label="Класс"', 'aria-label="Grade"'),
    ('<option value="">Sinf</option>', '<option value="">Класс</option>', '<option value="">Grade</option>'),
    ('aria-label="Savolingiz" placeholder="Savolingiz (ixtiyoriy)"', 'aria-label="Ваш вопрос" placeholder="Ваш вопрос (необязательно)"', 'aria-label="Your question" placeholder="Your question (optional)"'),
    ('Ariza yuborish →', 'Отправить заявку →', 'Send application →'),
    ('Xatolik yuz berdi. Iltimos, qayta urinib ko‘ring.', 'Произошла ошибка. Пожалуйста, попробуйте ещё раз.', 'Something went wrong. Please try again.'),
    ('Rahmat! Arizangiz qabul qilindi. Tez orada bog‘lanamiz.', 'Спасибо! Ваша заявка принята. Мы скоро свяжемся с вами.', 'Thank you! Your application has been received. We will be in touch soon.'),
    ('© 2026 192-maktab · Shayxontohur tumani', '© 2026 Школа №192 · Шайхантахурский район', '© 2026 School No. 192 · Shaykhontohur district'),
    ('Bu bizning maktab — 192-sonli o‘rta maxsus maktab', 'Это наша школа — специализированная школа №192', 'This is our school — Specialized Secondary School No. 192'),
]

SWITCH_UZ = '<a href="./" hreflang="uz" aria-current="page">UZ</a><a href="ru/" hreflang="ru">RU</a><a href="en/" hreflang="en">EN</a>'
SWITCH = {
    'ru': '<a href="../" hreflang="uz">UZ</a><a href="./" hreflang="ru" aria-current="page">RU</a><a href="../en/" hreflang="en">EN</a>',
    'en': '<a href="../" hreflang="uz">UZ</a><a href="../ru/" hreflang="ru">RU</a><a href="./" hreflang="en" aria-current="page">EN</a>',
}
GRADE = {'ru': r'<option>\1 класс</option>', 'en': r'<option>Grade \1</option>'}


def build(lang, col):
    s = io.open(os.path.join(ROOT, 'index.html'), encoding='utf-8').read()
    missing = []
    for row in sorted(T, key=lambda r: -len(r[0])):
        uz, tr = row[0], row[col]
        if uz not in s:
            missing.append(uz)
            continue
        s = s.replace(uz, tr)
    if missing:
        sys.exit('index.html da topilmadi:\n  ' + '\n  '.join(missing))
    assert s.count(SWITCH_UZ) == 1
    s = s.replace(SWITCH_UZ, SWITCH[lang])
    s, n = re.subn(r'<option>(\d+)-sinf</option>', GRADE[lang], s)
    assert n == 11, n
    # Report any Uzbek Latin words left untranslated (o‘ / g‘ only occur in Uzbek).
    left = sorted(set(re.findall(r'[^\s<>"]*[oOgG]‘[^\s<>"]*', s)))
    if lang == 'en':
        left = [w for w in left if w not in ('Qo‘rg‘oncha', 'Ko‘kcha,')]
    if left:
        print(lang, 'OGOHLANTIRISH, tarjima qilinmagan bo‘lishi mumkin:', left)
    out = os.path.join(ROOT, lang)
    os.makedirs(out, exist_ok=True)
    io.open(os.path.join(out, 'index.html'), 'w', encoding='utf-8', newline='\n').write(s)
    print(lang, 'ok')


build('ru', 1)
build('en', 2)
