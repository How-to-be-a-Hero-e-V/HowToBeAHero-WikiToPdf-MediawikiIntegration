# HowToBeAHero WikiToPdf – MediaWiki-Erweiterung

Kleine Erweiterung, die das How-to-be-a-Hero-Wiki mit dem Dienst
[HowToBeAHero-WikiToPdf](https://github.com/How-to-be-a-Hero-e-V/HowToBeAHero-WikiToPdf) verbindet.

* **Werkzeuge-Links:** „Diese Seite als Buch-PDF" und „Buch-Baukasten (PDF)" in der Seitenleiste.
* **API `action=htbahpdf&titles=A|B`:** liefert je Seite die Revision, die Leser sehen. Ist
  [ApprovedRevs](https://www.mediawiki.org/wiki/Extension:Approved_Revs) aktiv, ist das die freigegebene
  Version; der PDF-Dienst rendert damit keine unfreigegebenen Entwürfe.

## Installation

```php
wfLoadExtension( 'HowToBeAHero-WikiToPdf-MediawikiIntegration' );
$wgWikiToPdfUrl = '/pdf';            // Basis-URL des Dienstes (Standard)
$wgWikiToPdfNamespaces = [ 0, 14 ];  // Namensräume mit Sidebar-Link (Standard)
```

Der Katalog des Buch-Baukastens (Regelwerk-Reihenfolge, Kategorien für Module und Abenteuer,
Charakterbögen) liegt als JSON auf der Wiki-Seite `MediaWiki:Wikitopdf-catalog.json` und kann von
Administratoren gepflegt werden; fehlt die Seite, gilt die Vorgabe aus dem Dienst.

Lizenz: GPL-3.0-or-later.
