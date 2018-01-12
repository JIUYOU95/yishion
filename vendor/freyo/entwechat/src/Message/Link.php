<?php

namespace EntWeChat\Message;

/**
 * Class Link.
 *
 * @property string $title
 * @property string $description
 * @property string $url
 */
class Link extends AbstractMessage
{
    /**
     * Message type.
     *
     * @var string
     */
    protected $type = 'link';

    /**
     * Properties.
     *
     * @var array
     */
    protected $properties = [
        'title',
        'description',
        'url',
    ];
}
