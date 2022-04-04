<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ActualHistorico
 *
 * @ORM\Table(name="actual_historico", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_B64C53893C2672C8F15A19871A8B7D9", columns={"obra_id", "partida_id", "fecha"})}, indexes={@ORM\Index(name="IDX_B64C53893C2672C8", columns={"obra_id"}), @ORM\Index(name="IDX_B64C5389F15A1987", columns={"partida_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\ActualHistoricoRepository")
 */
class ActualHistorico
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var float|null
     *
     * @ORM\Column(name="casas", type="float", precision=10, scale=0, nullable=true)
     */
    private $casas;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

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

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCasas(): ?float
    {
        return $this->casas;
    }

    public function setCasas(?float $casas): self
    {
        $this->casas = $casas;

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
