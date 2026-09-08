<?php
namespace HTBAH\WikiToPdf;

use MediaWiki\Hook\SidebarBeforeOutputHook;
use Skin;

class Hooks implements SidebarBeforeOutputHook {

	/** Toolbox-Links: aktuelle Seite als Buch-PDF und der Buch-Baukasten. */
	public function onSidebarBeforeOutput( $skin, &$sidebar ): void {
		$config = $skin->getConfig();
		$base = rtrim( $config->get( 'WikiToPdfUrl' ), '/' );
		$title = $skin->getTitle();
		if ( !$title ) {
			return;
		}
		$links = [];
		if ( $title->exists() && in_array( $title->getNamespace(), $config->get( 'WikiToPdfNamespaces' ), true ) ) {
			$links['htbah-pdf-page'] = [
				'id' => 't-htbah-pdf-page',
				'text' => $skin->msg( 'htbah-wikitopdf-page' )->text(),
				'href' => $base . '/book?' . wfArrayToCgi( [ 'pages' => $title->getPrefixedText(), 'fmt' => 'a4' ] ),
			];
		}
		$links['htbah-pdf-builder'] = [
			'id' => 't-htbah-pdf-builder',
			'text' => $skin->msg( 'htbah-wikitopdf-builder' )->text(),
			'href' => $base . '/',
		];
		$sidebar['TOOLBOX'] = array_merge( $links, $sidebar['TOOLBOX'] ?? [] );
	}
}
