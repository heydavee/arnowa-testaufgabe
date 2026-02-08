# ARNOWA-Testaufgabe

## Installation

Da die Anforderung ist, das Plugin unter Shopware 6.6 umzusetzen, habe ich eine Docker-Umgebung für Shopware 6.6 erstellt. Ich verwende dafür die Docker-Images von [dockware](https://dockware.io/). Die genaue Versionsnummer habe ich hier entnommen: https://hub.docker.com/r/dockware/shopware/tags

Die Installation ist relativ einfach:

1. Klone das Repository
2. Erstelle eine Docker-Umgebung mit `docker-compose up -d`
   (Wir mappen nur das Verzeichnis custom/plugins/ProductComplianceInfo in den Container ein)
3. Im Backend mit folgenden Daten einloggen: admin/shopware
4. Installiere das Plugin in der Shopware-Installation

-- Optional --

Für Autovervollständigung im IDE kann der vendor Ordner vom Docker Container direkt kopiert werden mit folgendem Befehl (kann etwas dauern):

```bash
docker cp shopware:/var/www/html/vendor/ vendor/
```

Danach IDE neustarten oder reindexieren.

## Erläuterung zur technischen Entscheidung: Entity-Extension statt Custom Fields

Ich habe mich bewusst für die Entity-Extension Lösung entschieden, aufgrund folgender Gründe:

1. Felder lassen sich nicht mit Custom Fields steuern

   Die Anforderung "Der Hinweistext soll nur pflegbar sein, wenn die Checkbox aktiviert ist", ist nicht mit Custom Fields möglich.

2. Performance und Datenintegrität

   Custom Fields können keine Relationen zu anderen Entities haben und speichern Daten als JSON in der Datenbank, was bei Filterung und Suche zu Performance-Problemen führen kann.

3. Zukunftsorientierung

   Die Entity Extension lässt sich einfacher erweitern (siehe Konzeptfragen)

## Technische Umsetzung

Das Plugin erweitert in der ersten Version die Entity "Product" um zwei neue Felder: Boolean & Text. Die Daten werden über einen PageLoadSubscriber in der Storefront-View übergeben.

### Relevante Komponenten

- **Entity Extension**: ProductComplianceInfo
- **Admin**:
- **Subscriber**: ProductComplianceInfo/src/Subscriber/Storefront/ProductPageLoadedSubscriber.php
- **Twig Templates**
