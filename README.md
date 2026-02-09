# ARNOWA-Testaufgabe

## Installation

Da die Anforderung ist, das Plugin unter Shopware 6.6 umzusetzen, habe ich eine Docker-Umgebung für Shopware 6.6 erstellt. Ich verwende dafür die Docker-Images von [dockware](https://dockware.io/). Die genaue Versionsnummer habe ich hier entnommen: https://hub.docker.com/r/dockware/shopware/tags

Falls das Plugin in eine bereits bestehende Shopware 6.6 Installation installiert werden soll, einfach die .zip von hier herunterladen:
https://github.com/heydavee/arnowa-testaufgabe/releases/tag/Pre-Release

Die Installation der Entwicklungsumgebung ist relativ einfach:

1. Klone das Repository
2. Erstelle eine Docker-Umgebung mit `docker-compose up -d`
   (Wir mappen nur das Verzeichnis custom/plugins/ArnowaProductComplianceInfo in den Container)
3. Im Backend mit folgenden Daten einloggen: admin/shopware
4. Installiere das Plugin im Backend.
   
(Optional) oder über die CLI im Container mit folgendem Befehl:

```bash
docker exec -it shopware_arnowa bash
```

dann im Container:

```bash
bin/console plugin:install --activate ArnowaProductComplianceInfo
```

Cache leeren

```bash
bin/console cache:clear
```

5. Nachdem das Plugin aktiviert wurde, kann im Backend in den Produktdetailansichten unter dem Reiter 'Allgemein' im letzten Abschnitt das Feld für die Produkthinweise gepflegt werden

--- 
IDE Vervollständigung (Optional, um sich den Code besser anschauen zu können)

Für Autovervollständigung im IDE kann der vendor Ordner vom Docker Container direkt kopiert werden mit folgendem Befehl (kann etwas dauern):

```bash
docker cp shopware:/var/www/html/vendor/ vendor/
```

Danach IDE neustarten oder reindexieren.

---

## Erläuterung zur technischen Entscheidung: Entity-Extension statt Custom Fields

Ich habe mich bewusst für die Entity-Extension Lösung entschieden, aufgrund folgender Gründe:

1. Felder lassen sich nicht mit Custom Fields steuern

   Die Anforderung "Der Hinweistext soll nur pflegbar sein, wenn die Checkbox aktiviert ist", ist nicht mit Custom Fields möglich.

2. Performance und Datenintegrität

   Custom Fields können keine Relationen zu anderen Entities haben und speichern Daten als JSON in der Datenbank, was bei Filterung und Suche zu Performance-Problemen führen kann.

3. Zukunftsorientierung

   Die Entity Extension lässt sich einfacher erweitern (siehe Konzeptfragen)

Eine weitere Meinung von einem Shopware Core Entwickler: http://shyim.me/blog/custom-fields/

## Technische Umsetzung

Das Plugin erstellt in der ersten Version eine eigene Entity "ProductComplianceInfo" mit zwei Feldern: Boolean & Text. Die Daten werden über einen PageLoadSubscriber in der Storefront-View übergeben. In der Administration wird die Entity über eine Extension des Product Detail Base erweitert. Dort wird die Logik implementiert, dass der Text nur pflegbar ist, wenn die Checkbox aktiviert ist (Vue.js).

## Konzeptfragen

### Wie würdest du die Lösung erweitern, wenn der Hinweis nur für bestimmte Kundengruppen (z.B. B2B) sichtbar sein soll?

- Ich würde es wahrscheinlich mit einer Assoziation zum Rule Builder machen, dadurch könnte man die Regeln für Kundengruppen oder auch ganz andere Fälle flexibel definieren. Über das Backend wäre dann beim Produkt noch zusätzlich die Regel auswählbar.

### Wie würdest du vorgehen, wenn rechtliche Hinweise versioniert und historisch nachvollziehbar bleiben müssen?

- Ich würde die Hinweise in einer separaten Tabelle speichern. Sozusagen eine Audit Tabelle, die die Versionierung und Historie der Regeln speichert. Die Tabelle hätte Felder wie "compliance_info_id", "product_id", "compliance_info", "valid_from", "valid_to", "created_by". Bei Änderungen würde der alte Eintrag dann in die Audit Tabelle aufgenommen werden und der neue Eintrag in die aktuelle "arnowa_product_compliance_info" Tabelle. Dadurch folgt eine logische Trennung von aktuellen und historischen Daten.

### Warum sollte Geschäftslogik nicht im Twig-Template implementiert werden?

- Twig-Templates sind für die Darstellung gedacht. Logik im Template vermischt Verantwortlichkeiten und erschwert Wartung. Außerdem ist Logik im Template schwieriger nachzuvollziehen. Logik sollte in einem eigenen Service oder Subscriber festgelegt werden.

### Welche Kriterien würdest du nutzen, um zwischen Custom Field und Entity Extension zu entscheiden (Shopware 6.6)?

- Sobald es in Richtung Relationen und Custom Logic geht, würde ich Entity Extension bevorzugen. Für einfache Daten würde ich Custom Fields verwenden wobei diese schnell an Grenzen stoßen. Für mehr siehe - Erläuterung zur technischen Entscheidung: Entity-Extension statt Custom Fields

## Annahmen / Vereinfachungen

- Es wurde explizit Shopware 6.6 gefordert, daher die Docker Umgebung mit Shopware 6.6
- Es wurde sich auf die Produktdetailseite fokussiert, Warenkorb, Checkout und andere Seiten wurden nicht berücksichtigt
- Hinweise müssen für Varianten einzeln gepflegt werden (keine Vererbung)
- Es ist nur möglich, einen Hinweis pro Produkt zu pflegen
- Die Hinweise sind nicht multi-lingual pflegbar
- Styling des Hinweises ist mit Absicht am Standard gehalten
- Das Textfeld ist eine Textarea, man könnte es auch als Rich Text umsetzen



