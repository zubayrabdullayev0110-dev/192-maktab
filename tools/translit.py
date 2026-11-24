"""Uzbek Cyrillic -> Uzbek Latin transliteration (official 1995 alphabet, with ‘ and ’)."""
import re

O = 'o‘'   # o‘
G = 'g‘'   # g‘
TUTUQ = '’'  # ’

LOWER = {
    'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd', 'ё': 'yo', 'ж': 'j', 'з': 'z',
    'и': 'i', 'й': 'y', 'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o', 'п': 'p',
    'р': 'r', 'с': 's', 'т': 't', 'у': 'u', 'ф': 'f', 'х': 'x', 'ц': 's', 'ч': 'ch',
    'ш': 'sh', 'ъ': TUTUQ, 'ь': '', 'э': 'e', 'ю': 'yu', 'я': 'ya', 'ў': O, 'қ': 'q',
    'ғ': G, 'ҳ': 'h', 'ы': 'i', 'щ': 'sh',
}
VOWELS = set('аеёиоуэюяўАЕЁИОУЭЮЯЎ')


def _char(ch, prev, nxt):
    low = ch.lower()
    if low == 'е':
        out = 'ye' if (not prev or not prev.isalpha() or prev in VOWELS or prev.lower() in 'ъь') else 'e'
    elif low == 'ц':
        out = 'ts' if prev and prev in VOWELS else 's'
    elif low in LOWER:
        out = LOWER[low]
    else:
        return ch
    if ch.isupper() and out:
        # Whole word in capitals (e.g. "ЎЗ") -> keep capitals; otherwise capitalise first letter.
        if nxt and nxt.isupper():
            return out.upper().replace('‘'.upper(), '‘')
        return out[0].upper() + out[1:]
    return out


def translit(text):
    res = []
    for i, ch in enumerate(text):
        prev = text[i - 1] if i else ''
        nxt = text[i + 1] if i + 1 < len(text) else ''
        res.append(_char(ch, prev, nxt))
    return ''.join(res)


if __name__ == '__main__':
    import sys
    sys.stdout.reconfigure(encoding='utf-8')
    for w in ['Шайхонтоҳур', 'тайёргарлик', 'Гигиена', 'маълумот', 'Қўрғонча', 'Ўқувчиларимиз', 'Психологлар', 'Электрон', 'Меню', 'Соғлом', 'ўқияпти', 'ЎЗ']:
        print(w, '->', translit(w))
