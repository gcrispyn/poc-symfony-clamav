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
 * Manager of Antivirus adapters
 *
 * @author Gaël CRISPYN <gael.crispyn@gmail.com>
 */
final class AdapterManager
{
    const CLAMAV_KEY = 'clamav';

    const ADAPTER_MAP = [
        'clamav' => ClamAVAdapter::class
    ];

    /**
     * @var string
     */
    protected string $type;

    /**
     * @var string
     */
    protected string $address;

    public function __construct(string $type, string $address)
    {
        $this->type    = $type;
        $this->address = $address;
    }

    /**
     * Returns the best possible adapter that your runtime supports.
     *
     * @return AdapterInterface
     */
    public function getAdapter(): AdapterInterface
    {
        if (false === array_key_exists($this->type, self::ADAPTER_MAP)) {
            throw new AntivirusAdapterNotFoundException("Type {$this->type} doesn't exists.");
        }

        $className = self::ADAPTER_MAP[$this->type];

        return new $className($this->address);
    }
}