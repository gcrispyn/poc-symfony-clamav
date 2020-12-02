<?php

declare(strict_types=1);

/*
 * This file is part of the Antivirus Validator package.
 *
 * (c) Gael CRISPYN <gael.crispyn@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 *
 * @author Gaël CRISPYN <gael.crispyn@gmail.com>
 */
class Antivirus extends Constraint
{
    const HAS_ANTIVIRUS_ERROR = 'HAS_ANTIVIRUS_ERROR';

    protected static $errorNames = [
        self::HAS_ANTIVIRUS_ERROR => 'HAS_ANTIVIRUS_ERROR',
    ];

    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public string $message = 'The file could not be uploaded. A virus has been found';
}
