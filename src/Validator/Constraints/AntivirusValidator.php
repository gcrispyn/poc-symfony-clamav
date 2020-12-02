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

use App\Adapter\AdapterManager;
use App\Adapter\AntivirusNotWorkingException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * @author Gaël CRISPYN <gael.crispyn@gmail.com>
 */
class AntivirusValidator extends ConstraintValidator
{
    /**
     * @var \App\Adapter\AdapterInterface
     */
    protected $adapter;

    public function __construct(AdapterManager $adapterManager)
    {
        $this->adapter = $adapterManager->getAdapter();
    }

    /**
     * {@inheritDoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (! $constraint instanceof Antivirus) {
            throw new UnexpectedTypeException($constraint, Antivirus::class);
        }

        if (false === $this->adapter->ping()) {
            throw new AntivirusNotWorkingException('Antivirus is not pingable.');
        }

        if (false === $this->adapter->scanFile($value->getPathName())) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
