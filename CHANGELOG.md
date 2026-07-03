# Changelog

Wszystkie istotne zmiany w module **Coody Home Slider** są dokumentowane w tym pliku.

Format oparty na [Keep a Changelog](https://keepachangelog.com/pl/1.1.0/),
a wersjonowanie zgodne z [Semantic Versioning](https://semver.org/lang/pl/).

## [1.0.3] - 2026-07-03

### Naprawione

- Normalizacja pozycji slajdów — numeracja od 0 w bazie (panel BO wyświetla `position + 1`).
- Czyszczenie cache modułu po aktualizacji.

## [1.0.2] - 2026-07-03

### Naprawione

- Poprawione wyświetlanie slidera na stronie głównej przez hook `displayHomeSliders`.
- Ponowna rejestracja hooków frontowych przy aktualizacji z wcześniejszych wersji.

## [1.0.1] - 2026-07-03

### Zmienione

- Zakładka zarządzania slajdami przeniesiona pod grupę menu **Coody** w panelu administracyjnym.

## [1.0.0] - 2026-07-03

### Dodane

- Slider banerów na stronie głównej z obsługą hooków `displayHomeSliders` i `displayHomeTop`.
- Osobne grafiki desktop i mobile (`<picture>` z breakpointem 767 px).
- Wielojęzyczne pola slajdu: tytuł, opis HTML, link, podpis (alt).
- Panel konfiguracji: włącz/wyłącz slider, prędkość karuzeli.
- Zarządzanie slajdami w back office (dodawanie, edycja, sortowanie, aktywacja).
- Obsługa multistore i duplikacji danych sklepu.
- Karuzela Owl Carousel z lazy loadingiem, nawigacją i zakładkami tytułów slajdów.
- Tłumaczenia polskie.

[1.0.3]: https://github.com/dominikrapacz96/coody_homeslider/compare/v1.0.2...v1.0.3
[1.0.2]: https://github.com/dominikrapacz96/coody_homeslider/compare/v1.0.1...v1.0.2
[1.0.1]: https://github.com/dominikrapacz96/coody_homeslider/compare/v1.0.0...v1.0.1
[1.0.0]: https://github.com/dominikrapacz96/coody_homeslider/releases/tag/v1.0.0
