# Coody Home Slider

Moduł PrestaShop do zarządzania sliderem banerów na stronie głównej. Obsługuje osobne grafiki na desktop i mobile, treści wielojęzyczne oraz konfigurację prędkości przełączania slajdów.

**Wersja:** 1.0.3  
**Autor:** [coody.it](https://coody.it)  
**Licencja:** Proprietary

## Wymagania

- PrestaShop **8.0.0** – **9.99.99**
- PHP zgodne z wymaganiami danej wersji PrestaShop

## Instalacja

1. Skopiuj katalog `coody_homeslider` do `modules/` w instalacji PrestaShop.
2. W panelu administracyjnym przejdź do **Moduły → Menedżer modułów**.
3. Wyszukaj **Coody - Slider strony głównej** i kliknij **Zainstaluj**.

Moduł automatycznie utworzy tabele w bazie danych, zarejestruje hooki i doda pozycję w menu **Coody**.

## Konfiguracja

### Ustawienia modułu

W **Moduły → Coody - Slider strony głównej → Konfiguruj** możesz:

- włączyć lub wyłączyć slider,
- ustawić prędkość automatycznego przełączania slajdów (domyślnie 5000 ms).

### Zarządzanie slajdami

W menu **Coody → Slider strony głównej** dodajesz i edytujesz slajdy. Dla każdego slajdu dostępne są:

| Pole | Opis |
|------|------|
| Tytuł | Nagłówek slajdu (wielojęzyczny) |
| Opis | Treść HTML wyświetlana na slajdzie |
| Link | Adres URL po kliknięciu |
| Podpis (alt) | Tekst alternatywny obrazka |
| Grafika desktop | Obraz dla szerokich ekranów |
| Grafika mobile | Osobny obraz dla urządzeń mobilnych (≤ 767 px) |
| Aktywny | Włączenie / wyłączenie slajdu |
| Pozycja | Kolejność wyświetlania |

## Wyświetlanie na froncie

Slider renderuje się na hooku **`displayHomeSliders`** (nad treścią strony głównej). Moduł rejestruje się na tym hooku automatycznie przy instalacji.

Opcjonalnie możesz przypiąć moduł także do hooka **`displayHomeTop`** w **Projektowanie → Pozycje**. Moduł renderuje slider tylko raz na stronie, niezależnie od liczby przypiętych hooków.

Na stronie głównej ładowane są style (`views/css/front.css`) i skrypt (`views/js/front.js`). Karuzela korzysta z Owl Carousel z lazy loadingiem obrazów.

## Wielosklepowość

Moduł obsługuje multistore — slajdy są przypisane do poszczególnych sklepów. Przy duplikacji danych sklepu (`actionShopDataDuplication`) powiązania slajdów są kopiowane do nowego sklepu.

## Struktura katalogów

```
coody_homeslider/
├── classes/           # Model CoodyHomeSlide
├── controllers/admin/ # Kontrolery panelu administracyjnego
├── img/               # Przesłane grafiki slajdów
├── sql/               # Skrypty instalacji i deinstalacji
├── translations/      # Tłumaczenia (pl)
├── upgrade/           # Skrypty aktualizacji wersji
├── views/
│   ├── css/           # Style frontu
│   ├── js/            # Logika karuzeli
│   └── templates/     # Szablony Smarty
├── coody_homeslider.php
└── config.xml
```

## Odinstalowanie

Odinstalowanie modułu usuwa tabele `coody_homeslider_slide`, `coody_homeslider_slide_lang` i `coody_homeslider` oraz wpisy konfiguracyjne. Grafiki w katalogu `img/` nie są usuwane automatycznie.

## Changelog

Historia zmian w pliku [CHANGELOG.md](CHANGELOG.md).
