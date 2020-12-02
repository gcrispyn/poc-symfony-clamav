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

namespace App\Adapter;

/**
 * Interface for adapters managing instances of antivirus.
 *
 * @author Gaël CRISPYN <gael.crispyn@gmail.com>
 */
interface AdapterInterface
{
    /**
     * Check if connection to AV is open
     *
     * @return bool
     */
    public function ping(): bool;

    /**
     * Check if file contains virus or not
     *
     * @param string $path
     * @return bool
     */
    public function scanFile(string $path): bool;
}