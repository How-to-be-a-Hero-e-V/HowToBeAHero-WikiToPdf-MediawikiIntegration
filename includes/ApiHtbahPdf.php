<?php
namespace HTBAH\WikiToPdf;

use ApiBase;
use MediaWiki\MediaWikiServices;
use Title;
use Wikimedia\ParamValidator\ParamValidator;

/**
 * action=htbahpdf&titles=A|B: liefert je Seite die Revision, die Leser sehen
 * (mit ApprovedRevs die freigegebene, sonst die aktuellste). Damit rendert der
 * PDF-Dienst keine unfreigegebenen Entwürfe.
 */
class ApiHtbahPdf extends ApiBase {

	public function execute() {
		$params = $this->extractRequestParams();
		$hasApproved = class_exists( 'ApprovedRevs' );
		$out = [];
		foreach ( $params['titles'] as $text ) {
			$title = Title::newFromText( $text );
			$row = [ 'query' => $text ];
			if ( !$title ) {
				$row['invalid'] = true;
				$out[] = $row;
				continue;
			}
			if ( $title->isRedirect() ) {
				$target = MediaWikiServices::getInstance()->getRedirectLookup()->getRedirectTarget( $title );
				if ( $target ) {
					$title = Title::newFromLinkTarget( $target );
				}
			}
			$row['title'] = $title->getPrefixedText();
			$row['ns'] = $title->getNamespace();
			$row['exists'] = $title->exists();
			if ( $title->exists() ) {
				$approved = $hasApproved ? \ApprovedRevs::getApprovedRevID( $title ) : null;
				$row['revid'] = $approved ? (int)$approved : $title->getLatestRevID();
				$row['approved'] = (bool)$approved;
				$row['latest'] = $title->getLatestRevID();
			}
			$out[] = $row;
		}
		$this->getResult()->addValue( null, $this->getModuleName(), [ 'pages' => $out ] );
	}

	public function getAllowedParams() {
		return [
			'titles' => [
				ParamValidator::PARAM_TYPE => 'string',
				ParamValidator::PARAM_ISMULTI => true,
				ParamValidator::PARAM_REQUIRED => true,
				ParamValidator::PARAM_ISMULTI_LIMIT1 => 50,
				ParamValidator::PARAM_ISMULTI_LIMIT2 => 50,
			],
		];
	}

	protected function getExamplesMessages() {
		return [ 'action=htbahpdf&titles=Kampf|Begabungen' => 'apihelp-htbahpdf-example' ];
	}
}
