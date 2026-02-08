# ARNOWA-Testaufgabe

## 1.1 Ziel der Aufgabe

Das Ziel der Aufgabe ist es, produktspezifische Hinweise im Backend auswählen zu können und diese dann im Frontend beim jeweiligen Produkt anzuzeigen.

## 1.2 Funktionale Anforderungen - Backend

- Checkbox: "Besonderer Hinweis erforderlich"
- Textarea "Hinweistext"
- Der Hinweistext soll nur pflegbar sein, wenn die Checkbox aktiviert ist

## 1.3 Funktionale Anforderungen - Storefront

- Anzeige auf der Produktdetailseite
- Anzeige nur, wenn die Checkbox aktiviert ist und ein Hinweistext gepflegt wurde
- Darstellung klar abgesetzt (z.B. als Hinweisbox)
- Der Hinweis wird über eine Template-Erweiterung (Twig Block) oder über ein Page-Event bereitgestellt
- Keine Geschäftslogik im Twig-Template

### 1.4 Technische Anforderungen#

- Umsetzung als eigenständiges Shopware Plugin (Shopware 6.6)
- Datenhaltung über Custom Fields oder Entity Extension
  (Entscheidung bitte im README.md begründen)
- Saubere Trennung von Logik und Darstellung (Services/Subscriber statt Logik im Twig-Template)
- Storefront-Erweiterung über Twig-Block-Extension oder passende PageLoaded-/Checkout-Events
- Code-Qualität (klare Benennung, sinnvolle Struktur, nachvollziehbare technische Entscheidungen)
