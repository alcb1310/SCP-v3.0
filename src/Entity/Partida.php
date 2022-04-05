<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Partida
 *
 * @ORM\Table(name="partida", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_A9C1580C20332D99", columns={"codigo"}), @ORM\UniqueConstraint(name="UNIQ_A9C1580C3A909126", columns={"nombre"})}, indexes={@ORM\Index(name="IDX_A9C1580C613CEC58", columns={"padre_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartidaRepository")
 */
#[UniqueEntity(
    fields:['codigo'],
    errorPath:'codigo',
    message:'Codigo de partida ya existe'
)]
#[UniqueEntity(
    fields:['nombre'],
    errorPath:'nombre',
    message:'Nombre de partida ya existe'
)]
class Partida
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
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=50, nullable=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255, nullable=false)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="acumula", type="boolean", nullable=false)
     */
    private $acumula;

    /**
     * @var int
     *
     * @ORM\Column(name="nivel", type="integer", nullable=false)
     */
    private $nivel;

    /**
     * @var \Partida
     *
     * @ORM\ManyToOne(targetEntity="Partida")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="padre_id", referencedColumnName="id")
     * })
     */
    private $padre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getAcumula(): ?bool
    {
        return $this->acumula;
    }

    public function setAcumula(bool $acumula): self
    {
        $this->acumula = $acumula;

        return $this;
    }

    public function getNivel(): ?int
    {
        return $this->nivel;
    }

    public function setNivel(int $nivel): self
    {
        $this->nivel = $nivel;

        return $this;
    }

    public function getPadre(): ?self
    {
        return $this->padre;
    }

    public function setPadre(?self $padre): self
    {
        $this->padre = $padre;

        return $this;
    }


}
