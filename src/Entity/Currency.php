<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="currency")
 * @ApiResource(
 *   normalizationContext={"groups" = {"read"}},
 *   denormalizationContext={"groups" = {"write"}},
 *   itemOperations={
 *     "get",
 *     "patch",
 *     "delete",
 *     "put",
 *   }
 * )
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private $id;

     /**
     * @var CurrencyCodes
     * @ORM\Column(type="string")
     * @Groups({"read", "write"})
     */
    private $srcCurrency;

    /**
     * @var CurrencyCodes
     *
     * @ORM\Column(type="string")
     * @Groups({"read", "write"})
     */
    private $destCurrency;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read", "write"})
     */
    private $conversionRate;

    /**
     * @ORM\Column(type="string")
     * @Groups({"read", "write"})
     */
    private $dateTime;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Groups({"read", "write"})
     *
     * @Assert\Range(
     *      min = 10,
     *      max = 100000,
     *      minMessage = "You must be at least {{ limit }}cm tall to enter",
     *      maxMessage = "You cannot be greater than {{ limit }}cm to enter"
     * )
     */
    private $amount;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read", "write"})
     */
    private $total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSrcCurrency(): ?string
    {
        return $this->srcCurrency;
    }

    public function setSrcCurrency(string $srcCurrency): self
    {
        $this->srcCurrency = $srcCurrency;

        return $this;
    }

    public function getDestCurrency(): ?string
    {
        return $this->destCurrency;
    }

    public function setDestCurrency(string $destCurrency): self
    {
        $this->destCurrency = $destCurrency;

        return $this;
    }

    public function getConversionRate(): ?float
    {
        return $this->conversionRate;
    }

    public function setConversionRate(float $conversionRate): self
    {
        $this->conversionRate = $conversionRate;

        return $this;
    }

    public function getDateTime(): ?string
    {
        return $this->dateTime;
    }

    public function setDateTime(string $dateTime): self
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

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
}
