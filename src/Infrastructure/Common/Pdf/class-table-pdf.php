<?php // phpcs:ignoreFile
/**
 * Pdf
 *
 * @package wooenvio/wecorreos
 */

namespace WooEnvio\WECorreos\Infrastructure\Common\Pdf;

use WooEnvio\Wefpdf\FPDF;

class TablePdf extends FPDF {

	private $widths;
	private $aligns;

	public function setWidths( $w ) {
		$this->widths = $w;
	}

	public function setAligns( $a ) {
		$this->aligns = $a;
	}

	public function setBgColor( $a ) {
		$this->bgcolor = $a;
	}

	public function row( $data, $h_row, $outside = false ) {
		// Calculate the height of the row
		$nb = 0;
		for ( $i = 0; $i < count( $data ); $i++ ) {
			$nb = max( $nb, $this->nbLines( $this->widths[ $i ], $data[ $i ] ) );
		}
		$h = $h_row * $nb;
		// Issue a page break first if needed
		$this->checkPageBreak( $h );
		if ( $outside ) {
			$x_out = $this->GetX();
			$y_out = $this->GetY();
			$w_out = array_sum( $this->widths );
			if ( isset( $this->bgcolor[0] ) && $this->bgcolor[0] ) {
				$this->SetFillColor( 200 );
				$this->Rect( $x_out, $y_out, $w_out, $h, 'FD' );
			} else {
				$this->Rect( $x_out, $y_out, $w_out, $h );
			}
		}
		// Draw the cells of the row
		for ( $i = 0; $i < count( $data ); $i++ ) {
			$w = $this->widths[ $i ];
			$a = isset( $this->aligns[ $i ] ) ? $this->aligns[ $i ] : 'L';
			// Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			// Draw the border
			// Print the text
			if ( ! $outside ) {
				if ( isset( $this->bgcolor[ $i ] ) && $this->bgcolor[ $i ] ) {
					$this->SetFillColor( 180 );
					$this->Rect( $x, $y, $w, $h, 'FD' );
				} else {
					$this->Rect( $x, $y, $w, $h );
				}
			}
			$cell_data = $data[ $i ];
			if (strpos($data[ $i ], '.png') !== false) {
				$file_name = basename($data[ $i ]);
				$correos_id = basename($file_name, '.png');
				$cell_data = utf8_decode($correos_id . "\n");
				$cell_data .= $this->Image( $data[ $i ],$this->GetX() + 1,$this->GetY() + 5);
			}

			$this->MultiCell( $w, $h_row, $cell_data, 0, $a );
			// Put the position to the right of the cell
			$this->SetXY( $x + $w, $y );
		}
		// Go to the next line
		$this->Ln( $h );
	}

	public function checkPageBreak( $h ) {
		// If the height h would cause an overflow, add a new page immediately
		if ( $this->GetY() + $h > $this->PageBreakTrigger ) {
			$this->AddPage( $this->CurOrientation );
		}
	}

	public function nbLines( $w, $txt ) {
		// Computes the number of lines a MultiCell of width w will take
		$cw =&$this->CurrentFont['cw'];
		if ( $w == 0 ) {
			$w = $this->w - $this->rMargin - $this->x;
		}
		$wmax = ( $w - 2 * $this->cMargin ) * 1000 / $this->FontSize;
		$s    = str_replace( "\r", '', $txt );
		$nb   = strlen( $s );
		if ( $nb > 0 and $s[ $nb - 1 ] == "\n" ) {
			$nb--;
		}
		$sep = -1;
		$i   = 0;
		$j   = 0;
		$l   = 0;
		$nl  = 1;
		while ( $i < $nb ) {
			$c = $s[ $i ];
			if ( $c == "\n" ) {
				$i++;
				$sep = -1;
				$j   = $i;
				$l   = 0;
				$nl++;
				continue;
			}
			if ( $c == ' ' ) {
				$sep = $i;
			}
			$l += $cw[ $c ];
			if ( $l > $wmax ) {
				if ( $sep == -1 ) {
					if ( $i == $j ) {
						$i++;
					}
				} else {
					$i = $sep + 1;
				}
				$sep = -1;
				$j   = $i;
				$l   = 0;
				$nl++;
			} else {
				$i++;
			}
		}
		return $nl;
	}
}
