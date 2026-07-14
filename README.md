# Coody Home Slider

Moduł slidera banerów na stronie głównej dla **PrestaShop 8.x i 9.x**.

Autor: [coody.it](https://coody.it)  
Wersja: **1.0.9**

## Wymagania

| Wymaganie | Wersja |
|-----------|--------|
| PrestaShop | 8.0.0 – 9.99.99 |
| PHP | 8.1+ (zalecane przez PS 8) |

Moduł jest **samodzielny** — nie wymaga Owl Carousel ani zmian w motywie po instalacji.

## Instalacja

1. Skopiuj folder `coody_homeslider` do `modules/`.
2. W panelu administracyjnym: **Moduły → Module Manager**.
3. Znajdź **Coody - Slider strony głównej** i kliknij **Zainstaluj**.
4. Dodaj slajdy: menu **Coody → Slider** (lub konfiguracja modułu → Zarządzaj slajdami).
5. Wyłącz moduł `ps_imageslider`, jeśli jest aktywny (może kolidować ze sliderem na stronie głównej).
6. Wyczyść cache: `php bin/console cache:clear`

## Wyświetlanie na stronie głównej

Moduł rejestruje się automatycznie na hookach:

- `displayWrapperTop` — motyw Classic (nad kontenerem)
- `displayHomeTop` — standardowy hook w `index.tpl`
- `displayHomeSliders` — opcjonalny hook niestandardowy (jeśli motyw go definiuje)

Slider renderuje się **jeden raz** — pierwszy dostępny hook w szablonie wygrywa.

### Opcjonalnie: własny hook w motywie

Jeśli chcesz slider w konkretnym miejscu layoutu, dodaj w szablonie strony głównej:

```smarty
{hook h='displayHomeSliders'}
```

Następnie w **Projektowanie → Pozycje** przypnij moduł do tego hooka.

## Panel administracyjny

### Konfiguracja modułu

- **Włączony** — globalne włączenie/wyłączenie slidera.
- **Czas slajdu (ms)** — minimalnie 1000 ms; czas autoplay karuzeli.

### Zarządzanie slajdami

Dla każdego slajdu (per język):

| Pole | Opis |
|------|------|
| Nazwa slajdu | Tytuł w pasku nawigacji (desktop) |
| Opis | Opcjonalny tekst na slajdzie (HTML) |
| Link | URL po kliknięciu w slajd |
| Tekst alternatywny (alt) | Atrybut `alt` obrazka |
| Grafika desktop | Obraz dla ekranów ≥768px |
| Grafika mobile | Obraz dla ekranów <768px |

Dostępne akcje: edycja, duplikacja, usuwanie, zmiana kolejności (pozycja).

## Zachowanie na froncie

### Desktop (768–1920px)
- Jeden pełny slajd na szerokość.
- Dolny pasek nawigacji: strzałki + tytuły slajdów.
- Autoplay z pauzą po najechaniu.

### Mobile (≤767px)
- Podgląd sąsiednich slajdów (`center` + `stagePadding`).
- Pasek nawigacji ukryty.

### Ultra-wide (>1920px)
- Środkowy slajd max 1920px, po bokach widać fragmenty sąsiednich slajdów.

## Dostosowanie w motywie (opcjonalne)

Moduł nie wymaga zmian w motywie. Jeśli chcesz dopasować odstępy tylko na swoim sklepie, dodaj w CSS motywu np.:

```css
@media (max-width: 767px) {
  section.coody-homeslider {
    margin-top: 3rem;
    margin-bottom: 3rem;
  }
}
```

Marginesy mobile **nie są** częścią modułu — każdy sklep może je ustawić osobno.

## Struktura plików

```
coody_homeslider/
├── coody_homeslider.php          # Główna klasa modułu
├── classes/CoodyHomeSlide.php    # Model slajdu (ObjectModel)
├── controllers/admin/            # Kontroler BO
├── views/
│   ├── css/front.css             # Style slidera i nawigacji
│   ├── css/owl.carousel.min.css  # Owl Carousel (wbudowany)
│   ├── js/front.js               # Logika karuzeli i breakpointów
│   ├── js/owl.carousel.min.js    # Owl Carousel (wbudowany)
│   └── templates/hook/slider.tpl
├── img/                          # Grafiki slajdów + placeholder.svg
├── sql/                          # Tabele bazy danych
└── upgrade/                      # Skrypty aktualizacji
```

## Baza danych

Tabele tworzone przy instalacji:

- `ps_coody_homeslider_slide` — slajdy (aktywność, pozycja)
- `ps_coody_homeslider_slide_lang` — tłumaczenia i grafiki
- `ps_coody_homeslider` — powiązanie slajd ↔ sklep (multistore)

## Aktualizacja

1. Nadpisz folder modułu nową wersją.
2. W BO: **Moduły** → znajdź moduł → **Aktualizuj** (jeśli dostępne).
3. Wyczyść cache.

Historia zmian: [CHANGELOG.md](CHANGELOG.md)

## Licencja

Proprietary — © 2026 coody.it
