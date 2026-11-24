"""Build ru/index.html and en/index.html from the Uzbek index.html.

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
    ('lang="uz-Cyrl"', 'lang="ru"', 'lang="en"'),
    ('192-мактаб — Шайхонтоҳур туманидаги тилларга ихтисослаштирилган ўрта махсус мактаб. 24/7 хавфсизлик, Face ID назорати, олий тоифали ўқитувчилар, спорт тўгараклари.',
     'Школа №192 — специализированная средняя школа с углублённым изучением языков в Шайхантахурском районе Ташкента. Охрана 24/7, Face ID, учителя высшей категории, спортивные секции.',
     'School No. 192 — a language-specialized secondary school in Shaykhontohur district, Tashkent. 24/7 security, Face ID, top-category teachers, sports clubs.'),
    ('Тилларга ихтисослаштирилган ўрта махсус мактаб: 24/7 хавфсизлик, Face ID, олий тоифали устозлар, спорт тўгараклари.',
     'Специализированная школа с углублённым изучением языков: охрана 24/7, Face ID, учителя высшей категории, спортивные секции.',
     'Language-specialized secondary school: 24/7 security, Face ID, top-category teachers, sports clubs.'),
    ('192-мактаб — Шайхонтоҳур', 'Школа №192 — Шайхантахур', 'School No. 192 — Shaykhontohur'),
    ('192-мактаб<small>Шайхонтоҳур тумани</small>', 'Школа №192<small>Шайхантахурский район</small>', 'School No. 192<small>Shaykhontohur district</small>'),
    ('>Кузатув</a>', '>Контроль</a>', '>Tracking</a>'),
    ('>Хавфсизлик</a>', '>Безопасность</a>', '>Safety</a>'),
    ('>Устозлар</a>', '>Учителя</a>', '>Teachers</a>'),
    ('>Тиллар</a>', '>Языки</a>', '>Languages</a>'),
    ('#sport">Спорт</a>', '#sport">Спорт</a>', '#sport">Sports</a>'),
    ('>Ошхона</a>', '>Столовая</a>', '>Canteen</a>'),
    ('>Алоқа</a>', '>Контакты</a>', '>Contact</a>'),
    ('Ариза қолдириш', 'Оставить заявку', 'Apply now'),
    ('aria-label="Меню"', 'aria-label="Меню"', 'aria-label="Menu"'),
    ('<div class="date">Тилларга ихтисослаштирилган ўрта махсус мактаб</div>',
     '<div class="date">Специализированная школа с углублённым изучением языков</div>',
     '<div class="date">Language-specialized secondary school</div>'),
    ('<h1>192-мактабга <span class="hand">хуш келибсиз!</span></h1>',
     '<h1><span class="hand">Добро пожаловать</span> в школу №192!</h1>',
     '<h1><span class="hand">Welcome</span> to School No. 192!</h1>'),
    ('Шайхонтоҳур туманидаги олий тизимдаги мактаблардан бири. Хавфсиз муҳит, олий тоифали устозлар, инглиз ва рус тиллари, спорт тўгараклари — фарзандингиз учун барчаси бир жойда.',
     'Одна из ведущих школ Шайхантахурского района. Безопасная среда, учителя высшей категории, английский и русский языки, спортивные секции — всё для вашего ребёнка в одном месте.',
     'One of the leading schools in Shaykhontohur district. A safe environment, top-category teachers, English and Russian, and sports clubs — everything your child needs in one place.'),
    ('✏️ Фарзандимни ёздириш', '✏️ Записать ребёнка', '✏️ Enroll my child'),
    ('>Онлайн кузатув</a>', '>Онлайн-контроль</a>', '>Online tracking</a>'),
    ('<b>24/7</b>хавфсизлик', '<b>24/7</b>охрана', '<b>24/7</b>security'),
    ('<b>2</b>чет тили', '<b>2</b>иностранных языка', '<b>2</b>foreign languages'),
    ('<b>4</b>спорт тўгараги', '<b>4</b>спортивные секции', '<b>4</b>sports clubs'),
    ('aria-label="Электрон кундалик намунаси"', 'aria-label="Пример электронного дневника"', 'aria-label="Sample e-diary"'),
    ('📒 Кундалик <small>намуна</small>', '📒 Дневник <small>пример</small>', '📒 Diary <small>sample</small>'),
    ('Азизбек, 5-«А» синф', 'Азизбек, 5 «А» класс', 'Azizbek, Grade 5A'),
    ('</span>Мактабга кирди</span>', '</span>Пришёл в школу</span>', '</span>Arrived at school</span>'),
    ('</span>Инглиз тили</span>', '</span>Английский</span>', '</span>English</span>'),
    ('</span>Тушлик</span>', '</span>Обед</span>', '</span>Lunch</span>'),
    ('</span>Карате тўгараги</span>', '</span>Секция карате</span>', '</span>Karate club</span>'),
    ('</span>Мактабдан чиқди</span>', '</span>Ушёл из школы</span>', '</span>Left school</span>'),
    ('Ота-оналар учун', 'Для родителей', 'For parents'),
    ('<h2>Фарзандингизни <span class="mark">онлайн</span> кузатинг</h2>',
     '<h2>Следите за ребёнком <span class="mark">онлайн</span></h2>',
     '<h2>Follow your child <span class="mark">online</span></h2>'),
    ('Ҳар куни телефонингизда — фарзандингиз қачон келди, қачон кетди ва қандай ўқияпти.',
     'Каждый день на вашем телефоне — когда ребёнок пришёл, когда ушёл и как учится.',
     'Every day on your phone — when your child arrived, when they left and how they are doing in class.'),
    ('<h3>Келиш ва кетиш вақти</h3>', '<h3>Время прихода и ухода</h3>', '<h3>Arrival and departure</h3>'),
    ('Face ID орқали фарзандингиз соат нечада кирганини ва нечада чиққанини дарҳол биласиз.',
     'Благодаря Face ID вы сразу узнаете, во сколько ребёнок пришёл и во сколько ушёл.',
     'With Face ID you instantly know what time your child came in and what time they left.'),
    ('<h3>Ҳар кунги маълумот</h3>', '<h3>Ежедневная информация</h3>', '<h3>Daily updates</h3>'),
    ('Давомат, баҳолар ва кун давомидаги фаолият ҳақида кунлик ҳисобот.',
     'Ежедневный отчёт о посещаемости, оценках и занятиях в течение дня.',
     'A daily report on attendance, grades and activities throughout the day.'),
    ('<h3>Ўқишини онлайн кузатиш</h3>', '<h3>Успеваемость онлайн</h3>', '<h3>Track progress online</h3>'),
    ('Фарзандингиз ўзлаштиришини истаган пайт, истаган жойдан онлайн кузатиб боринг.',
     'Следите за успеваемостью ребёнка онлайн — в любое время и из любого места.',
     'Follow your child’s progress online — anytime, anywhere.'),
    ('<span class="tagline">Хавфсизлик</span>', '<span class="tagline">Безопасность</span>', '<span class="tagline">Safety</span>'),
    ('<h2>Фарзандингиз доимо ишончли ҳимояда</h2>', '<h2>Ваш ребёнок всегда под надёжной защитой</h2>', '<h2>Your child is always safe with us</h2>'),
    ('Мактаб ҳудуди кеча-кундуз назорат остида. Хотиржам бўлинг — болажонларингиз хавфсиз.',
     'Территория школы под круглосуточным наблюдением. Будьте спокойны — ваши дети в безопасности.',
     'The school grounds are monitored around the clock. Rest easy — your children are safe.'),
    ('<b>24/7 видеокузатув тизими</b>', '<b>Видеонаблюдение 24/7</b>', '<b>24/7 CCTV system</b>'),
    ('Мактаб ҳудуди ва бинолари доимий кузатувда.', 'Территория и здания школы под постоянным наблюдением.', 'School grounds and buildings are under constant surveillance.'),
    ('<b>Ҳарбий тайёргарликдан ўтган қўриқчилар</b>', '<b>Охрана с военной подготовкой</b>', '<b>Guards with military training</b>'),
    ('Малакали соқчилар мактаб кириш-чиқишини назорат қилади.', 'Квалифицированные охранники контролируют вход и выход.', 'Qualified guards control every entrance and exit.'),
    ('<b>Face ID тизими</b>', '<b>Система Face ID</b>', '<b>Face ID system</b>'),
    ('Ҳар бир ўқувчининг келиш ва кетиш вақти аниқ қайд этилади.', 'Время прихода и ухода каждого ученика точно фиксируется.', 'Every student’s arrival and departure time is recorded precisely.'),
    ('Кеча-кундуз хавфсизлик назорати — бир дақиқа ҳам танаффуссиз.', 'Круглосуточная охрана — без единой минуты перерыва.', 'Round-the-clock security — not a single minute off.'),
    ('Жамоамиз', 'Наша команда', 'Our team'),
    ('<h2>Энг олий тоифадаги <span class="mark">устозлар</span></h2>',
     '<h2><span class="mark">Учителя</span> высшей категории</h2>',
     '<h2>Top-category <span class="mark">teachers</span></h2>'),
    ('Тажрибали педагоглар ва психологлар ҳар бир болага алоҳида эътибор қаратади.',
     'Опытные педагоги и психологи уделяют внимание каждому ребёнку.',
     'Experienced educators and psychologists give every child individual attention.'),
    ('<h3>Олий тоифали ўқитувчилар</h3>', '<h3>Учителя высшей категории</h3>', '<h3>Top-category teachers</h3>'),
    ('Энг юқори малака тоифасига эга, тажрибали ўқитувчилар.', 'Опытные учителя с высшей квалификационной категорией.', 'Experienced teachers holding the highest qualification category.'),
    ('<h3>Малакали педагоглар</h3>', '<h3>Квалифицированные педагоги</h3>', '<h3>Qualified educators</h3>'),
    ('Замонавий услублар асосида дарс ўтадиган педагоглар жамоаси.', 'Команда педагогов, работающих по современным методикам.', 'A team of educators using modern teaching methods.'),
    ('<h3>Психологлар</h3>', '<h3>Психологи</h3>', '<h3>Psychologists</h3>'),
    ('Болаларнинг руҳий саломатлиги ва ривожланишини кузатувчи мутахассислар.',
     'Специалисты, которые следят за психологическим здоровьем и развитием детей.',
     'Specialists who look after children’s wellbeing and development.'),
    ('Дарс жадвали', 'Расписание', 'Timetable'),
    ('<h2>Тилларга <span class="mark">ихтисослаштирилган</span></h2>',
     '<h2>Углублённое изучение <span class="mark">языков</span></h2>',
     '<h2>Specialized in <span class="mark">languages</span></h2>'),
    ('Ўқувчиларимиз инглиз ва рус тилларини чуқур ўрганади ва мукаммал эгаллайди.',
     'Наши ученики углублённо изучают английский и русский языки и свободно ими владеют.',
     'Our students study English and Russian in depth and become fluent in both.'),
    ('<h3>Инглиз тили</h3>', '<h3>Английский язык</h3>', '<h3>English</h3>'),
    ('Халқаро имтиҳонларга тайёргарлик ва эркин мулоқот кўникмалари.', 'Подготовка к международным экзаменам и навыки свободного общения.', 'Preparation for international exams and confident conversation skills.'),
    ('<h3>Рус тили</h3>', '<h3>Русский язык</h3>', '<h3>Russian</h3>'),
    ('Грамматика, адабиёт ва равон сўзлашув.', 'Грамматика, литература и свободная речь.', 'Grammar, literature and fluent speech.'),
    ('<span class="tagline">Тўгараклар</span>', '<span class="tagline">Секции</span>', '<span class="tagline">Clubs</span>'),
    ('<h2>Спорт тўгараклари</h2>', '<h2>Спортивные секции</h2>', '<h2>Sports clubs</h2>'),
    ('Соғлом танда — соғлом ақл. Фарзандингиз ўзига ёққан спорт турини танлайди.',
     'В здоровом теле — здоровый дух. Ваш ребёнок сам выбирает любимый вид спорта.',
     'A healthy body, a healthy mind. Your child picks the sport they love.'),
    ('<h3>Карате</h3>', '<h3>Карате</h3>', '<h3>Karate</h3>'),
    ('Интизом, куч ва ўзини ҳимоя қилиш', 'Дисциплина, сила и самозащита', 'Discipline, strength and self-defense'),
    ('<h3>Футбол</h3>', '<h3>Футбол</h3>', '<h3>Football</h3>'),
    ('Жамоавий ўйин ва чидамлилик', 'Командная игра и выносливость', 'Teamwork and endurance'),
    ('<h3>Баскетбол</h3>', '<h3>Баскетбол</h3>', '<h3>Basketball</h3>'),
    ('Чаққонлик ва ҳамжиҳатлик', 'Ловкость и сплочённость', 'Agility and team spirit'),
    ('<h3>Шахмат</h3>', '<h3>Шахматы</h3>', '<h3>Chess</h3>'),
    ('Мантиқий фикрлаш ва сабр', 'Логическое мышление и терпение', 'Logical thinking and patience'),
    ('<span class="tagline">Ошхона</span>', '<span class="tagline">Столовая</span>', '<span class="tagline">Canteen</span>'),
    ('<h2>Энг юқори сифатдаги <span class="mark">таомлар</span></h2>',
     '<h2><span class="mark">Питание</span> высшего качества</h2>',
     '<h2>Top-quality <span class="mark">meals</span></h2>'),
    ('Болажонларимиз учун мазали ва фойдали овқатлар тайёрланади. Гигиена ва сифат устидан қатъий назорат ўрнатилган.',
     'Для наших детей готовят вкусную и полезную еду. Гигиена и качество под строгим контролем.',
     'We cook tasty, healthy food for our children. Hygiene and quality are strictly controlled.'),
    ('<h3>Бизнинг ошхона</h3>', '<h3>Наша столовая</h3>', '<h3>Our canteen</h3>'),
    ('Янги ва сифатли маҳсулотлар', 'Свежие и качественные продукты', 'Fresh, quality ingredients'),
    ('Қатъий гигиена назорати', 'Строгий гигиенический контроль', 'Strict hygiene control'),
    ('Иссиқ ва тўйимли таомлар', 'Горячие и сытные блюда', 'Hot, nourishing meals'),
    ('Тажрибали ошпазлар', 'Опытные повара', 'Experienced cooks'),
    ('<span class="tagline">Алоқа</span>', '<span class="tagline">Контакты</span>', '<span class="tagline">Contact</span>'),
    ('<h2>Фарзандингизни 192-мактабга ёздиринг</h2>', '<h2>Запишите ребёнка в школу №192</h2>', '<h2>Enroll your child at School No. 192</h2>'),
    ('Ариза қолдиринг — тез орада сиз билан боғланамиз.', 'Оставьте заявку — мы скоро с вами свяжемся.', 'Leave a request — we will contact you shortly.'),
    ('<b>Манзил:</b> Тошкент ш., Шайхонтоҳур тумани, Кўкча, Қўрғонча кўчаси',
     '<b>Адрес:</b> г. Ташкент, Шайхантахурский район, Кукча, ул. Кургонча',
     '<b>Address:</b> Qo‘rg‘oncha street, Ko‘kcha, Shaykhontohur district, Tashkent'),
    ('<b>Мўлжал:</b> Кўкча, «Кошона» тўйхонаси рўпарасида',
     '<b>Ориентир:</b> Кукча, напротив свадебного зала «Кошона»',
     '<b>Landmark:</b> Ko‘kcha, opposite the “Koshona” wedding hall'),
    ('<b>Иш вақти:</b> Душанба – Шанба', '<b>Часы работы:</b> Понедельник – Суббота', '<b>Hours:</b> Monday – Saturday'),
    ('title="Харита: 192-мактаб"', 'title="Карта: школа №192"', 'title="Map: School No. 192"'),
    ('📍 Харитада очиш', '📍 Открыть на карте', '📍 Open in Maps'),
    ('✏️ Ариза варақаси', '✏️ Заявка', '✏️ Application form'),
    ('Тўлдирманг:', 'Не заполняйте:', 'Do not fill:'),
    ('aria-label="Ота-онанинг исми" placeholder="Ота-онанинг исми"', 'aria-label="Имя родителя" placeholder="Имя родителя"', 'aria-label="Parent’s name" placeholder="Parent’s name"'),
    ('aria-label="Телефон рақам"', 'aria-label="Номер телефона"', 'aria-label="Phone number"'),
    ('aria-label="Фарзандингиз исми" placeholder="Фарзандингиз исми"', 'aria-label="Имя ребёнка" placeholder="Имя ребёнка"', 'aria-label="Child’s name" placeholder="Child’s name"'),
    ('aria-label="Синф"', 'aria-label="Класс"', 'aria-label="Grade"'),
    ('<option value="">Синф</option>', '<option value="">Класс</option>', '<option value="">Grade</option>'),
    ('aria-label="Саволингиз" placeholder="Саволингиз (ихтиёрий)"', 'aria-label="Ваш вопрос" placeholder="Ваш вопрос (необязательно)"', 'aria-label="Your question" placeholder="Your question (optional)"'),
    ('Ариза юбориш →', 'Отправить заявку →', 'Send application →'),
    ('Хатолик юз берди. Илтимос, қайта уриниб кўринг.', 'Произошла ошибка. Пожалуйста, попробуйте ещё раз.', 'Something went wrong. Please try again.'),
    ('Раҳмат! Аризангиз қабул қилинди. Тез орада боғланамиз.', 'Спасибо! Ваша заявка принята. Мы скоро свяжемся с вами.', 'Thank you! Your application has been received. We will be in touch soon.'),
    ('© 2026 192-мактаб · Шайхонтоҳур тумани', '© 2026 Школа №192 · Шайхантахурский район', '© 2026 School No. 192 · Shaykhontohur district'),
    ('Бу бизнинг мактаб — 192-сонли ўрта махсус мактаб', 'Это наша школа — специализированная школа №192', 'This is our school — Specialized Secondary School No. 192'),
]

SWITCH_UZ = '<a href="./" hreflang="uz" aria-current="page">ЎЗ</a><a href="ru/" hreflang="ru">РУ</a><a href="en/" hreflang="en">EN</a>'
SWITCH = {
    'ru': '<a href="../" hreflang="uz">ЎЗ</a><a href="./" hreflang="ru" aria-current="page">РУ</a><a href="../en/" hreflang="en">EN</a>',
    'en': '<a href="../" hreflang="uz">ЎЗ</a><a href="../ru/" hreflang="ru">РУ</a><a href="./" hreflang="en" aria-current="page">EN</a>',
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
    s, n = re.subn(r'<option>(\d+)-синф</option>', GRADE[lang], s)
    assert n == 11, n
    # Report any Uzbek-specific letters left untranslated.
    left = sorted(set(re.findall(r'[^\s<>"]*[ўқғҳЎҚҒҲ][^\s<>"]*', s)))
    left = [w for w in left if w not in ('ЎЗ',)]
    if left:
        print(lang, 'OGOHLANTIRISH, tarjima qilinmagan bo‘lishi mumkin:', left)
    out = os.path.join(ROOT, lang)
    os.makedirs(out, exist_ok=True)
    io.open(os.path.join(out, 'index.html'), 'w', encoding='utf-8', newline='\n').write(s)
    print(lang, 'ok')


build('ru', 1)
build('en', 2)
