<?php // phpcs:ignoreFile
namespace WooEnvio\WECorreos\Domain\Model\Correos\Aduanas;

class Oficina {

	private $unidad;
	private $nombre;
	private $direccion;
	private $cp;
	private $descLocalidad;

	public function __construct( $unidad, $nombre, $direccion, $cp, $descLocalidad ) {
		$this->unidad        = $unidad;
		$this->nombre        = $nombre;
		$this->direccion     = $direccion;
		$this->cp            = $cp;
		$this->descLocalidad = $descLocalidad;
	}

	public function unidad() {
		return $this->unidad;
	}

	public function nombre() {
		return $this->nombre;
	}

	public function direccion() {
		return $this->direccion;
	}

	public function descLocalidad() {
		return $this->descLocalidad;
	}

	public function cp() {
		return $this->cp;
	}

	public function data() {
		return [
			'unidad'        => $this->unidad,
			'nombre'        => $this->nombre,
			'direccion'     => $this->direccion,
			'cp'            => $this->cp,
			'descLocalidad' => $this->descLocalidad,
		];
	}

	public function formated_address() {
		return sprintf(
			'%1$s %2$s, %3$s. %4$s',
			$this->nombre,
			$this->direccion,
			$this->descLocalidad,
			$this->cp
		);
	}

	public static function build_from_data( $data ) {
		return new self(
			$data['unidad'],
			$data['nombre'],
			$data['direccion'],
			$data['cp'],
			$data['descLocalidad']
		);
	}

	public static function build_from_object( $data ) {
		return new self(
			$data->unidad,
			$data->nombre,
			$data->direccion,
			$data->cp,
			$data->descLocalidad
		);
	}
}
