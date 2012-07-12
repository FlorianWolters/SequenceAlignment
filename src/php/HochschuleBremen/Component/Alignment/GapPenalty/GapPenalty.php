<?php

namespace HochschuleBremen\Component\Alignment\GapPenalty;

class GapPenalty
{

    /**
     * The penalty given when a deletion or insertion gap first opens.
     *
     * @var float
     */
    private $openPenalty;

    /**
     * The penalty given when an already open gap elongates by a single element.
     *
     * @var float
     */
    private $extensionPenalty;

    /**
     * Creates a new set of gap penalties.
     *
     * @param float $openPenalty      The gap open penalty.
     * @param float $extensionPenalty The gap extension penalty.
     */
    public function __construct($openPenalty = 10, $extensionPenalty = 0.5)
    {
        $this->setOpenPenalty($openPenalty);
        $this->setExtensionPenalty($extensionPenalty);
    }

    /**
     * Sets the penalty given when a deletion or insertion gap first opens.
     *
     * @param float $openPenalty The gap open penalty.
     *
     * @return void
     */
    protected function setOpenPenalty($openPenalty)
    {
        $this->openPenalty = $openPenalty;
    }

    /**
     * Sets the penalty given when an already open gap elongates by a single
     * element.
     *
     * @param float $extensionPenalty The gap extension penalty.
     *
     * @return void
     */
    protected function setExtensionPenalty($extensionPenalty)
    {
        $this->extensionPenalty = $extensionPenalty;
    }

    /**
     * Returns the penalty given when a deletion or insertion gap first opens.
     *
     * @return float The gap open penalty.
     */
    public function getOpenPenalty()
    {
        return $this->openPenalty;
    }

    /**
     * Returns the penalty given when an already open gap elongates by a single
     * element.
     *
     * @return float The gap extension penalty.
     */
    public function getExtensionPenalty()
    {
        return $this->extensionPenalty;
    }

}
