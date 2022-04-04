<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetalleFactura
 *
 * @ORM\Table(name="detalle_factura", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_B1354EA1F04F795FF15A1987", columns={"factura_id", "partida_id"})}, indexes={@ORM\Index(name="IDX_B1354EA1F04F795F", columns={"factura_id"}), @ORM\Index(name="IDX_B1354EA1F15A1987", columns={"partida_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\DetalleFacturaRepository")
 */
class DetalleFactura
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="cantidad", type="float", precision=10, scale=0, nullable=false)
     */
    private $cantidad;

    /**
     * @var float
     *
     * @ORM\Column(name="unitario", type="float", precision=10, scale=0, nullable=false)
     */
    private $unitario;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var \Factura
     *
     * @ORM\ManyToOne(targetEntity="Factura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="factura_id", referencedColumnName="id")
     * })
     */
    private $factura;

    /**
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partida_id", referencedColumnName="id")
     * })
     */
    private $partida;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?float
    {
        return $this->cantidad;
    }

    public function setCantidad(float $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getUnitario(): ?float
    {
        return $this->unitario;
    }

    public function setUnitario(float $unitario): self
    {
        $this->unitario = $unitario;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getFactura(): ?Factura
    {
        return $this->factura;
    }

    public function setFactura(?Factura $factura): self
    {
        $this->factura = $factura;

        return $this;
    }

    public function getPartida(): ?Partida
    {
        return $this->partida;
    }

    public function setPartida(?Partida $partida): self
    {
        $this->partida = $partida;

        return $this;
    }


}
