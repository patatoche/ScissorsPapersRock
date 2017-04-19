<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class LovePlayer
 * @package Hackathon\PlayerIA
 * @author Patrick
 */
class HalPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;

    public function getChoice()
    {
        // Get data
        $opponentChoice = $this->result->getLastChoiceFor($this->opponentSide);
        $myLastChoice = $this->result->getLastChoiceFor($this->mySide);
        $opponentStats = $this->result->getStatsFor($this->opponentSide);
        $round = $this->result->getNbRound();

        $papersCount = $opponentStats['paper'];
        $rocksCount = $opponentStats['rock'];
        $scissorsCount = $opponentStats['scissors'];

        // First round => arbitrary choice
        if ($opponentChoice === 0) {

            return parent::paperChoice();
        }

        // Later rounds: if oppenent is inclined to play often a choice,
        // play winning choice over his
        if ($round >= 3) {
            if ($papersCount > $round / 2) {

                return parent::scissorsChoice();
            } elseif ($rocksCount > $round / 2) {

                return parent::paperChoice();
            } elseif ($scissorsCount > $round / 2) {

                return parent::rockChoice();
            }
        }

        // No clear pattern emerges: play winning case over my last choice
        switch ($opponentChoice) {
            case parent::paperChoice():
                return parent::scissorsChoice();
                break;

            case parent::rockChoice():
                return parent::paperChoice();
                break;

            case parent::scissorsChoice():
                return parent::rockChoice();
                break;
        }
    }

}

;
