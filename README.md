# SequenceAlignment

[![Build Status](https://secure.travis-ci.org/FlorianWolters/SequenceAlignment.png?branch=master)](http://travis-ci.org/FlorianWolters/SequenceAlignment)

## Introduction

This project is developed during the summer term 2012 of the module *Information Systems in Bioinformatics* at [Hochschule Bremen][28] ([Informatik M.Sc.][29], Graduate Programme *Komplexe Softwaresysteme*).

## Assignment

> Development of a web application demonstrating the calculation of a pairwise sequence alignment so that it can be used for teaching. The focus should be given to explain the calculation of the dynamic programming matrix. In addition, it should be shown how to get the corresponding score(s) and the sequence alignment(s) from this matrix.
>
> The software should be able to handle nucleic acid as well as amino acid sequences.
> * The global alignment variant should be based on the concept of edit distance using the unit cost model.
> * The local alignment variant should be based on similarity using the following matrices as scores: nucleic acids, BLOSUM62 for amino acids.

This project implements the **local pairwise sequence alignment** variant of the software.

## Used Software

### Server-side

* [PHP][17] 5.4.*
* [Silex][21] 1.1.*
* [Twig][22] 1.9.*
* [Twig Bridge][32] 2.1.*-beta3
* [Symfony2 Form Component][33] 2.1.*-beta3
* [Symfony2 Validator Component][31] 2.1.*-beta3
* [Symfony2 Yaml Component][30] 2.1.*-beta3
* [FlorianWolters\Component\Core\Enum][24] 0.3.*
* [FlorianWolters\Component\Util\Singleton][25] 0.2.*

### Client-side

* [jQuery][27] 1.7.2 (or later)
* [Twitter Bootstrap][26] 2.0.4 (or later)

## Features

* Calculates a local pairwise sequence alignment using the Smith-Waterman algorithm.
* Allows to input nucleotide (DNA and RNA) and amino acid sequences. The sequences are validated after submission of the corresponding form.
* Allows to input simple gap penalties (gap open and gap extension). **Not used by the algorithm, yet.**
* Clean layout and design of the web application. Each page of the application contains the term definitions at the bottom of the page (to understand the content of the current page).
* Currently supports three amino acid substitution matrices (BLOSUM60, BLOSUM62, BLOSUM63 by Henikoff & Henikoff) and two nucleotide substitution matrices (NUC.4.4 and NUC.4.2 by Lowe). Additional substitution matrices can be easily added to the application.
* Modular and Object-Oriented (OO) design with respect to Separation of Concerns (SoC).

    * The namespace `HSBremen\Component` contains a reusable (but still basic) component library for bioinformatics. Currently the following components are included:

        * `HSBremen\Component\Alignment`: Implements algorithms, e.g. for sequence alignment. Currently only the Smith-Waterman algorithm is supported.
        * `HSBremen\Component\Alignment\GapPenalty`: Defines and implements a data structure for the gap penalties used during a sequence alignment routine.
        * `HSBremen\Component\Alignment\SubstitutionMatrix`: Defines and implements a data structure for the set of substitution scores used during alignment:
        * `HSBremen\Component\Alignment\SubstitutionMatrix\AminoAcid`: Contains substitution matrices for amino acids, e.g. BLOcks of Amino Acid SUbstitution Matrix (BLOSUM).
        * `HSBremen\Component\Alignment\SubstitutionMatrix\Nucleotide`: Contains substitution matrices for nucleotides (e.g. DNA and RNA).
    * The namespace `HSBremen\Application` contains the web application.

* Built with the micro-framework [Silex][21] (+ Symfony2 Components) and the template-engine [Twig][22] to implement the Model View Controller (MVC) architectural pattern.
* Artifacts tested with both static and dynamic test procedures:
  * Component tests (unit tests) implemented with [PHPUnit][19].
  * Static code analysis with the style checker [PHP_CodeSniffer][14] and the source code analyzer [PHP Mess Detector (PHPMD)][18], [phpcpd][4] and [phpdcd][5].
* Provides support for the dependency manager [Composer][3].
* Provides a complete Application Programming Interface (API) documentation generated with the documentation generator [ApiGen][2]. Click [here][1] for the online API documentation.
* Follows the [PSR-0][6] requirements for autoloader interoperability.
* Follows the [PSR-1][7] basic coding style guide.
* Follows the [PSR-2][8] coding style guide.

## Installation

Clone the repository into a new directory using [Git][34]:

    git clone git://github.com/FlorianWolters/SequenceAlignment.git

The command should generate output, similar to the following:

    Cloning into 'SequenceAlignment'...
    remote: Counting objects: 1711, done.
    remote: Compressing objects:  54% (434/803)   eceiving objects:   0% (1/1711)
    remote: Compressing objects: 100% (803/803), done.
    remote: Total 1711 (delta 865), reused 1466 (delta 620)
    Receiving objects: 100% (1711/1711), 753.74 KiB | 339 KiB/s, done.
    Resolving deltas: 100% (865/865), done.

Alternatively, a ZIP-file of the project can be downloaded [here][35].

Install the dependencies of this project with the dependency manager [Composer][3]. [Composer][3] can be installed with [PHP][17]:

    php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"

The command should generate  output, similar to the following:

    All settings correct for using Composer
    Downloading...

    Composer successfully installed to: D:\SequenceAlignment\composer.phar
    Use it: php composer.phar

> This will just check a few [PHP][17] settings and then download `composer.phar` to your working directory. This file is the [Composer][3] binary. It is a PHAR ([PHP][17] archive), which is an archive format for [PHP][17] which can be run on the command line, amongst other things.
>
> Next, run the `install` command to resolve and download dependencies:

    php composer.phar install

Alternatively, the latest snapshot of [Composer][3] can be downloaded [here][20] (in case the download or the installation with [PHP][17] fails).

The automated tests can be run with [PHPUnit][19]:

    phpunit

## Usage

1. Start the application from the root directory of the project:

    php -S 0.0.0.0:8000 -t .

The following should be displayed:

    PHP 5.4.4 Development Server started at Thu Jul 19 20:03:31 2012
    Listening on 0.0.0.0:8000

2. Open `http://localhost:8000` in a webbrowser (e.g. [Mozilla Firefox][36]). The main page of the application should be displayed.
3. Chose the type of sequence to align (DNA, RNA or amino acid) and click on the button `Proceed`.
4. Enter or copy the source (first sequence) and the target (second sequence) in the two text areas. You can chose a substitution matrix optionally.
5. Click on the button `Go`. The sequence alignment is calculated. The result page of the application should be displayed.

## Roadmap/TODO

* Enhance the algorithm `HochschuleBremen\Component\Alignment\SmithWaterman`:

  * Implement gap penalty functionality (gap open and gap extend).
  * Refactoring of the class: Create a class `SequencePair` that contains the alignment pair (now: simple array).

* Remove the labels from the subforms in the form `HochschuleBremen\Application\SequenceAlignment\Form\PairwiseAlignmentType`.
* Fix `TODO` and `@todo` comments in the PHP source code.
* Refactoring of the PHP class `HochschuleBremen\Application\SequenceAlignment\Controller\ControllerProvider`.
* Implement more automated [PHPUnit][19] tests.

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along with this program. If not, see http://gnu.org/licenses/lgpl.txt.



[1]: http://blog.florianwolters.de/SequenceAlignment
[2]: http://apigen.org
[3]: http://getcomposer.org
[4]: https://github.com/sebastianbergmann/phpcpd
[5]: https://github.com/sebastianbergmann/phpdcd
[6]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
[7]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[8]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[14]: http://pear.php.net/package/PHP_CodeSniffer
[17]: http://php.net
[18]: http://phpmd.org
[19]: http://phpunit.de
[20]: http://getcomposer.org/composer.phar
[21]: http://silex.sensiolabs.org
[22]: http://twig.sensiolabs.org
[23]: https://github.com/Seldaek/monolog
[24]: https://github.com/FlorianWolters/PHP-Component-Core-Enum
[25]: https://github.com/FlorianWolters/PHP-Component-Util-Singleton
[26]: http://twitter.github.com/bootstrap
[27]: http://jquery.com
[28]: http://hs-bremen.de
[29]: http://hs-bremen.de/internet/de/studium/stg/infmsc
[30]: http://symfony.com/doc/current/components/yaml.html
[31]: http://symfony.com/doc/current/book/validation.html
[32]: https://github.com/symfony/TwigBridge
[33]: http://symfony.com/doc/current/book/forms.html
[34]: http://git-scm.com
[35]: https://github.com/FlorianWolters/SequenceAlignment/zipball/master
[36]: http://mozilla.org/firefox
