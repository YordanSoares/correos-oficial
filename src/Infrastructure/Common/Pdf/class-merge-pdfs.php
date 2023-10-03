<?php // phpcs:ignoreFile
/**
 * Pdf
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Pdf;

error_reporting( E_ALL ^ E_DEPRECATED );

use WooEnvio\Wefpdf\FPDI;

class MergePdfs extends FPDI {

	const A4_WIDTH       = 210;
	const A4_HEIGHT      = 290;
	const FILES_PER_ROW  = 2;
	const FILES_PER_PAGE = 4;

	protected $files;
	private $newWidth;
	private $newHeight;

	public function mergeFilesToUniqueFile( $targetFile ) {

		foreach ( $this->files as $file ) {
			$pagesInFile = $this->setSourceFile( $file );

			for ( $indexPage = 1; $indexPage <= $pagesInFile; $indexPage++ ) {
				$template = $this->importPage( $indexPage );

				$size = $this->getTemplateSize( $template );

				$this->AddPage( 'L', [ 150, 100 ] );

				if ( $this->pageNeedsRotate( $template ) ) {
					$this->useTemplate( $template, 0, 0, 98, 137 );
				} else {
					$this->useTemplate( $template );
				}
			}
		}

		$this->Output( $targetFile, 'F' );
	}

	public function mergeFilesToFourGridPage( $targetFile, $orientation = 'L', $indexFirstFile = 0 ) {
		// Obtain width and height for files on page.
		$this->obtainNewSize( $orientation );

		$indexFile = 0;
		if ( 0 < $indexFirstFile && 4 > $indexFirstFile ) {
			$indexFile = $indexFirstFile;

			$this->AddPage( $orientation );
		}

		foreach ( $this->files as $file ) {

			$pagesInFile = $this->setSourceFile( $file );

			for ( $indexPage = 1; $indexPage <= $pagesInFile; $indexPage++ ) {

				if ( 0 === $indexFile % self::FILES_PER_PAGE ) {
					$this->AddPage( $orientation );
				}

				$this->setSourceFile( $file );

				// CropBox, BleedBox, TrimBox, ArtBox.
				$template = $this->importPage( $indexPage, 'CropBox', false );

				$position = $this->obtainNewPosition( $indexFile );

				if ( $this->pageNeedsRotate( $template ) ) {
					$newWidth  = $this->reduce( $this->newHeight, 5 );
					$newHeight = $this->reduce( $this->newWidth, 5 );
					$pos_x     = $position['pos_x'];
					$pos_y     = $position['pos_y'] + 3;
				} else {
					$newWidth  = $this->newWidth;
					$newHeight = $this->newHeight;
					$pos_x     = $position['pos_x'];
					$pos_y     = $position['pos_y'];
				}

				$this->useTemplate(
					$template,
					$pos_x,
					$pos_y,
					$newWidth,
					$newHeight
				);
				$indexFile += 1;
			}
		}// End foreach().

		$this->Output( $targetFile, 'F' );
	}

	private function obtainNewSize( $orientation ) {
		$width  = 'L' === $orientation ? self::A4_HEIGHT : self::A4_WIDTH;
		$height = 'L' === $orientation ? self::A4_WIDTH : self::A4_HEIGHT;

		$this->newWidth  = $width / self::FILES_PER_ROW;
		$this->newHeight = $height / self::FILES_PER_ROW;
	}

	private function obtainNewPosition( $indexFile ) {
		$pos_x_on_page = [ 0, $this->newWidth, 0, $this->newWidth ];
		$pos_y_on_page = [ 0, 0, $this->newHeight, $this->newHeight ];

		$pos_on_page = $indexFile;
		if ( $indexFile > ( self::FILES_PER_PAGE - 1 ) ) {
			$pos_on_page = $indexFile % self::FILES_PER_PAGE;
		}

		$pos_x = $pos_x_on_page[ $pos_on_page ];
		$pos_y = $pos_y_on_page[ $pos_on_page ];

		return [
			'pos_x' => $pos_x,
			'pos_y' => $pos_y,
		];
	}

	public function addPdf( $file ) {
		$this->files[] = $file;
	}

	private function pageNeedsRotate( $template ) {
		$size = $this->getTemplateSize( $template );

		return $size['w'] < $size['h'];
	}

	private function reduce( $size, $percent ) {
		return floor( $size - ( $size * ( $percent / 100 ) ) );
	}

	public function getVersion() {
		return self::VERSION;
	}

	public function importPage( $pageNo, $boxName = 'CropBox', $groupXObject = true ) {
		if ( $this->_inTpl ) {
			throw new LogicException( 'Please import the desired pages before creating a new template.' );
		}

		$fn      = $this->currentFilename;
		$boxName = '/' . ltrim( $boxName, '/' );

		// check if page already imported
		$pageKey = $fn . '-' . ( (int) $pageNo ) . $boxName;
		if ( isset( $this->_importedPages[ $pageKey ] ) ) {
			return $this->_importedPages[ $pageKey ];
		}

		$parser = $this->parsers[ $fn ];
		$parser->setPageNo( $pageNo );

		if ( ! in_array( $boxName, $parser->availableBoxes ) ) {
			throw new \InvalidArgumentException( sprintf( 'Unknown box: %s', $boxName ) );
		}

		$pageBoxes = $parser->getPageBoxes( $pageNo, $this->k );

		/**
		* MediaBox
		* CropBox: Default -> MediaBox
		* BleedBox: Default -> CropBox
		* TrimBox: Default -> CropBox
		* ArtBox: Default -> CropBox
		*/
		if ( ! isset( $pageBoxes[ $boxName ] ) &&
			( $boxName == '/BleedBox' || $boxName == '/TrimBox' || $boxName == '/ArtBox' ) ) {
			$boxName = '/CropBox';
		}
		if ( ! isset( $pageBoxes[ $boxName ] ) && $boxName == '/CropBox' ) {
			$boxName = '/MediaBox';
		}

		if ( ! isset( $pageBoxes[ $boxName ] ) ) {
			return false;
		}

		$this->lastUsedPageBox = $boxName;

		$box = $pageBoxes[ $boxName ];

		$this->tpl++;
		$this->_tpls[ $this->tpl ] = array();
		$tpl                       =& $this->_tpls[ $this->tpl ];
		$tpl['parser']             = $parser;
		$tpl['resources']          = $parser->getPageResources();
		$tpl['buffer']             = $parser->getContent();
		$tpl['box']                = $box;
		$tpl['groupXObject']       = $groupXObject;
		if ( $groupXObject ) {
			$this->setPdfVersion( max( $this->getPdfVersion(), 1.4 ) );
		}

		// To build an array that can be used by PDF_TPL::useTemplate().
		$this->_tpls[ $this->tpl ] = array_merge( $this->_tpls[ $this->tpl ], $box );

		// An imported page will start at 0,0 all the time. Translation will be set in _putformxobjects().
		$tpl['x'] = 0;
		$tpl['y'] = 0;

		// handle rotated pages.
		$rotation              = $parser->getPageRotation( $pageNo );
		$tpl['_rotationAngle'] = 0;

		if ( $tpl['w'] < $tpl['h'] ) { // international shipping label.
			$tpl['_rotationAngle'] = -90;

			$tpl['x'] = 3;
			$tpl['y'] = -40;
		}
		$this->_importedPages[ $pageKey ] = $this->tpl;

		return $this->tpl;
	}
}
