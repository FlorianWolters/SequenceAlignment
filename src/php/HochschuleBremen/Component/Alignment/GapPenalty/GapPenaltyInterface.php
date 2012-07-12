<?php

namespace HochschuleBremen\Component\Alignment\GapPenalty;

interface GapPenaltyInterface
{

    /**
     * Returns the penalty given when a deletion or insertion gap first opens.
     *
     * @return integer The gap open penalty.
     */
    public function getOpenPenalty();

    /**
     * Returns the penalty given when an already open gap elongates by a single
     * element.
     *
     * @return integer The gap extension penalty.
     */
    public function getExtensionPenalty();

}
