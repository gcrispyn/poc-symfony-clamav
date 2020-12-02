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

use Gedmo\Exception\UploadableFileNotReadableException;
use Socket\Raw\Factory;
use Xenolope\Quahog\Client;
use Xenolope\Quahog\Exception\ConnectionException;
use Xenolope\Quahog\Result;

/**
 * Adapter for ClamAV antivirus interaction
 *
 * @author Gaël CRISPYN <gael.crispyn@gmail.com>
 */
final class ClamAVAdapter implements AdapterInterface
{
    const DEFAULT_TIMEOUT = 30;

    /**
     * @var Client
     */
    protected Client $client;

    public function __construct(string $address, int $timeout = self::DEFAULT_TIMEOUT)
    {
        $socket = (new Factory())->createClient($address);
        $this->client = new Client($socket, $timeout, PHP_NORMAL_READ);
        $this->client->startSession();
    }

    /**
     * {@inheritDoc}
     */
    public function ping(): bool
    {
        try {
            return $this->client->ping();
        } catch (ConnectionException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function scanFile(string $path): bool
    {
        if (! is_readable($path)) {
            throw new UploadableFileNotReadableException("File $path is not readable.");
        }

        /** @var Result $result */
        $result  = $this->client->scanResourceStream(fopen($path, 'rb'));

        return $result->isOk();
    }

    public function __destruct()
    {
        $this->client->endSession();
    }

}