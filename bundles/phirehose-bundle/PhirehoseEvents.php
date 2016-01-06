<?php

namespace Bangpound\PhirehoseBundle;

final class PhirehoseEvents
{
    const TWEET = 'phirehose.tweet';

    // see https://dev.twitter.com/docs/streaming-apis/messages#Public_stream_messages
    const DELETE = 'phirehose.delete';
    const SCRUB_GEO = 'phirehose.scrub_geo';
    const LIMIT = 'phirehose.limit';
    const STATUS_WITHHELD = 'phirehose.status_withheld';
    const USER_WITHHELD = 'phirehose.user_withheld';
    const DISCONNECT = 'phirehose.disconnect';
    const WARNING = 'phirehose.warning';
}
