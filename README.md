# SequenceAlignment

[![Build Status](https://secure.travis-ci.org/FlorianWolters/SequenceAlignment.png?branch=master)](http://travis-ci.org/FlorianWolters/SequenceAlignment)

Coming soon.

## Introduction

This project is developed during the summer term 2012 of the module *Information Systems in Bioinformatics* at [Hochschule Bremen][10] ([Informatik M.Sc.][11], Graduate Programme *Komplexe Softwaresysteme*).

## Assignment

> Development of a web application demonstrating the calculation of a pairwise sequence alignment so that it can be used for teaching. The focus should be given to explain the calculation of the dynamic programming matrix. In addition, it should be shown how to get the corresponding score(s) and the sequence alignment(s) from this matrix.
>
> The software should be able to handle nucleic acid as well as amino acid sequences.
> * The global alignment variant should be based on the concept of edit distance using the unit cost model.
> * The local alignment variant should be based on similarity using the following matrices as scores: nucleic acids, BLOSUM62 for amino acids.

This project implements the **local alignment variant** of the software.

## TODO

* Make the Smith-Waterman algorithm work with a substitution matrix (API: `new SmithWaterman(SequenceInterface $query, SequenceInterface $target, GapPenalty $gapPenalty, SubstitutionMatrix $subMatrix);`)
* Integration of Help- / Metainformation in Project-Files to auto-include in templates
* [AS] Button for "Next Step", "Next Row", "Complete Alignment"
* Send Input-Formular on Enter
* Provide a "Home" button to return to the index page / provide a "New Search" button
* Complete this `README.md` file (features, usage, description of the algorithm, etc)

## Features

Coming soon.

## Installation

Clone the repository into a new directory.

    git clone git://github.com/FlorianWolters/SequenceAlignment.git

Install the dependencies of this project with the dependency manager [Composer][13]. [Composer][13] can be installed with [PHP][1]:

    php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"

> This will just check a few [PHP][1] settings and then download `composer.phar` to your working directory. This file is the [Composer][13] binary. It is a PHAR ([PHP][1] archive), which is an archive format for [PHP][1] which can be run on the command line, amongst other things.
>
> Next, run the `install` command to resolve and download dependencies:

    php composer.phar install

The latest snapshot of [Composer][13] can be downloaded [here][14] (in case the download or the installation with [PHP][1] fails).

The automated tests can be run with [PHPUnit][19]:

    phpunit

## Used Software

### Server-side

* [PHP][1] 5.4.*
* [Silex][2] 1.1.*
* [Twig][3] 1.8.*
* [Symony\Component\Yaml][12] 2.0.*
* [FlorianWolters\Component\Core\Enum][5] 0.3.*
* [FlorianWolters\Component\Util\Singleton][6] 0.2.*

### Client-side

* [jQuery][8] 1.7.2 (or later)
* [Twitter Bootstrap][7] 2.0.4 (or later)

## License

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public License along with this program. If not, see http://gnu.org/licenses/lgpl.txt.



[1]: http://php.net
[2]: http://silex.sensiolabs.org
[3]: http://twig.sensiolabs.org
[4]: https://github.com/Seldaek/monolog
[5]: https://github.com/FlorianWolters/PHP-Component-Core-Enum
[6]: https://github.com/FlorianWolters/PHP-Component-Util-Singleton
[7]: http://twitter.github.com/bootstrap
[8]: http://jquery.com
[10]: http://hs-bremen.de
[11]: http://hs-bremen.de/internet/de/studium/stg/infmsc
[12]: http://symfony.com/doc/current/components/yaml.html
[13]: http://getcomposer.org
[14]: http://getcomposer.org/composer.phar
