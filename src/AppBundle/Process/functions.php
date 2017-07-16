<?php

namespace AppBundle\Process;

use DateTime;
use transducers as t;

/**
 * @param $value
 *
 * @return mixed
 */
function flattenEntity($value)
{
    if (isset($value['expanded_url'])) {
        return $value['expanded_url'];
    }

    if (isset($value['text'])) {
        return $value['text'];
    }

    if (isset($value['screen_name'])) {
        return $value['screen_name'];
    }
}

/**
 * @param $value
 *
 * @return string
 */
function formatTwitterTimeForGoogle($value)
{
    return DateTime::createFromFormat('D M j H:i:s P Y', $value)->format('Y-m-d H:i:s');
}

function mapCommon($v)
{
    $v['created_at'] = formatTwitterTimeForGoogle($v['created_at']);

    return $v;
}

function mapTweet($v)
{
    $v = mapCommon($v);

    if (isset($v['entities'])) {
        $v['entities'] = t\xform($v['entities'], t\map('Nab3aBundle\Process\mapEntities'));
    }
    if (isset($v['extended_entities'])) {
        $v['extended_entities'] = t\xform($v['extended_entities'], t\map('Nab3aBundle\Process\mapEntities'));
    }

    if (isset($v['quoted_status'])) {
        $statuses = [$v['quoted_status']];
        $statuses = t\xform($statuses, t\map('Nab3aBundle\Process\mapTweet'));
        $v['quoted_status'] = $statuses[0];
    }

    if (isset($v['retweeted_status'])) {
        $statuses = [$v['retweeted_status']];
        $statuses = t\xform($statuses, t\map('Nab3aBundle\Process\mapTweet'));
        $v['retweeted_status'] = $statuses[0];
    }

    if (isset($v['user'])) {
        $users = [$v['user']];
        $users = t\xform($users, t\map('Nab3aBundle\Process\mapUser'));
        $v['user'] = $users[0];
    }

    return $v;
}

function mapEntities($v)
{
    switch ($v[0]) {
        case 'hashtags':
        case 'symbols':
            $key = 'text';
            break;
        case 'urls':
        case 'media':
            $key = 'expanded_url';
            break;
        case 'user_mentions':
            $key = 'screen_name';
            break;
    }

    $f = function ($v) use ($key) {
        return $v[$key];
    };
    $xf = t\comp(
      t\mapcat($f),
      t\interpose(', ')
    );
    $v[1] = t\transduce($xf, t\string_reducer(), $v[1]);

    return $v;
}

function mapUser($v)
{
    $v = mapCommon($v);

    if (isset($v['entities'])) {
        foreach ((array) $v['entities'] as &$entries) {
            $entries = t\xform($entries, t\comp(
              t\map('Nab3aBundle\Process\mapEntities')
            ));
        }
    }

    return $v;
}

function filterNulls($v)
{
    return array_filter($v, 'Nab3aBundle\Process\isNull');
}

function isNull($v)
{
    return null !== $v;
}
