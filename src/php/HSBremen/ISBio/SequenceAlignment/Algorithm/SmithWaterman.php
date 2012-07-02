<?php
/**
 * `SmithWaterman.php`
 *
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see http://gnu.org/licenses/lgpl.txt.
 *
 * PHP version 5.4
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    GIT: $Id$
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @since      File available since Release 0.1.0
 */

namespace HSBremen\ISBio\SequenceAlignment\Algorithm;

use HSBremen\ISBio\SequenceAlignment\Model\ScoringMatrix\ScoringMatrixAbstract;

/**
 * TODO: Add short class comment.
 *
 * TODO: Add long class comment.
 *
 * @category   Biology
 * @package    SequenceAlignment
 * @subpackage Algorithm
 * @author     Florian Wolters <wolters.fl@gmail.com>
 * @copyright  2012 Florian Wolters
 * @license    http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version    Release: @package_version@
 * @link       http://github.com/FlorianWolters/SequenceAlignment
 * @link       http://en.wikipedia.org/wiki/Smith-Waterman
 * @link       http://mathworks.de/help/toolbox/bioinfo/ref/swalign.html
 * @since      Class available since Release 0.1.0
 * @todo       This is the local alignment algorithm. We should try to keep this
 * @todo       The current approach uses an array as the matrix, we could also
 *             use an object structure together with the class {@link Cell}.
 */
class SmithWaterman
{

    /**
     * The first input sequence.
     *
     * @var string
     */
    private $firstSeq;

    /**
     * The second input sequence.
     *
     * @var array
     */
    private $secondSeq;

    /**
     * The scoring matrix, e.g. BLOSUM62.
     *
     * @var ScoringMatrixEnum
     */
    private $scoringMatrix;


    /**
     * The length of the second input sequence.
     *
     * @var integer
     */
    private $secondSeqLen;

    /**
     * The matrix.
     *
     * @var array
     */
    private $matrix = [];

    /**
     * The score.
     *
     * @var integer
     */
    private $score;

    /**
     * The length of the first input sequence.
     *
     * @var array
     */
    private $firstSeqLen;

    /**
     * The first aligned sequence.
     *
     * @var string
     */
    private $firstAlignmentSequence;

    /**
     * The second aligned sequence.
     *
     * @var string
     */
    private $secondAlignmentSequence;

    /**
     * Constructs a new Smith-Waterman algorithm with the specified two
     * sequences, the specified scoring matrix and the specified penalty for
     * opening a gap in the alignment.
     *
     * @param string                $firstSeq      The first amino acid or
     *                                             nucleotide sequence to align
     *                                             locally.
     * @param string                $secondSeq     The second amino acid or
     *                                             nucleotide sequence to align
     *                                             locally.
     * @param ScoringMatrixAbstract $scoringMatrix The scoring matrix to use for
     *                                             the local alignment.
     * @param integer               $gapOpen       The penalty for opening a gap
     *                                             in the alignment.
     * @todo Implement input validation.
     */
    public function __construct(
        $firstSeq, $secondSeq, ScoringMatrixAbstract $scoringMatrix,
        $gapOpen = 8
    ) {
        $this->firstSeq = \str_split($firstSeq);
        $this->secondSeq = \str_split($secondSeq);
        $this->firstSeqLen = \strlen($firstSeq);
        $this->secondSeqLen = \strlen($secondSeq);
        $this->gapOpen = $gapOpen;

        $this->scoringMatrix = $scoringMatrix->getMatrix();
    }

    /**
     * Builds the matrix.
     *
     * @return void
     */
    public function buildMatrix()
    {
        for ($i = 0; $i <= $this->firstSeqLen; ++$i) {
            for ($j = 0; $j <= $this->secondSeqLen; ++$j) {
                $this->matrix[$i][$j] = 0;
            }
        }
    }

