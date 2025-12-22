# Designare Feedback Ratings v2.0

Ein WordPress-Plugin zum Sammeln von Besucher-Feedback mit automatischer Schema.org AggregateRating-Generierung für besseres SEO und höhere Click-Through-Rates (CTR).

---

## Inhaltsverzeichnis

1. [Features](#features)
2. [Installation](#installation)
3. [Verwendung](#verwendung)
4. [CTR-Steigerung durch Rich Snippets](#ctr-steigerung-durch-rich-snippets)
5. [Einstellungen](#einstellungen)
6. [Hooks und Filter](#hooks-und-filter)
7. [REST API](#rest-api)
8. [FAQ](#faq)

---

## Features

### Kern-Funktionen
- **3-Stufen-Bewertung**: Hilfreich / Neutral / Nicht hilfreich
- **Echtzeit-Updates**: Bewertungen werden sofort angezeigt
- **Schema.org AggregateRating**: Automatische JSON-LD Generierung für Rich Snippets

### Neu in v2.0
- **Gutenberg Block**: Einfaches Einfügen per Block-Editor
- **Dashboard mit Charts**: Visuelle Statistiken mit Chart.js
- **E-Mail Alerts**: Benachrichtigung bei negativem Feedback
- **Design-Anpassung**: Farben, Border-Radius, Button-Stile

---

## Installation

1. ZIP-Datei herunterladen
2. WordPress Admin: **Plugins > Installieren > Plugin hochladen**
3. Plugin aktivieren
4. Konfigurieren unter **Feedback > Einstellungen**

---

## Verwendung

### Option 1: Automatisch (Standard)

Das Widget wird automatisch am Ende aller konfigurierten Post-Typen angezeigt.

### Option 2: Shortcode

```
[feedback_rating]
```

Mit Parametern:

```
[feedback_rating show_stats="true" show_share="false"]
```

| Parameter | Standard | Beschreibung |
|-----------|----------|--------------|
| `show_stats` | `true` | Statistik-Balken anzeigen |
| `show_share` | `true` | Share-Buttons anzeigen |
| `post_id` | Aktueller Post | ID für das Rating |

### Option 3: Gutenberg Block

1. Im Block-Editor nach **"Feedback Rating"** suchen
2. Block einfügen
3. In der Sidebar Optionen anpassen

---

## CTR-Steigerung durch Rich Snippets

### Was sind Rich Snippets?

Rich Snippets sind erweiterte Suchergebnisse in Google, die zusätzliche Informationen anzeigen - wie Sterne-Bewertungen. Diese werden aus den strukturierten Daten (Schema.org) auf deiner Website generiert.

### Wie stark beeinflusst das die CTR?

Laut verschiedenen Studien und Analysen:

| Quelle | CTR-Steigerung |
|--------|----------------|
| Search Engine Land | **+10-30%** |
| Moz Research | **+20-35%** |
| Ahrefs Study | **+15-25%** |
| Google (inoffiziell) | "signifikant" |

**Durchschnittliche Erwartung: 15-25% höhere CTR**

### Warum funktioniert das?

1. **Visuelle Hervorhebung**: Sterne fallen im Suchergebnis sofort auf
2. **Vertrauenssignal**: Bewertungen signalisieren Qualität
3. **Mehr Platz**: Rich Snippets nehmen mehr Raum ein als normale Ergebnisse
4. **Social Proof**: Menschen vertrauen bewerteten Inhalten mehr

### Beispiel eines Rich Snippets

Normales Suchergebnis:
```
Semantisches Markup für SEO | designare.at
https://designare.at/semantisches-markup
Erfahre warum semantisches HTML wichtig für SEO ist...
```

Mit AggregateRating Rich Snippet:
```
Semantisches Markup für SEO | designare.at
https://designare.at/semantisches-markup
★★★★☆ 4.2 (23 Bewertungen)
Erfahre warum semantisches HTML wichtig für SEO ist...
```

### Wann erscheinen Sterne in Google?

**Wichtig:** Google garantiert NICHT, dass Rich Snippets angezeigt werden!

Faktoren die die Anzeige beeinflussen:

1. **Mindestanzahl Bewertungen**: Google zeigt oft erst ab 5+ Bewertungen Sterne
2. **Glaubwürdigkeit**: Zu viele 5-Sterne-Bewertungen können verdächtig wirken
3. **Relevanz**: Nicht alle Seiten bekommen Rich Snippets
4. **Wettbewerb**: Bei umkämpften Keywords entscheidet Google selektiver
5. **Mobile vs. Desktop**: Anzeige kann variieren

### Best Practices für maximale CTR

1. **Authentische Bewertungen sammeln**
   - Keine Fake-Bewertungen
   - Gemischte Bewertungen sind glaubwürdiger als nur 5 Sterne

2. **Schema korrekt implementieren** (macht dieses Plugin automatisch)
   ```json
   {
     "@type": "AggregateRating",
     "ratingValue": "4.2",
     "ratingCount": "23",
     "bestRating": "5",
     "worstRating": "1"
   }
   ```

3. **Google Search Console nutzen**
   - Rich Results Test: https://search.google.com/test/rich-results
   - Überwachen ob Schema erkannt wird

4. **Geduld haben**
   - Google muss die Seite neu crawlen (kann Tage/Wochen dauern)
   - Rich Snippets erscheinen nicht sofort

### ROI-Berechnung

Angenommen:
- 10.000 Impressionen/Monat
- Aktuelle CTR: 3% (300 Klicks)
- CTR-Steigerung durch Rich Snippets: +20%
- Neue CTR: 3.6% (360 Klicks)

**Ergebnis: +60 zusätzliche Besucher/Monat ohne zusätzlichen SEO-Aufwand**

Bei einem Conversion-Rate von 2% und einem Wert von 50 EUR/Conversion:
- +60 Besucher × 2% × 50 EUR = **+60 EUR/Monat**

---

## Einstellungen

### Allgemein

| Option | Beschreibung |
|--------|--------------|
| Auto-Append | Widget automatisch nach Content anzeigen |
| Post-Typen | Auf welchen Content-Typen das Widget erscheint |
| Statistik-Balken | Zeigt prozentuale Verteilung |

### SEO

| Option | Beschreibung |
|--------|--------------|
| Schema aktiviert | JSON-LD mit AggregateRating generieren |

### E-Mail Alerts

| Option | Beschreibung |
|--------|--------------|
| E-Mail Alerts | Bei negativem Feedback benachrichtigen |
| E-Mail Adresse | Empfänger der Benachrichtigung |

### Spam-Schutz

| Option | Beschreibung |
|--------|--------------|
| Rate Limit | Minuten zwischen Abstimmungen (0 = deaktiviert) |

### Design

| Option | Beschreibung |
|--------|--------------|
| Primärfarbe | Akzentfarbe (Standard: #FCB500) |
| Positiv/Neutral/Negativ | Farben für die Buttons |
| Border Radius | Rundung der Ecken in Pixel |
| Button-Stil | Default, Minimal oder Pill |

---

## Hooks und Filter

### Schema anpassen

```php
add_filter('dfr_schema_json_ld', function($schema, $post_id, $ratings) {
    // Publisher hinzufügen
    $schema['publisher'] = [
        '@type' => 'Organization',
        'name' => 'Meine Firma',
        'logo' => 'https://example.com/logo.png'
    ];
    return $schema;
}, 10, 3);
```

---

## REST API

### Endpoint

```
GET /wp-json/dfr/v1/ratings/{post_id}
```

### Response

```json
{
  "success": true,
  "stats": {
    "positive": 15,
    "neutral": 5,
    "negative": 2
  },
  "total": 22,
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.1",
    "bestRating": "5",
    "worstRating": "1",
    "ratingCount": "22"
  }
}
```

---

## FAQ

### Warum sehe ich keine Sterne in Google?

1. Google muss die Seite erst neu crawlen
2. Mindestens 5 Bewertungen werden empfohlen
3. Google entscheidet selbst, ob Rich Snippets angezeigt werden
4. Teste mit dem Rich Results Test: https://search.google.com/test/rich-results

### Sind die Bewertungen manipulierbar?

Das Plugin nutzt mehrere Schutzmechanismen:
- Rate Limiting (IP + User-Agent basiert)
- localStorage zur Erkennung von Mehrfach-Votes
- Server-side Transients

Für Enterprise-Lösungen empfehlen wir zusätzlich:
- Honeypot-Felder
- reCAPTCHA Integration
- Login-Pflicht für Bewertungen

### Funktioniert das mit Caching-Plugins?

Ja! Die Ratings werden per AJAX geladen, funktioniert also mit:
- WP Super Cache
- W3 Total Cache
- WP Rocket
- LiteSpeed Cache
- Cloudflare

### Konflikte mit SEO-Plugins?

Das Plugin prüft nicht auf existierende Schema-Einträge. Bei Nutzung von Yoast SEO oder RankMath:

1. **Option A**: Schema in diesem Plugin deaktivieren und das SEO-Plugin nutzen
2. **Option B**: Schema im SEO-Plugin für Artikel deaktivieren

### Wie lösche ich alle Bewertungen?

Per Datenbank:
```sql
DELETE FROM wp_postmeta WHERE meta_key = '_dfr_ratings';
```

Oder per WP-CLI:
```bash
wp post meta delete --all --meta_key=_dfr_ratings
```

---

## Changelog

### 2.0.0
- NEU: Gutenberg Block
- NEU: Dashboard mit Chart.js Statistiken
- NEU: E-Mail Alerts bei negativem Feedback
- NEU: Design-Anpassung (Farben, Stile)
- Verbessertes Admin-Interface

### 1.0.0
- Initiale Version
- Feedback-Widget
- Schema.org Integration
- REST API

---

## Support

Bei Fragen oder Problemen:
- GitHub Issues: [Link]
- E-Mail: info@designare.at
- Website: https://designare.at

---

## Lizenz

GPL v2 or later

---

## Autor

**Michael Kanda**  
Web & KI Entwickler  
https://designare.at
