## Key Terms

Version: July 9th, 2012
Overview: A document defining key terms in the project.

BLOSUM matrix[3][4]:
the BLOSUM (BLOcks of amino acid SUbstitution Matrix) matrix is a substitution matrix
used for sequence alignment of proteins. BLOSUM's are used to score alignments
between evolutionarily divergent protein sequences; the score is based off of local
alignments.

Gap Extension Penalty[1][2]:
This is a typical parameter when using sequence alignment programs. When the gap
extension penalty is increased, it reduces the size of gaps in the alignment. In otherwords, by raising the gap extension penalty, it increases the cost of making gaps
bigger when comparing sequences, which results in smaller gaps in the sequence.
Default values for the gap extension penalty very from program to program, though it
is important to have a balanced value; too low and almost everything will be aligned
creating a relatively worthless comparison, too high and alignments become harder to
generate.

Gap Open Penalty[1][2]:
This is a typical parameter when using sequence alignment programs. When the gap open penalty is increased, it reduces the frequency of gaps in the alignment. In
other words, by raising the gap open penalty, it increases the cost of creating a gap
when comparing sequences, which results in fewer gaps in the sequence. Default values for the gap extension penalty very from program to program, though it is important to have a balanced value; too low and almost everything will be aligned creating a
relatively worthless comparison, too high and alignments become harder to generate.

## References

[1]: http://power.nhri.org.tw/power/OptionClustal.htm
[2]: https://www.ebi.ac.uk/help/gaps.html
[3]: https://en.wikipedia.org/wiki/BLOSUM
[4]: https://www.ebi.ac.uk/help/matrix.html
