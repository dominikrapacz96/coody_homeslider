# Changelog

Wszystkie istotne zmiany w module **Coody Home Slider** (`coody_homeslider`).

## [1.0.8] — 2026-07-14

### Zmienione
- Aktualizacja wersji dokumentacji i plików konfiguracyjnych.

---

## [1.0.6] — 2026-07-14

### Zmienione
- Nawigacja slidera: stały rozmiar czcionki **12px** (tytuły slajdów i strzałki).
- Ikony strzałek SVG: **12×12px**.
- Usunięto marginesy mobile (`margin-top` / `margin-bottom: 3rem`) z CSS modułu — odstępy na mobile są konfigurowane w motywie sklepu, nie w module.

---

## [1.0.5] — 2026-07-14

### Naprawione
- Zbyt duża nawigacja na domyślnych motywach PrestaShop (konflikt globalnych stylów `button`).
- Poziomy scroll strony spowodowany przez `width: 100vw` w CSS.

### Zmienione
- Pełna szerokość slidera liczona w JS (`syncFullWidth`) zamiast `100vw` w CSS.
- Reset stylów przycisków nawigacji (`appearance`, `box-shadow`, `min-height` itd.).
- Wyższy priorytet ładowania CSS modułu (250), aby nadpisywać style motywu.

---

## [1.0.4] — 2026-07-14

### Dodane
- Owl Carousel wbudowany w moduł (JS + CSS) — brak zależności od motywu.
- Hook `displayWrapperTop` (motyw Classic i podobne).
- Własny placeholder obrazka (`img/placeholder.svg`).
- Ikony strzałek jako SVG (bez fontu ikon motywu).

### Zmienione
- Unikalna klasa karuzeli `.coody-homeslider__carousel` zamiast `#sliderHome` (brak konfliktu z `ps_imageslider`).
- Moduł działa po instalacji bez edycji motywu (hooki `displayWrapperTop`, `displayHomeTop`, `displayHomeSliders`).
- Zaktualizowany opis w konfiguracji modułu.

---

## [1.0.3] — 2026

### Naprawione
- Pozycje slajdów w BO: numeracja od 0 (wyświetlanie `position + 1`).

---

## [1.0.2] — 2026

### Naprawione
- Wyświetlanie slidera na stronie głównej — rejestracja hooków `displayHomeSliders`, `displayHomeTop`, `displayHeader`.
- Duplikacja slidera przez wczesne wywołanie `displayHome` w `IndexController`.

---

## [1.0.1] — 2026

### Zmienione
- Zakładka zarządzania slajdami przeniesiona pod grupę menu BO **Coody** (`AdminCoody`).

---

## [1.0.0] — 2026

### Dodane
- Pierwsza wersja modułu.
- Panel BO: dodawanie, edycja, duplikacja i sortowanie slajdów.
- Osobne grafiki desktop i mobile na slajd.
- Pola wielojęzyczne: tytuł, opis, link, tekst alternatywny (alt).
- Slider na stronie głównej z karuzelą Owl Carousel.
- Dolny pasek nawigacji ze strzałkami i tytułami slajdów (desktop).
- Podgląd sąsiednich slajdów na mobile i ekranach >1920px.
- Konfiguracja: włącz/wyłącz, czas slajdu (ms).
- Wsparcie multistore (`actionShopDataDuplication`).