    /**
     * Fills the matrix.
     *
     * @return void
     */
    public function fillMatrix()
    {
        $weight = 0;
        $diagonalScore = 0;
        $leftScore = 0;
        $topScore = 0;

        for ($i = 1; $i <= $this->firstSeqLen; $i++) {
            for ($j = 1; $j <= $this->secondSeqLen; $j++) {
                $weight = $this->weight(
                    $this->firstSeq[$i - 1], $this->secondSeq[$j - 1]
                );
                $diagonalScore = $this->matrix[$i - 1][$j - 1] + $weight;
                $leftScore = $this->matrix[$i][$j - 1] - 1;
                $topScore = $this->matrix[$i - 1][$j] - 1;
                $this->matrix[$i][$j] = \max(
                    $diagonalScore, $leftScore, $topScore, 0
                );
            }
        }
    }

    /**
     * Run the backtrack.
     *
     * @return void
     * @todo Add implementation.
     */
    public function backtrack()
    {
    }

    /**
     * Returns the alignment score of the specified two inputs.
     *
     * @param string $x The first single character to compare.
     * @param string $y The second single character to compare.
     *
     * @return integer `2` on match; `-1' on mismatch.
     */
    private function weight($x, $y)
    {
        return ($x === $y) ? 2 : -1;
    }

    /**
     * Returns the matrix.
     *
     * @return array The matrix.
     */
    public function getMatrix()
    {
        return $this->matrix;
    }

    /**
     * Returns the score.
     *
     * @return integer The score.
     */
    public function getScore()
    {
        return $this->score;
    }

}

// TODO: Add unit test.
//$sequenceA = "MSEFRILSDREHVLKRAGMYIGSTTYEEHQRFLFGKWTKISYVPGLVKIIDEIIDNSVDEAIRTNFEFANVISVDIQNNIVTVTDNGRGIPQHMVTTPEGTQIPQPVAAWTRTKAGSNFDDTNRLTQGMNGVGSSLSNFFSDWFTGVTCDGETEMTVQCTNGAENITWSSKPSKLKGTNVTFCPDFDHFEGYMMDNSVLDIVHDRLQSLSVIFPKITFKFNGKRIVSKFKDYAKLYNDDPFVIEDKNFSLALVPAVEGEGFKSVSFANGLFTKNGGTHVDYVTDDLCEEIVKRIKKEYKVDVTKAAVKSGLTCILIVRELPNLRFDSQTKERLTNPTGDIKRHIDLDFKKLAKVIAKKENIIMPIIAVVLARKEAADKAAATKAAKAAKRAKVAKHVKANLIGTDAETTLFLTEGDSAINYLISVRDQDLHGGFPLRGKTLTTWEQPEAKIVKNAEIFNIMAITGLQFGVDALDVMQYKNIAIMTDADTDGIGSIKPSLISFFARWPELFEDGRIRFIKTPIIIAEPKKGDDVRWYYDLEDFENDRDNIkGYNIRYIKGLASLTESDYHRVINDPVMEIITLPENYKELFDLLYSEDADQRKIWMQS";
//$sequenceB = "MSIRLLVHLNQIYTTYNYTNMSDLLLNVDNDYLDLAAALNIDINTITDNIDINTSKSSLNTYFTSLPKDVVVRRLNSASYQDSQEMRWPYPGQDNQKLFEQFEGVNGVIVQLQGVILQHQAQLDHSYWDEANSKYVRFCNSVGYKRTYPDGSIKLIQGLPENVCLKGVTEYGDPPNRPLPVIDKLGLVGKKGMTCSECIRAGLHSQEVEGKDRPVTCSPTGQLIFYVTGFTTRVLSNKGGKVTSTFNDYTVKELMDDTGFILIIPLKAKSTRRGIWDASTKQWTSVGYEAMVNNLIYKHSKDFANAPVGKRDTIAMKMSPYFQTIIISIVPPNPEDKNPKASLNFAVKEIPDLGAIKAARKYWQQINPAGEINVLNEDDFSNTKSVGLCAAEIVEEEPIEINKNPWAE";
//
//$obj = new SmithWaterman($sequenceA, $sequenceB);
//$obj->buildMatrix();
//$obj->fillMatrix();
//$matrix = $obj->getMatrix();
