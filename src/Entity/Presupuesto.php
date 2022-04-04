<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Presupuesto
 *
 * @ORM\Table(name="presupuesto", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_1B6368D33C2672C8F15A1987", columns={"obra_id", "partida_id"})}, indexes={@ORM\Index(name="IDX_1B6368D33C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_1B6368D3F15A1987", columns={"partida_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PresupuestoRepository")
 */
class Presupuesto
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
     * @var float|null
     *
     * @ORM\Column(name="cantini", type="float", precision=10, scale=0, nullable=true)
     */
    private $cantini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="costoini", type="float", precision=10, scale=0, nullable=true)
     */
    private $costoini;

    /**
     * @var float
     *
     * @ORM\Column(name="totalini", type="float", precision=10, scale=0, nullable=false)
     */
    private $totalini;

    /**
     * @var float|null
     *
     * @ORM\Column(name="rendidocant", type="float", precision=10, scale=0, nullable=true)
     */
    private $rendidocant;

    /**
     * @var float
     *
     * @ORM\Column(name="rendidotot", type="float", precision=10, scale=0, nullable=false)
     */
    private $rendidotot;

    /**
     * @var float|null
     *
     * @ORM\Column(name="porgascan", type="float", precision=10, scale=0, nullable=true)
     */
    private $porgascan;

    /**
     * @var float|null
     *
     * @ORM\Column(name="porgascost", type="float", precision=10, scale=0, nullable=true)
     */
    private $porgascost;

    /**
     * @var float
     *
     * @ORM\Column(name="porgastot", type="float", precision=10, scale=0, nullable=false)
     */
    private $porgastot;

    /**
     * @var float
     *
     * @ORM\Column(name="presactu", type="float", precision=10, scale=0, nullable=false)
     */
    private $presactu;

    /**
     * @var \Obra
     *
     * @ORM\ManyToOne(targetEntity="Obra")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="obra_id", referencedColumnName="id")
     * })
     */
    private $obra;

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

    public function getCantini(): ?float
    {
        return $this->cantini;
    }

    public function setCantini(?float $cantini): self
    {
        $this->cantini = $cantini;

        return $this;
    }

    public function getCostoini(): ?float
    {
        return $this->costoini;
    }

    public function setCostoini(?float $costoini): self
    {
        $this->costoini = $costoini;

        return $this;
    }

    public function getTotalini(): ?float
    {
        return $this->totalini;
    }

    public function setTotalini(float $totalini): self
    {
        $this->totalini = $totalini;

        return $this;
    }

    public function getRendidocant(): ?float
    {
        return $this->rendidocant;
    }

    public function setRendidocant(?float $rendidocant): self
    {
        $this->rendidocant = $rendidocant;

        return $this;
    }

    public function getRendidotot(): ?float
    {
        return $this->rendidotot;
    }

    public function setRendidotot(float $rendidotot): self
    {
        $this->rendidotot = $rendidotot;

        return $this;
    }

    public function getPorgascan(): ?float
    {
        return $this->porgascan;
    }

    public function setPorgascan(?float $porgascan): self
    {
        $this->porgascan = $porgascan;

        return $this;
    }

    public function getPorgascost(): ?float
    {
        return $this->porgascost;
    }

    public function setPorgascost(?float $porgascost): self
    {
        $this->porgascost = $porgascost;

        return $this;
    }

    public function getPorgastot(): ?float
    {
        return $this->porgastot;
    }

    public function setPorgastot(float $porgastot): self
    {
        $this->porgastot = $porgastot;

        return $this;
    }

    public function getPresactu(): ?float
    {
        return $this->presactu;
    }

    public function setPresactu(float $presactu): self
    {
        $this->presactu = $presactu;

        return $this;
    }

    public function getObra(): ?Obra
    {
        return $this->obra;
    }

    public function setObra(?Obra $obra): self
    {
        $this->obra = $obra;

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
